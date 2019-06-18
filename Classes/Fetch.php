<?php
/**

 */
class Fetch
{
	protected $connection;

	protected $result;

	protected $error;

	protected $count = 0;

	function __construct(PDO $connection)
	{
		$this->connection = $connection;
	}


	//**********************************************************//
	// fetching data for danger                                 //
	//**********************************************************//

	//get total number for danger
	public function dangerTotal($table, $number)
	{
		$query = $this->connection->prepare("SELECT COUNT(id) AS total FROM {$table} WHERE {$table}.quantity < ?");
		$query->bindParam(1, $number, PDO::PARAM_INT);
		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result->total;
		}
	}


	//all danger items
	public function dangerItems($action, $table, $join, $field, $field_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$field} < ? ORDER BY {$table}.id DESC");
		$query->bindParam(1, $field_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}



	//export to csv
	public function exportItemsToCsvFormat($action)
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		$output = fopen("php://output", "w");
		fputcsv($output, array('Item', 'Category', 'Quantity', 'Personnel', 'Supplier', 'Date'));

		$query = $this->connection->prepare("{$action}");

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				fputcsv($output, $all_results[] = $result);
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}

		fclose($output);
	}


	//search
	public function search($action, $item)
	{
		$query = $this->connection->prepare("{$action}");

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}


	//generate report
	public function generateReports($action)
	{
		$query = $this->connection->prepare("{$action}");

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}



	//**********************************************************//
	// no comparisms, without/without join                      //
	//**********************************************************//

	public function noComparism($action, $table, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}


	public function noComparismWithJoin($action, $table, $join, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}




	//**********************************************************//
	// contents for comparing a single field without joins      //
	//**********************************************************//

	//single item
	public function getSingleItem($action, $table, $field, $field_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} WHERE {$field} = ? LIMIT 1");
		$query->bindParam(1, $field_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//function to fetch single line data for query with where clause
	public function singleDataAction($action, $table, $where = array())
	{
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=', '==', '===', '!=', '!==', 'LIKE');
			$field = $where[0];
			$opreator = $where[1];
			$value = $where[2];
			if (in_array($opreator, $operators)) {
				$sql_statement = "{$action} FROM {$table} WHERE {$field} {$opreator} ? LIMIT 1";
				if ($result = $this->query($sql_statement, array($value))) {
					return $result;
				} else {
					$this->error = implode(', ', $this->connection->errorInfo());
					return false;
				}
			}
		}
	}


	//function to fetch a single data with or without a where clause
	public function query($sql_statement, $parameters = array())
	{
		if ($query = $this->connection->prepare($sql_statement)) {
			$parameter_counter = 1;
			if (count($parameters)) {
				foreach ($parameters as $parameter) {
					$query->bindValue($parameter_counter, $parameter);
					$parameter_counter++;
				}
				if ($query->execute()) {
					$id = $this->connection->lastInsertId();
					$result = $query->fetch(PDO::FETCH_OBJ);
					$this->count = $query->rowCount();
					return $result;
				} else {
					$this->error = implode(', ', $this->connection->errorInfo());
					return false;
				}
			}
		}
		return $this;
	}


	//display single data result
	public function getSingleData($query, $table, $where)
	{
		return $this->singleDataAction($query, $table, $where);
	}


	//multi items
	public function getMultiItem($action, $table, $field, $field_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} WHERE {$field} = ?");
		$query->bindParam(1, $field_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}





	//***************************************************//
	// contents with limits - no comparism               //
	//***************************************************//

	//items with limit and offset
	public function getItemsWithLimitOffset($action, $table, $join, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}




	//***************************************************//
	// contents for comparing a single field with joins  //
	//***************************************************//

	//single item with joins
	public function getSingleJoinItem($action, $table, $join, $field, $field_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$field} = ? LIMIT 1");
		$query->bindParam(1, $field_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//multi items with joins
	public function getMultiJoinItem($action, $table, $join, $field, $field_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$field} = ? ORDER BY {$table}.id DESC");
		$query->bindParam(1, $field_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//multi items with joins
	public function getMultiJoinItemWithLimit($action, $table, $join, $field, $field_value, $limit)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$field} = ? ORDER BY id DESC LIMIT {$limit}");
		$query->bindParam(1, $field_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//multi items with joins, offset and limit
	//pagination
	public function getPaginationRecords($action, $table, $join, $field, $id, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$field} = ? ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");
		$query->bindParam(1, $id, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}





	//***********************************************//
	// contents for comparing two/three fields       //
	//***********************************************//

	//multi items 
	public function getCompareTwoFields($action, $table, $first_item, $first_item_value, $last_item, $last_item_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} WHERE {$first_item} = ? AND {$last_item} = ?");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//multi items with join 
	public function getCompareTwoFieldsWithJoin($action, $table, $join, $first_item, $first_item_value, $last_item, $last_item_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$first_item} = ? AND {$last_item} = ? ORDER BY {$table}.id DESC");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//multi items with join and limit
	public function getTwoFieldsCompareJoinLimit($action, $table, $join, $first_item, $first_item_value, $last_item, $last_item_value, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$first_item} = ? AND {$last_item} = ? ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");
		$query->bindParam(1, $first_item_value, PDO::PARAM_STR);
		$query->bindParam(2, $last_item_value, PDO::PARAM_STR);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//multi items with limit
	public function getCompareTwoFieldsWithLimit($action, $table, $first_item, $first_item_value, $last_item, $last_item_value, $limit)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} WHERE {$first_item} = ? AND {$last_item} = ? LIMIT {$limit}");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//multi items with limit and join
	public function getCompareTwoFieldsWithLimitJoin($action, $table, $join, $first_item, $first_item_value, $last_item, $last_item_value, $limit)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$first_item} = ? AND {$last_item} = ? ORDER BY {$table}.id DESC LIMIT {$limit}");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//comparing two items to return more data with limit and join
	public function getMultipleDataCompare($action, $table, $join, $first_item, $first_item_value, $last_item, $last_item_value, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$first_item} = ? AND {$last_item} = ? ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");
		$query->bindParam(1, $first_item_value, PDO::PARAM_STR);
		$query->bindParam(2, $last_item_value, PDO::PARAM_STR);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//comparing three items to return more data with limit and join
	public function getCompareThreeFieldsWithLimit($action, $table, $join, $first_item, $first_item_value, $last_item, $last_item_value, $third_item, $third_item_value, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$first_item} = ? AND {$last_item} = ? AND {$third_item} = ? ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);
		$query->bindParam(3, $third_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//function for comparing two items
	public function compareTwoItems($action, $table, $first_item, $first_item_value, $last_item, $last_item_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} WHERE {$first_item} = ? AND {$last_item} = ? LIMIT 1");
		$query->bindParam(1, $first_item_value, PDO::PARAM_STR);
		$query->bindParam(2, $last_item_value, PDO::PARAM_STR);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//function for comparing three items
	public function compareThreeItems($action, $table, $first_item, $first_item_value, $last_item, $last_item_value, $third_item, $third_item_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} WHERE {$first_item} = ? AND {$last_item} = ? AND {$third_item} = ? LIMIT 1");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);
		$query->bindParam(3, $third_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}




	//******************************//
	// fetching total counts        //
	//******************************//

	//total for comparing two fields
	public function getTwoFieldsTotal($table, $first_item, $first_item_value, $last_item, $last_item_value)
	{
		$query = $this->connection->prepare("SELECT COUNT(id) AS total FROM {$table} WHERE {$first_item} = ? AND {$last_item} = ? LIMIT 1");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//total for comparing three fields
	public function getThreeFieldsTotal($table, $first_item, $first_item_value, $last_item, $last_item_value, $third_item, $third_item_value)
	{
		$query = $this->connection->prepare("SELECT COUNT(id) AS total FROM {$table} WHERE {$first_item} = ? AND {$last_item} = ? AND {$third_item} = ? LIMIT 1");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);
		$query->bindParam(3, $third_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//total for comparing a single field
	public function getTotal($table, $item, $item_value)
	{
		$query = $this->connection->prepare("SELECT COUNT(id) AS total FROM {$table} WHERE {$item} = ? LIMIT 1");
		//$status = 1;
		$query->bindParam(1, $item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//function for pagination total for all items
	public function paginationTotal($table)
	{
		$query = $this->connection->prepare("SELECT COUNT(id) AS total FROM $table");
		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result->total;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return false;
		}
	}


	//daily total for 'warehouse'
	public function dailyTotalWarehouse($table, $from, $to)
	{
		$query = $this->connection->prepare("SELECT COUNT(id) AS total FROM {$table} WHERE created_at BETWEEN ? AND ? ");
		$query->bindParam(1, $from, PDO::PARAM_STR);
		$query->bindParam(2, $to, PDO::PARAM_STR);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}


	//daily total for 'warehouse'
	public function dailyTotal($table, $where, $from, $to)
	{
		$query = $this->connection->prepare("SELECT COUNT(id) AS total FROM {$table} WHERE {$where} BETWEEN ? AND ? ");
		$query->bindParam(1, $from, PDO::PARAM_STR);
		$query->bindParam(2, $to, PDO::PARAM_STR);

		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}




	//************************************************//
	// fetching daily and monthly items               //
	//************************************************//

	//getting daily items
	public function getDailyItems($action, $table, $join, $to_compare, $first_item_value, $last_item_value, $limit, $offset)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$to_compare}.created_at BETWEEN ? AND ? ORDER BY {$table}.id DESC LIMIT $limit OFFSET $offset");
		$query->bindParam(1, $first_item_value, PDO::PARAM_STR);
		$query->bindParam(2, $last_item_value, PDO::PARAM_STR);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
			return $this;
		}
	}




	//***********************************************//
	// Messages and replies                          //
	//***********************************************//

	// message details
	public function getMessage($action, $table, $join, $first_item, $first_item_value)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} {$join} WHERE {$first_item} = ? ORDER BY {$table}.id ASC");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//function for replies
	public function getReply($action, $table, $first_item, $first_item_value, $last_item, $last_item_value, $status)
	{
		$query = $this->connection->prepare("{$action} FROM {$table} WHERE {$first_item} = ? AND {$last_item} = ? AND status = ?");
		$query->bindParam(1, $first_item_value, PDO::PARAM_INT);
		$query->bindParam(2, $last_item_value, PDO::PARAM_INT);
		$query->bindParam(3, $status, PDO::PARAM_INT);

		if ($query->execute()) {
			$all_results = array();
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$all_results[] = $result;
			}
			return $all_results;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}





	//function for email
	public function email($table, $email)
	{
		$query = $this->connection->prepare("SELECT id, token FROM {$table} WHERE email = ? LIMIT 1");
		$query->bindParam(1, $email, PDO::PARAM_STR);
		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//function for email with token
	public function emailToken($table, $email, $token)
	{
		$query = $this->connection->prepare("SELECT id FROM {$table} WHERE email = ? AND token = ? LIMIT 1");
		$query->bindParam(1, $email, PDO::PARAM_STR);
		$query->bindParam(2, $token, PDO::PARAM_STR);
		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//function to run update for forgotten password
	public function resetForgotPassword($table, $email, $new_password)
	{
		$query = $this->connection->prepare("UPDATE {$table} SET password = '$new_password', token = '' WHERE email = ?");
		$query->bindParam(1, $email, PDO::PARAM_STR);
		if ($query->execute()) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		} else {
			$this->error = implode(', ', $this->connection->errorInfo());
		}
	}


	//function to fetch single line data for query with where clause and JOIN
	public function singleDataJoinAction($action, $table, $join, $where = array())
	{
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=', '==', '===', '!=', '!==', 'LIKE');
			$field = $where[0];
			$opreator = $where[1];
			$value = $where[2];
			if (in_array($opreator, $operators)) {
				$sql_statement = "{$action} FROM {$table} {$join} WHERE {$field} {$opreator} ? LIMIT 1";
				if ($result = $this->query($sql_statement, array($value))) {
					return $result;
				} else {
					$this->error = implode(', ', $this->connection->errorInfo());
					return false;
				}
			}
		}
	}


	//function to fetch all data with or without a where clause
	public function fetchData($sql_statement, $parameters = array())
	{
		if ($query = $this->connection->prepare($sql_statement)) {
			//working with 'where' clause
			$parameter_counter = 1;
			if (count($parameters)) {
				foreach (count($parameters) as $parameter) {
					$query->bindValue($parameter_counter, $parameter);
					$parameter_counter++;
				}
			}

			if ($query->execute()) {
				$id = $this->connection->lastInsertId();
				$all_results = array();
				while ($result = $query->fetch(PDO::FETCH_OBJ)) {
					$all_results[] = $result;
				}
				return $all_results;
			} else {
				return false;
			}
		}
	}


	//function to fetch multi line data for query with where clause
	public function multiDataAction($action, $table, $where = array())
	{
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=', '==', '===', '!=', '!==');
			$field = $where[0];
			$opreator = $where[1];
			$value = $where[2];
			if (in_array($opreator, $operators)) {
				$sql_statement = "{$action} FROM {$table} WHERE {$field} {$opreator} ?";
				if ($result = $this->fetchData($sql_statement, array($value))) {
					return $result;
				} else {
					$this->error = implode(', ', $this->connection->errorInfo());
					return false;
				}
			}
		}
	}
}
