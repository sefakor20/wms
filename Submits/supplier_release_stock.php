<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if (Inputs::submitType()) {
	$requested_quantity = Inputs::assignValue('requested_quantity');
	$item_id = Inputs::assignValue('item_id');
	$id = Inputs::assignValue('id');
	$category_id = Inputs::assignValue('category_id');
	$supplier_id = Inputs::assignValue('supplier_id');
	$expiry_date = Inputs::assignValue('expiry_date');
	$note = Inputs::assignValue('note');
	$released_quantity = Inputs::assignValue('released_quantity');
	$created_at = date('Y:m:d H:i:s');

	//check whether quantity to be released is more than requested quantity
	if ($released_quantity > $requested_quantity) {
		$_SESSION['error'] = 'Quantity to be released is more than requested';
		header('location: ../Supplier/release_stock.php?id='.$id);
		exit();
	}

	//check whether the expiry date is valid
	$expiry_date_check = date('Y:m:d');
	if ($expiry_date < $expiry_date_check || $expiry_date == $expiry_date_check) {
		$_SESSION['error'] = 'Sorry, item expired';
		header('location: ../Supplier/release_stock.php?id='.$id);
		exit();
	}

	$database->insert('Supplier_Release_Stock', array(
		'supplier_id' => $supplier_id,
		'item_id' => $item_id,
		'category_id' => $category_id,
		'status' => 1,
		'requested_quantity' => $requested_quantity,
		'released_quantity' => $released_quantity,
		'expiry_date' => $expiry_date,
		'note' => $note,
		'created_at' => $created_at
	));

	//setting new stock request quantity
	$new_qty = $requested_quantity - $released_quantity;
	$database->update('Warehouse_Stock_Request', $id, array(
		'quantity' => $new_qty			
	));

	//set request status to be 'incomplete' if all quantity not met
	if ($new_qty > 0) {
		$database->update('Warehouse_Stock_Request', $id, array(
			'request_status' => 2,
			'updated_at' => $created_at			
		));
	}

	//set request status to 'complete' if all quantity is met
	if ($new_qty == 0) {
		$database->update('Warehouse_Stock_Request', $id, array(
			'request_status' => 3,
			'updated_at' => $created_at			
		));
	}

	$_SESSION['success'] = 'Operation successful';
	header('location: ../Supplier/release_stock.php?id='.$id);
	
} else {
	die('requested page not found');
}

?>