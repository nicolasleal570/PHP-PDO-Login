<?php

require_once 'core/init.php';

// RECIBIENDO EL REGISTRO EXITOSO 
if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}




?>