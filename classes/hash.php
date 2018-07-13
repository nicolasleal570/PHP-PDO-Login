<?php 

class Hash{
    
    /*-----------------------------------------------*/
    /* CREA UNA NUEVA STRING CON LA SALT CONCATENADA */
    /*-----------------------------------------------*/
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }

    /*---------------------*/
    /* CREA UNA NUEVA SALT */
    /*---------------------*/
    public static function salt($length){
        return mcrypt_create_iv($length);
    }

    /*-----------------*/
    /* RETORNA EL HASH */
    /*-----------------*/
    public static function unique(){
        return self::make(uniqid());
    }


}
