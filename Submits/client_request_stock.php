<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$client_id = Inputs::assignValue('client_id');
	$item_id = Inputs::assignValue('item_id');
	$category_id = Inputs::assignValue('category_id');
	$quantity = Inputs::assignValue('quantity');
	$created_at = date('Y:m:d H:i:s');
	$id = (int)$_POST['id'];

	$database->insert('Client_Stock_Request', array(
		'item_id' => $item_id,
		'category_id' => $category_id,
		'quantity' => $quantity,
		'client_id' => $client_id,
		'status' => 1,
		'created_at' => $created_at
	));
	$_SESSION['success'] = 'Request made successfully';
	header('location: ../Client/selected_request_stock.php?id='.$id);
	
} else {
	die('requested page not found');
}

?>