<?php

require_once 'core/init.php';

echo Config::get('mysql/host'), '<br>'; //CLASE CONFIG

$user = DB::getInstance()->get('users', array('username', '=', 'nleal'));

if (!$user->count()) {
	echo 'No user';
}else{
	echo 'OK!';
}



?>