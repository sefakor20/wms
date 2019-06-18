<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

//deactivate company
if (isset($_GET['company_deactivate'])) {
	$id = (int)$_GET['company_deactivate'];
	$updated_at = date('Y-m-d H:i:s');

	$database->update('Company', $id, array(
		'status' => 2,
		'updated_at' => $updated_at
	));

	header('location: ../Warehouse/customers.php');
}


//activate company
if (isset($_GET['company_activate'])) {
	$id = (int)$_GET['company_activate'];
	$updated_at = date('Y-m-d H:i:s');

	$database->update('Company', $id, array(
		'status' => 1,
		'updated_at' => $updated_at
	));

	header('location: ../Warehouse/customers.php');
}


//deactivate employee
if (isset($_GET['employee_deactivate'])) {
	$id = (int)$_GET['employee_deactivate'];
	$updated_at = date('Y-m-d H:i:s');

	$database->update('User', $id, array(
		'status' => 2,
		'updated_at' => $updated_at
	));

	header('location: ../Warehouse/employees.php');
}


//activate employee
if (isset($_GET['employee_activate'])) {
	$id = (int)$_GET['employee_activate'];
	$updated_at = date('Y-m-d H:i:s');

	$database->update('User', $id, array(
		'status' => 1,
		'updated_at' => $updated_at
	));

	header('location: ../Warehouse/employees.php');
}

?>