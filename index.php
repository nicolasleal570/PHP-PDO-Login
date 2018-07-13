<?php

require_once 'core/init.php';

$user = DB::getInstance()->update('users', 3,  array(
	'username' => 'Alex',
	'password' => '12345',
	'salt' => 'salt',
	'name'=> 'Alex Vega',
	'joined' => '2018-07-13 12:25:00',
	'type' => 1
));




?>