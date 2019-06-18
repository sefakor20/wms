<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$name = Inputs::assignValue('name');

	$database->insert('Category', array(
		'name' => $name
	));
	$_SESSION['success'] = 'Category added successfully';
	header('location: ../Warehouse/add_item.php');
	
} else {
	die('requested page not found');
}

?>