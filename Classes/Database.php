<?php
/**

*/
class Database
{
	protected $query;

	protected $results;

	protected $count = 0;

	protected $error;

	protected $id;

	protected $connection;

	
	public function __construct(PDO $connection)
	{
		$this->connection = $connection;
	}


	//query method
	public function query($sql_statement, $parameters = array())
	{
		$this->error = false;
		if($this->query = $this->connection->prepare($sql_statement)) {
			$parameter_counter = 1;
			if(count($parameters)) {
				foreach($parameters as $parameter) {
					$this->query->bindValue($parameter_counter, $parameter);
					$parameter_counter++;
				}
			}
			if($this->query->execute()) {
				$this->id = $this->connection->lastInsertId();
				//$this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
				$this->count = $this->query->rowCount();
			} else {
				$this->error = true;
			}
		}
		return $this;
	}


	//insert function
	public function insert($table, $fields = array()) {
		if(count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$counter = 1;
			foreach($fields as $field) {
				$values .= '?';
				if($counter < count($fields)) {
					$values .= ', ';
				}
				$counter++;
			}
			$sql_query = "INSERT INTO $table (`". implode('`, `', $keys) ."`) VALUES ({$values}) ";
			if(!$this->query($sql_query, $fields)->error()) {
				return true;
			}
		}
		return false;
	}


	//function for search with 'id'
	public function action($action, $table, $where = array()) {
		if(count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=', '==', '===', '!=', '!==');
			$field = $where[0];
			$opreator = $where[1];
			$value = $where[2];
			if(in_array($opreator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$opreator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}
		return false;
	}


	//update method
	public function update($table, $id, $fields) {
		$set = '';
		$x = 1; //incrementing fields to be updated
		foreach($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}
		$sql_query = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		if(!$this->query($sql_query, $fields)->error()) {
			return true;
		}
		return false;
	}


	//get data from database using single where clause
	public function get($query, $table, $where) {
		return $this->action($query, $table, $where);
	}


	//delete function
	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}


	//error reporting
	public function error() {
		return $this->error;
	}


	//count function
	public function count() {
		return $this->count;
	}


	//returning results
	public function results() {
		return $this->results;
	}
	
}


?>