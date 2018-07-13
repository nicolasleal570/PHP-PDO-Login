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
$users = DB::getInstance()->get('users', array('username', '=', 'alex')); /* DEVUELVE TODOS LOS 'username' QUE ESTAN EN LA TABLA 'users' QUE SEAN IGUALES AL NOMBRE DE 'alex' */

if ($users->count()) { //COMPRUEBA QUE HAYAN RESULTADOS
	foreach ($users as $user) {
		echo $user->username; //DEVUELVE TODA LA INFORMACION DEL CAMPO 'username'
	}
}