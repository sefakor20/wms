<?php
session_start();

set_exception_handler(function($exception){
	exit($exception->getMessage());
});

/*
function __autoload($class_name) {
	$path = "/Classes/{$class_name}.php";
	if(file_exists($path)) {
		require_once dirname(__DIR__).$path;
	} else {
		die($path.' not found');
	}
}*/

require_once dirname(__DIR__).'/Classes/config.php';
require_once dirname(__DIR__).'/Classes/Database.php';
require_once dirname(__DIR__).'/Classes/Inputs.php';
require_once dirname(__DIR__).'/Classes/Filter.php';
require_once dirname(__DIR__).'/Classes/DateFormat.php';
require_once dirname(__DIR__).'/Classes/Login.php';
require_once dirname(__DIR__).'/Classes/FileUpload.php';
require_once dirname(__DIR__).'/Classes/Fetch.php';
require_once dirname(__DIR__).'/Classes/ShortNumberFormat.php';

?>