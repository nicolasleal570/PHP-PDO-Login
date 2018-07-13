<?php

function escape($string){
	//CONVIRTIENDO CARACTERES MALISIOSOS EN TEXTO
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}