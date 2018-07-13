<?php

class User{
    
    private $_db;

    /*-------------------------------*/
    /* CREANDO LA INSTANCIA DE LA DB */
    /*-------------------------------*/
    public function __construct($user = null) {
        $this->_db = DB::getInstance();
    }

    
    /*--------------------------*/
    /* CREANDO UN NUEVO USUARIO */
    /*--------------------------*/
    public function create($fields = array()){
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('Tuvimos un problema al crear tu cuenta!');
        }
    }


}







?>