<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if(Inputs::submitType()) {
	$content = Inputs::assignValue('content');
	$id = Inputs::assignValue('id');
	$created_at = date('Y-m-d H:i:s');

	$database->update('Employee_Report', $id, array(
		'content' => $content,
		'updated_at' => $created_at
	));

	$_SESSION['success'] = 'Report updated successfully';
	header('location: ../Employee/Warehouse/edit_report.php?id='.$id);

} else {
	die('requested page not found');
}


?>