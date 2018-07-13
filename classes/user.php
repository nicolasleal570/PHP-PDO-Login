<?php

class User{
    
    private $_db,
            $_data,
            $_sessionName, 
            $_isLoggedIn;

    /*-------------------------------*/
    /* CREANDO LA INSTANCIA DE LA DB */
    /*-------------------------------*/
    public function __construct($user = null) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');

        if (!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if($this->find($user)) {
                    $this->isLoggedIn = true;
                } else {
                    //Logout
                }
            }
        } else {
            $this->find($user);
        }

        
    }

    
    /*--------------------------*/
    /* CREANDO UN NUEVO USUARIO */
    /*--------------------------*/
    public function create($fields = array()){
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('Tuvimos un problema al crear tu cuenta!');
        }
    }

    /*--------------------*/
    /* BUSCAR UN USUARIO  */
    /*--------------------*/
    public function find($user = null){
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                //CONTIENE TODA LA DATA DEL USUARIO
                $this->_data = $data->first();
                return true;
            }
        }

        return false;
    }

    /*--------------------------------*/
    /* VALIDANDO EL LOGIN DEL USUARIO */
    /*--------------------------------*/
    public function login($username = null, $password = null){

        $user = $this->find($username);
        
        if ($user) {
            //COMPROBANDO QUE LAS PASSWORDS COINCIDAN
            if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                Session::put($this->_sessionName, $this->data()->id);
                return true;
            }
        }

        return false;
    }

    /*-----------------------------*/
    /* RETORNA LA DATA DEL USUARIO */
    /*-----------------------------*/
    public function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }


}







?>