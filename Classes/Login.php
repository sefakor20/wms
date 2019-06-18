<?php
/**
* @Young Xorse Noted
*/
class Login
{
	protected $connection;

	protected $username;

	protected $password;

	protected $account;

	protected $error;
	
	function __construct(PDO $connection, $username, $password)
	{
		$this->connection = $connection;
		$this->username = $username;
		$this->password = $password;
	}


	public function authenticate($table) {
		$query = $this->connection->prepare("SELECT id, CONCAT(first_name ,' ', last_name, ' ', other_name) AS name, username, password, user_group FROM $table WHERE username = ? AND status = ? LIMIT 1");
		$account_status = 1;
		$query->bindParam(1, $this->username, PDO::PARAM_STR);
		$query->bindParam(2, $account_status, PDO::PARAM_INT);

		if(false === $query->execute()) {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}

		$account = $query->fetch(PDO::FETCH_OBJ);

		if(false === $account) {
			$this->error = 'No account found with the given username';
			return false;
		}

		if(false === password_verify($this->password, $account->password)) {
			$this->error = 'Invalid account password';
			return false;
		}

		$this->account = $account;
		return true;

	}


	//company authentication
	public function companyAuthenticate($table) {
		$query = $this->connection->prepare("SELECT id, name, username, password, user_group FROM $table WHERE username = ? AND status = ? LIMIT 1");
		$account_status = 1;
		$query->bindParam(1, $this->username, PDO::PARAM_STR);
		$query->bindParam(2, $account_status, PDO::PARAM_INT);

		if(false === $query->execute()) {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}

		$account = $query->fetch(PDO::FETCH_OBJ);

		if(false === $account) {
			$this->error = 'No account found with the given username';
			return false;
		}

		if(false === password_verify($this->password, $account->password)) {
			$this->error = 'Invalid account password';
			return false;
		}

		$this->account = $account;
		return true;

	}


	public function getAccount() {
		if(null !== $this->account) {
			unset($this->account->password);
		}

		return $this->account;
	}


	public function getError() {
		return $this->error;
	}


}


?>