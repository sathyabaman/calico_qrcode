<?php 

class Db {
	public $connection;
	private $servername = "localhost";
	private $username   = "surplus";
	private $password   = "surplus";
	private $database   = "surplus_barcode";
	public function connect(){
		try {
			$this->connection = new PDO("mysql:host={$this->servername};dbname={$this->database}", $this->username, $this->password);
			// set the PDO error mode to exception
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			//$this->logger->writeLog('MySQL Connection Success');
			return $this->connection;
		} catch(PDOException $e) {
			$this->logger->writeLog('MySQL Connection failed');
			return false;
		}
	}

	public function getAllPackageList(){
		$this->connect();		
		$query = "SELECT * FROM productlist";
				$stmt = $this->connection->prepare($query);
				$result = $stmt->execute();
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $results;
	}

	public function getSingleProductDetails($ctnid){
		$this->connect();	
		$query = "SELECT * FROM productlist WHERE ctn=".$ctnid."";
				$stmt = $this->connection->prepare($query);
				$result = $stmt->execute();
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $results;
	}

	public function totalNoOfitems(){

		$this->connect();		
		$query = "SELECT * FROM productlist";
				$stmt = $this->connection->prepare($query);
				$result = $stmt->execute();
				$results = $stmt->rowCount();
				return $results;
	}

	public function paginationFetchData($limit, $offset){
		$this->connect();
		$query = "SELECT *FROM productlist ORDER BY ctn DESC LIMIT :limit OFFSET :offset";
		// Prepare the paged query
	    $stmt = $this->connection->prepare($query);

	    // Bind the query params
	    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
	    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
	    $result = $stmt->execute();
	    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $results;
	}

}

?>