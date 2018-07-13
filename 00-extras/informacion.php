<?php
/**
*
* CLASE CONFIG
*
*/
echo Config::get('mysql/host'), '<br>'; //DEVUELVE EL STRING DE LA SIRECCION DE LA VARIABLE SUPER GLOBAL 'config'

/**
 * 
 * CLASE DB
 * 
 */
DB::getInstance()->get('users', array('username', '=', 'nleal')); /* DEVUELVE EL 'username' QUE SEA IGUAL A 'nleal' */

//RECUPERA EL OBJETO DEVUELTO EN EL METODO 'query()' Y PODEMOS ACCEDER A SUS PROPIEDADES
foreach ($user->results() as $user) {
	echo $user->username, '<br>';
}

//$sql = INSERT INTO users (`username`, `password`, `salt`, `name`, `joined`, `type`);
$sql = "INSERT INTO users (`" . implode('`, `', $keys) . "`)";

//---ASI SE INSERTAN DATOS NUEVOS EN LA DB
// 'users' = tabla || array() = datos que se quieren insertar
$user = DB::getInstance()->insert('users', array(
	'username' => 'Alex',
	'password' => '12345',
	'salt' => 'salt'
));


//---ASI SE ACTUALIZAN DATOS EN LA DB
// 'users' = tabla || 3 = id del usuario || array() = datos que se quieren insertar
$user = DB::getInstance()->update('users', 3,  array(
	'username' => 'Alex',
	'password' => '12345',
	'salt' => 'salt',
	'name'=> 'Alex Vega',
	'joined' => '2018-07-13 12:25:00',
	'type' => 1
));