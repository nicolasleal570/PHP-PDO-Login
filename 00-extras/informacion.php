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
