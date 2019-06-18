<?php
require_once dirname(__DIR__).'/Core/init.php';

$database = new Database($connection);
$verification = new Fetch($connection);

if(Inputs::submitType()) {
	$id = Inputs::assignValue('id');
	$username = Inputs::assignValue('username');
	$tel = Inputs::assignValue('tel');
	$new_password = Inputs::assignValue('new_password');
	$confirm_password = Inputs::assignValue('confirm_password');
	$old_password = Inputs::assignValue('old_password');
	$updated_at = date('Y-m-d H:i:s');

	//checking for duplicate username
	$duplicate_username = $verification->getSingleData('SELECT id', 'Company', array('username', '=', $username));
	if($duplicate_username->id != $id && !empty($duplicate_username)) {
		$_SESSION['error'] = 'Your new username: '.$username.' already exists';
		header('location: ../Supplier/my_account.php');
		exit();

	} else {
		//check if existing password matches the old password taken from user
		$check_old_password = $verification->getSingleData('SELECT password', 'Company', array('id', '=', $id));
		if(false === password_verify($old_password, $check_old_password->password)) {
			$_SESSION['error'] = 'Old password incorrect';
			header('location: ../Supplier/my_account.php');
			exit();

		} else {
			//check if new passwords match
			if($new_password === $confirm_password) {
				$new_password = password_hash($new_password, PASSWORD_DEFAULT);
				
				$database->update('Company', $id, array(
					'username' => $username,
					'tel' => $tel,
					'password' => $new_password,
					'updated_at' => $updated_at
				));

				$_SESSION['success'] = 'Account update successfull';
				header('location: ../Supplier/my_account.php');

			} else {
				$_SESSION['error'] = 'New passwords do not match';
				header('location: ../Supplier/my_account.php');

			}
			
		}

	}

} else {
	die('requested page not found');
}