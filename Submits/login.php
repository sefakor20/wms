<?php
require_once dirname(__DIR__).'/Core/init.php';

if(Inputs::submitType()) {
	$username = Inputs::assignValue('username');
	$password = Inputs::assignValue('password');

	$login = new Login($connection, $username, $password);

	//checking whether user is 'warehouse employee'
	if ($login->authenticate('User')) {
		$warehouse_employee = $login->getAccount();
		$switch_user = $warehouse_employee->user_group;

		//redirect employee based on their 'group'
		if ($switch_user == 1) {
			//administrator
			$_SESSION['admin'] = $warehouse_employee->id;
			$_SESSION['admin_name'] = $warehouse_employee->name;
			header('location: ../Warehouse/index.php');
		} else {
			//general user
			$_SESSION['gen_user'] = $warehouse_employee->id;
			$_SESSION['gen_user_name'] = $warehouse_employee->name;
			header('location: ../Employee/Warehouse/index.php');
		}
	}

	//authenticating company
	if ($login->companyAuthenticate('Company')) {
		$company = $login->getAccount();
		$switch_company = $company->user_group;

		//redirect based on 'company group'
		if ($switch_company == 1) {
			//supplier
			$_SESSION['sup_id'] = $company->id;
			$_SESSION['sup_name'] = $company->name;
			header('location: ../Supplier/index.php');
		} else {
			//client
			$_SESSION['client_id'] = $company->id;
			$_SESSION['client_name'] = $company->name;
			header('location: ../Client/index.php');
		}
	}

	//display error
	if (!$login->authenticate('User') && !$login->companyAuthenticate('Company')) {
		$_SESSION['error'] = $login->getError();
		header('location: ../index.php');
	}

} else {
	die('requested page not found');
}

?>