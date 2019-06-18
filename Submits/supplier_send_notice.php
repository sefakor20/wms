<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$id = Inputs::assignValue('id');
	$title = Inputs::assignValue('title');
	$item_id = Inputs::assignValue('item_id');
	$category_id = Inputs::assignValue('category_id');
	$supplier_id = Inputs::assignValue('supplier_id');
	$content = Inputs::assignValue('content');
	$created_at = date('Y:m:d H:i:s');

	$database->insert('Supplier_Notice', array(
		'item_id' => $item_id,
		'category_id' => $category_id,
		'supplier_id' => $supplier_id,
		'notice_status' => 2,
		'title' => $title,
		'content' => $content,
		'created_at' => $created_at
	));
	$_SESSION['success'] = 'Notice Sent';
	header('location: ../Supplier/send_notice.php?id='.$id);
	
} else {
	die('requested page not found');
}

?>