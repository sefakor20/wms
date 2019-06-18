<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);
$fetch_data = new Fetch($connection);

//client approve stock
if (isset($_GET['wrs_id']) && isset($_GET['client_id'])) {
	$id = (int)$_GET['wrs_id'];
	$client_id = (int)$_GET['client_id'];
	$item_id = (int)$_GET['item_id'];
	$category_id = (int)$_GET['category_id'];
	$released_quantity = (int)$_GET['released_quantity'];
	$created_at = date('Y:m:d H:i:s');

	//subtract released quantity from warehouse stock
	$warehouse_quantity = $fetch_data->compareTwoItems("SELECT id, quantity", 'Warehouse_Stock', 'item_id', $item_id, 'category_id', $category_id);
	$new_warehouse_quantity = $warehouse_quantity->quantity - $released_quantity;
	/*
	assuming warehouse releases stock and client did not approve, warehouse still has those items in stock and can be released to another client. that is why subtraction of stock from warehouse is done after the client approves items. prompt the client if warehouse do not meet demanded stock maybe due to delay in approval from client's point and the items are released to another client
	*/
	if ($new_warehouse_quantity < 0) {
		$_SESSION['error'] = 'Due to delay in your approval, these items have released to another client. Report to warehouse for more clarifications. Thank you!';
		header('location: ../Client/waiting_approval.php');
		exit();	
	}

	$database->update('Warehouse_Stock', $warehouse_quantity->id, array(
		'quantity' => $new_warehouse_quantity,
		'updated_at' => $created_at
	));

	//check whether the item already exists in stock, if so, add new quantity to the previous one 
	$existing_stock = $fetch_data->compareThreeItems("SELECT id, quantity", 'Client_Stock', 'category_id', $category_id, 'item_id', $item_id, 'client_id', $client_id);

	if (empty($existing_stock)) {
		//populate 'Client_Stock'
		$database->insert('Client_Stock', array(
			'item_id' => $item_id,
			'category_id' => $category_id,
			'quantity' => $released_quantity,
			'client_id' => $client_id,
			'created_at' => $created_at
		));
	} else {
		$new_quantity = $existing_stock->quantity + $released_quantity;

		$database->update('Client_Stock', $existing_stock->id, array(
		'quantity' => $new_quantity,
		'updated_at' => $created_at		
		));
	}

	//populate 'Warehouse_All_Release_Stock'
	$database->insert('Warehouse_All_Release_Stock', array(
		'item_id' => $item_id,
		'category_id' => $category_id,
		'quantity' => $released_quantity,
		'client_id' => $client_id,
		'created_at' => $created_at
	));

	//changing the status
	$database->update('Warehouse_Release_Stock', $id, array(
		'status' => 2			
	));

	$_SESSION['success'] = 'Operation successful';
	header('location: ../Client/waiting_approval.php');

}