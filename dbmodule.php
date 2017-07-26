<?php
include_once "config.php";
class dbmodule{
	var $hostname;
	var $username;
	var $password;
	var $database;
	var $linksTable;
	var $docsTable;
	var $conn;
	function __construct(){

		$this->hostname   = HOSTNAME;
		$this->username   = USERNAME;
		$this->password   = PASSWORD;
		$this->database   = DATABASE;
		$this->linksTable = LINKS_TABLE;
		$this->docsTable  = DOCS_TABLE;
	}

	function insert_data_form($name,$link,$description,$type){
		
		switch ($type) {
			case 'Add to documents table.':
				$sql = "INSERT INTO `$this->linksTable`( `name1`, `link`, `description`) VALUES ('$name','$link','$description');";
			break;

			case 'Add to links table.':
				$sql = "INSERT INTO `table2`( `name1`, `link`, `description`) VALUES ('$name','$link','$description');";
			break;
			default:
				echo "Try on others not on me.";
			break;
		}

		$this->connect();
		// for insert data 
		// $sql = "SELECT id, name1, link, description from $this->linksTable";
	    // use exec() because no results are returned
		$result = $this->conn->exec($sql);
		// var_dump($this->conn->execute());
		// echo $this->conn->execute();
		// var_dump($result);
		$this->disconnect();

	}

	function getAllLinks(){
		$this->connect();
		$sql = "SELECT id, name1, link, description from $this->linksTable";
		$result = $this->conn->query($sql);
		$final = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
		// if ($result->num_rows > 0) {
			// echo $final;
		// }
		// echo gettype($final);
		$ab = json_decode($final);
		var_dump($ab);
		$newArr = array();
		// foreach($ab as $key => $value) {
		// 	if($key == "name1"){
		// 		echo $key;
		// 		$newArr[ $final[ 'nameValue' ] ] = $value;
		// 	}
		// 	else{
		// 		$newArr[ $final[ $key ] ] = $value;
		// 	}
		// }

		// echo json_encode($newArr);
		// return;


		// for($i=0;$i<count($ab);$i++){
		// 	var_dump( $ab[$i] ) ;
		// 	// $ab[$i]["name"] = $ab[$i]["name1"];
		// 	// unset($ab[$i]["name1"]);
		// 	var_dump( $ab[$i] ) ;			
		// 	break;
		// }
		$this->disconnect();
	}
	function getAllDocs(){
		echo "docs";
	}

	// default functions
	function connect(){
		try {
			$this->conn = new PDO("mysql:host=$this->hostname;dbname=$this->database", $this->username, $this->password);
    // set the PDO error mode to exception
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
	}
	function disconnect(){
		$this->conn = null;
	}
}

?>