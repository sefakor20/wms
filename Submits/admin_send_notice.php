<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$id = Inputs::assignValue('id');
	$item_id = Inputs::assignValue('item_id');
	$category_id = Inputs::assignValue('category_id');
	$client_id = Inputs::assignValue('client_id');
	$personnel_id = Inputs::assignValue('personnel_id');
	$title = Inputs::assignValue('title');
	$content = Inputs::assignValue('content');
	$created_at = date('Y:m:d H:i:s');

	$database->insert('Warehouse_Notice', array(
		'item_id' => $item_id,
		'category_id' => $category_id,
		'personnel_id' => $personnel_id,
		'notice_status' => 2,
		'client_id' => $client_id,
		'title' => $title,
		'content' => $content,
		'created_at' => $created_at
	));
	$_SESSION['success'] = 'Notice sent';
	header('location: ../Warehouse/send_notice.php?id='.$id);
	
} else {
	die('requested page not found');
}

?>