<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);
$duplicate_username = new Fetch($connection);

if(Inputs::submitType()) {
	$name = Inputs::assignValue('name');
	$tel = Inputs::assignValue('tel');
	$username = Inputs::assignValue('username');
	$password = Inputs::assignValue('password');
	$user_group = Inputs::assignValue('user_group');
	$account_status = Inputs::assignValue('account_status');
	$confirm_password = Inputs::assignValue('confirm_password');
	$created_at = date('Y-m-d H:i:s');

	//checking for duplicate username
	$result = $duplicate_username->getSingleData('SELECT id', 'User', array('username', '=', $username));
	if(!empty($result)) {
		$_SESSION['error'] = 'Username: '.$username.' already exists';
		header('location: ../Warehouse/add_customer.php');
		exit();
	}
	$result_2 = $duplicate_username->getSingleData('SELECT id', 'Company', array('username', '=', $username));
	if (!empty($result_2)) {
		$_SESSION['error'] = 'Username: '.$username.' already exists';
		header('location: ../Warehouse/add_customer.php');
		exit();
	}

	if($password === $confirm_password) {
		$password = password_hash($password, PASSWORD_DEFAULT);

		$database->insert('Company', array(
			'name' => $name,
			'user_group' => $user_group,
			'status' => $account_status,
			'username' => $username,
			'password' => $password,
			'tel' => $tel,
			'created_at' => $created_at
		));

		$_SESSION['success'] = 'Company added successfully';
		header('location: ../Warehouse/add_customer.php');

	} else {
		$_SESSION['error'] = 'Passwords do not match';
		header('location: ../Warehouse/add_customer.php');
	}

} else {
	die('requested page not found');
}


?>