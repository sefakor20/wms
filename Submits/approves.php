<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);
$fetch_data = new Fetch($connection);

//warehouse approve stock
if (isset($_GET['wa_id']) && isset($_GET['personnel_id'])) {
	$id = (int)$_GET['wa_id'];
	$personnel_id = (int)$_GET['personnel_id'];
	$item_id = (int)$_GET['item_id'];
	$category_id = (int)$_GET['category_id'];
	$released_quantity = (int)$_GET['released_quantity'];
	$expiry_date = Inputs::assignValue('expiry');
	$created_at = date('Y:m:d H:i:s');
	$supplier_id = (int)$_GET['supplier_id'];

	//check whether the item already exists in stock, if so, add new quantity to the previous one 
	$existing_stock = $fetch_data->compareTwoItems("SELECT id, quantity", 'Warehouse_Stock', 'category_id', $category_id, 'item_id', $item_id);

	if (empty($existing_stock)) {
		//populate 'Warehouse_Stock'
		$database->insert('Warehouse_Stock', array(
			'item_id' => $item_id,
			'category_id' => $category_id,
			'quantity' => $released_quantity,
			'expiry_date' => $expiry_date,
			'personnel_id' => $personnel_id,
			'supplier_id' => $supplier_id,
			'created_at' => $created_at
		));
	} else {
		$new_quantity = $existing_stock->quantity + $released_quantity;

		$database->update('Warehouse_Stock', $existing_stock->id, array(
		'quantity' => $new_quantity,
		'expiry_date' => $expiry_date,
		'updated_at' => $created_at		
		));
	}

	//populate 'Warehouse_All_Stock'
	$database->insert('Warehouse_All_Stock', array(
		'item_id' => $item_id,
		'category_id' => $category_id,
		'quantity' => $released_quantity,
		'expiry_date' => $expiry_date,
		'personnel_id' => $personnel_id,
		'supplier_id' => $supplier_id,
		'created_at' => $created_at
	));

	//changing the status
	$database->update('Supplier_Release_Stock', $id, array(
		'status' => 2			
	));

	$_SESSION['success'] = 'Operation successful';
	header('location: ../Warehouse/waiting_approval.php');

}


?>