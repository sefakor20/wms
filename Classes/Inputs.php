<?php
class Inputs 
{
	public static function submitType($type = 'POST') {
		switch ($type) {
			case 'POST':
				//return (!empty($_POST)) ? true : false;
				if(!empty($_POST)) {
					return true;
				} else {
					return false;
				}
				break;
			case 'GET':
				if(!empty($_GET)) {
					return true;
				} else {
					return false;
				}
				break;
			default:
				return false;
				break;
		}
	}


	public static function assignValue($item) {
		if(isset($_POST[$item])) {
			return $_POST[$item];
		} else if(isset($_GET[$item])) {
			return $_GET[$item];
		} else {
			return '';
		}
	}
}
?>