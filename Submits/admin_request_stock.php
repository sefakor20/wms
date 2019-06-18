<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$personnel_id = Inputs::assignValue('personnel_id');
	$item_id = Inputs::assignValue('item_id');
	$category_id = Inputs::assignValue('category_id');
	$supplier_id = Inputs::assignValue('supplier_id');
	$quantity = Inputs::assignValue('quantity');
	$created_at = date('Y:m:d H:i:s');

	$database->insert('Warehouse_Stock_Request', array(
		'item_id' => $item_id,
		'category_id' => $category_id,
		'quantity' => $quantity,
		'supplier_id' => $supplier_id,
		'request_status' => 1,
		'personnel_id' => $personnel_id,
		'created_at' => $created_at
	));
	$_SESSION['success'] = 'Request made successfully';
	header('location: ../Warehouse/stock.php');
	
} else {
	die('requested page not found');
}

?>