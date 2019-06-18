<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);
$duplicate_username = new Fetch($connection);

if(Inputs::submitType()) {
	$first_name = Inputs::assignValue('first_name');
	$last_name = Inputs::assignValue('last_name');
	$other_name = Inputs::assignValue('other_name');
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
		header('location: ../Warehouse/add_employee.php');
		exit();
	}
	$result_2 = $duplicate_username->getSingleData('SELECT id', 'Company', array('username', '=', $username));
	if (!empty($result_2)) {
		$_SESSION['error'] = 'Username: '.$username.' already exists';
		header('location: ../Warehouse/add_employee.php');
		exit();
	}

	if($password === $confirm_password) {
		$password = password_hash($password, PASSWORD_DEFAULT);

		$database->insert('User', array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'other_name' => $other_name,
			'user_group' => $user_group,
			'status' => $account_status,
			'password' => $password,
			'username' => $username,
			'created_at' => $created_at
		));

		$_SESSION['success'] = 'User added successfully';
		header('location: ../Warehouse/add_employee.php');

	} else {
		$_SESSION['error'] = 'Passwords do not match';
		header('location: ../Warehouse/add_employee.php');
	}

} else {
	die('requested page not found');
}


?>