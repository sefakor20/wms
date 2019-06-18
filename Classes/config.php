<?php
try {
	$connection = new PDO('mysql:dbname=wms;host=localhost', 'root', 'newpassword');
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	die($e->getMessage());
}

error_reporting(0);
