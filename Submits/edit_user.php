<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);
$verification = new Fetch($connection);

if (Inputs::submitType()) {
	$id = Inputs::assignValue('id');
	$admin_id = Inputs::assignValue('admin_id');
	$account_status = Inputs::assignValue('account_status');
	$user_group = Inputs::assignValue('user_group');
	$admin_password = Inputs::assignValue('admin_password');
	$updated_at = date('Y-m-d H:i:s');

	//check whether admin password is correct
	$check_admin_password = $verification->getSingleData('SELECT password', 'User', array('id', '=', $admin_id));
	if(false === password_verify($admin_password, $check_admin_password->password)) {
		$_SESSION['error'] = 'Admin password incorrect';
		header('location: ../Warehouse/edit_user.php?id='.$id);
	} else {
		$database->update('User', $id, array(
			'status' => $account_status,
			'user_group' => $user_group,
			'updated_at' => $updated_at
		));

		$_SESSION['success'] = 'User update successfull';
		header('location: ../Warehouse/edit_user.php?id='.$id);
	}
	
} else {
	die('requested page not found');
}