<?php

require_once 'core/init.php';

echo Config::get('mysql/host'), '<br>'; //CLASE CONFIG

DB::getInstance();

/* $users = DB::getInstance()->get('users', array('username', '=', 'alex'));
if ($users->count()) {
	foreach ($users as $user) {
		echo $user->username;
	}
} */



?>