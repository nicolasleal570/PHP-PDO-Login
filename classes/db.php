<?php 

class DB{
	
	private static $_instance = null;
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0;

	/*------------------------------------*/
	/* INICIALIZANDO LA BASE DE DATOS PDO */
	/*------------------------------------*/
	private function __construct() {
		try{
			$this->_pdo = new PDO('mysql:host='. Config::get('mysql/host') .'; dbname='. Config::get('mysql/db') , Config::get('mysql/username'), Config::get('mysql/password'));
		}catch(PDOException $e){
			die($e->getMessage());
		}

	}

	/*---------------------------------------------------------------*/
	/* METE LA BD PDO CREADA EN UNA VARIABLE PARA PODER INSTANCIARLA */
	/*---------------------------------------------------------------*/
	public static function getInstance(){
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	/*--------------------------------------------------*/
	/* PREPARA LAS SENTENCIA SQL PARA EJECUTAR UN QUERY */
	/*--------------------------------------------------*/
	public function query($sql, $params = array()){
		$this->_error = false;		

		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				//RECORRE LOS VALORES QUE LE AGREGAN MEDIANTE EL ARRAY PARA LUEGO HACER LA BUSQUEDA
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if ($this->_query->execute()) {
				//PONIENDO EL RESULTADO DEL QUERY EN UN OBJETO
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();

			}else{
				$this->_error = true;
			}
		}

		return $this;
	}

	/*-------------------------------*/
	/* LLAMADA A LA ACCION DEL QUERY */
	/*-------------------------------*/
	public function action($action, $table, $where = array()){
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '<=', '>=');

			$field    = $where[0];
			$operator = $where[1];
			$value    = $where[2];

			//ACOMODA TODOS LOS OPERADORES, TABLA Y DATOS PARA  HACER LA SETENCIA SQL Y EJECUTARLA
			if (in_array($operator, $operators)) {
			  /*$sql = "SELECT * FROM users WHERE username = 'Alex'"; D E M O S T R A C I O N */
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}

		return false;
	}

	/*-----------------------------------------*/
	/* OBTIENES LOS DATOS QUE SE PASAN POR SQL */
	/*-----------------------------------------*/
	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}

	/*----------------------------------------------*/
	/* ELIMINA LOS DATOS QUE SE LE PASEN POR EL SQL */
	/*----------------------------------------------*/
	public function delete($table, $where){
		return $this->action('DELETE', $table, $where);
	}

	/*------------------------*/
	/* INSERTA DATOS EN LA BD */
	/*------------------------*/
	public function insert($table, $fields = array()){
		$keys = array_keys($fields);
		$values = '';
		$x = 1;

		//PONE TODOS LOS VALORES EN UNA CADENA SEPARADOS POR COMAS, ELIMINANDO LA ULTIMA
		foreach ($fields as $field) {
			$values .= '?';
			if ($x < count($fields)) {
				$values .= ', ';
			}
			$x++;
		}

		$sql = "INSERT INTO users (`" . implode('`, `', $keys) . "`) VALUES({$values})";

		//EJECUTA EL QUERY Y HACE LA INSERCION
		if (!$this->query($sql, $fields)->error()) {
			return true;
		}

		return false;
	}

	/*--------------------------*/
	/* ACTUALIZA DATOS EN LA BD */
	/*--------------------------*/
	public function update($table, $id, $fields){
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";

			if ($x < count($fields)) {
				$set .= ", ";
			}
			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

		//EJECUTA EL QUERY Y HACE LA INSERCION
		if (!$this->query($sql, $fields)->error()) {
			return true;
		}

		return false;
	}

	/*-------------------------------------------------*/
	/* RECUPERA EL OBJETO QUE DEVUELVE EL METODO QUERY */
	/*-------------------------------------------------*/
	public function results(){
		return $this->_results;
	}

	/*----------------------------------------*/
	/* DEVUELVE EL PRIMER RESULTADO DEL QUERY */
	/*----------------------------------------*/
	public function first(){
		return $this->results()[0];
	}

	/*---------------------------------------*/
	/* DEVUELVE LOS ERRORES DE LAS CONSULTAS */
	/*---------------------------------------*/
	public function error(){
		return $this->_error;
	}

	/*----------------------------------------*/
	/* VALIDA SI EL QUERY DEVUELVE DATOS O NO */
	/*----------------------------------------*/
	public function count(){
		return $this->_count;
	}



}
