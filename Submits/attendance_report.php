<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$personnel_id = Inputs::assignValue('personnel_id');
	$content = Inputs::assignValue('content');
	$created_at = date('Y:m:d H:i:s');

	$database->insert('Employee_Report', array(
		'personnel_id' => $personnel_id,
		'content' => $content,
		'created_at' => $created_at
	));
	$_SESSION['success'] = 'Report submitted successfully';
	header('location: ../Employee/Warehouse/add_attendance_report.php');
	
} else {
	die('requested page not found');
}

?>