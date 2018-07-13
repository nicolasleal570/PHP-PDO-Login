<?php

require_once 'core/init.php';

// RECIBIENDO EL REGISTRO EXITOSO 
if (Session::exists('success')) {
	echo Session::flash('success');
}




?>