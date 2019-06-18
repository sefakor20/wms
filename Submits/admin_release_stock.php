<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$requested_quantity = Inputs::assignValue('requested_quantity');
	$item_id = Inputs::assignValue('item_id');
	$id = Inputs::assignValue('id');
	$client_id = Inputs::assignValue('client_id');
	$category_id = Inputs::assignValue('category_id');
	$personnel_id = Inputs::assignValue('personnel_id');
	$note = Inputs::assignValue('note');
	$released_quantity = Inputs::assignValue('released_quantity');
	$stock_quantity = Inputs::assignValue('stock_quantity');
	$created_at = date('Y:m:d H:i:s');

	//check whether quantity to be released is more than requested quantity
	if ($released_quantity > $requested_quantity) {
		$_SESSION['error'] = 'Quantity to be released is more than requested';
		header('location: ../Warehouse/release_stock.php?id='.$id);
		exit();
	}

	//check whether quantity to be released is more than available quantity
	if ($released_quantity > $stock_quantity) {
		$_SESSION['error'] = 'You do not have enough stock for released quantity';
		header('location: ../Warehouse/release_stock.php?id='.$id);
		exit();
	}
	/*
	//check whether the expiry date is valid
	$expiry_date_check = date('Y:m:d');
	if ($expiry_date < $expiry_date_check || $expiry_date == $expiry_date_check) {
		$_SESSION['error'] = 'Sorry, item expired';
		header('location: ../Warehouse/release_stock.php?id='.$id);
		exit();
	}*/

	$database->insert('Warehouse_Release_Stock', array(
		'client_id' => $client_id,
		'item_id' => $item_id,
		'category_id' => $category_id,
		'requested_quantity' => $requested_quantity,
		'released_quantity' => $released_quantity,
		'status' => 1,
		'note' => $note,
		'personnel_id' => $personnel_id,
		'created_at' => $created_at
	));

	//setting new stock request quantity
	$new_qty = $requested_quantity - $released_quantity;
	$database->update('Client_Stock_Request', $id, array(
		'quantity' => $new_qty			
	));

	//set request status to be 'incomplete' if all quantity not met
	if ($new_qty > 0) {
		$database->update('Client_Stock_Request', $id, array(
			'status' => 2,
			'updated_at' => $created_at			
		));
	}

	//set request status to 'complete' if all quantity is met
	if ($new_qty == 0) {
		$database->update('Client_Stock_Request', $id, array(
			'status' => 3,
			'updated_at' => $created_at			
		));
	}

	$_SESSION['success'] = 'Operation successful';
	header('location: ../Warehouse/release_stock.php?id='.$id);
	
} else {
	die('requested page not found');
}

?>