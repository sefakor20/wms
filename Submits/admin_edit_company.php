<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);

if(Inputs::submitType()) {
	$name = Inputs::assignValue('name');
	$id = Inputs::assignValue('id');
	$user_group = Inputs::assignValue('user_group');
	$account_status = Inputs::assignValue('account_status');
	$created_at = date('Y-m-d H:i:s');

	$database->update('Company', $id, array(
		'status' => $account_status,
		'user_group' => $user_group,
		'name' => $name,
		'updated_at' => $created_at
	));

	$_SESSION['success'] = 'Account updated successfully';
	header('location: ../Warehouse/edit_company.php?id='.$id);

} else {
	die('requested page not found');
}


?>