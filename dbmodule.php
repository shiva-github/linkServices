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
	var $pageSizeForAll;
	function __construct(){

		$this->hostname   		= HOSTNAME;
		$this->username   		= USERNAME;
		$this->password   		= PASSWORD;
		$this->database   		= DATABASE;
		$this->linksTable 		= LINKS_TABLE;
		$this->docsTable  		= DOCS_TABLE;
		$this->pageSizeForAll 	= RECORDSPERPAGE;
	}

	function insert_data_form($name,$link,$description,$type){
		$contentAdded["type"] = "No record.";
		switch ($type) {
			case 'Add to links table.':
			$sql = "INSERT INTO `$this->linksTable`( `name`, `link`, `description`) VALUES ('$name','$link','$description');";
			$contentAdded["type"] = "New Link Added";
			break;

			case 'Add to documents table.':
			$sql = "INSERT INTO `$this->docsTable`( `name`, `link`, `description`) VALUES ('$name','$link','$description');";
			$contentAdded["type"] = "New Document Added";
			break;
			default:
			echo "Try on others not on me.";
			break;
		}

		$this->connect();
	    // use exec() because no results are returned
		$result = $this->conn->exec($sql);
		echo json_encode($contentAdded);
		$this->disconnect();

	}

	function getAllLinks($pageNum){
		$pageSize = $this->pageSizeForAll;
		$start = $pageSize * ($pageNum-1);

		$this->connect();
		if($pageNum != 1){
			$sql = "SELECT `id`, `name`, `link`, `description`,`vote`,`time` FROM $this->linksTable ORDER BY ID LIMIT $start, $pageSize";
		}
		else{
			$sql = "SELECT `id`, `name`, `link`, `description`,`vote`,`time` FROM $this->linksTable LIMIT $pageSize";
		}
		$result = $this->conn->query($sql);
		$final = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
		$ab = json_encode($final);
		echo $ab;
		$this->disconnect();
	}
	function getAllDocs($pageNum){
		$pageSize = $this->pageSizeForAll;
		$start = $pageSize * ($pageNum-1);

		if($pageNum != 1){
			$sql = "SELECT `id`, `name`, `link`, `description`,`vote`,`time` FROM $this->docsTable ORDER BY ID LIMIT $start, $pageSize";
		}
		else{
			$sql = "SELECT `id`, `name`, `link`, `description`,`vote`,`time` FROM $this->docsTable LIMIT $pageSize";
		}
		$this->connect();
		$result = $this->conn->query($sql);
		$final = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
		$ab = json_encode($final);
		echo $ab;
		$this->disconnect();
	}

	//total count of the links record
	function totalLinksCount(){
		$this->connect();
		$sql = "SELECT count(id) as count from $this->linksTable";
		$result = $this->conn->query($sql);
		echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
		$this->disconnect();
	}
	//total count of the Docuemnts record
	function totalDocsCount(){
		$this->connect();
		$sql = "SELECT count(id) as count from $this->docsTable";
		$result = $this->conn->query($sql);
		echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
		$this->disconnect();
	}
	//total count of the links record end
	function updatevote($vote,$id){
		$sql = "Update $this->linksTable SET `vote`=$vote where id=$id";
		$this->connect();
		$result = $this->conn->exec($sql);
		$res['data'] = "$result";
		echo json_encode($res);
		$this->disconnect();
	}
	function insert_uploaded_doc($file,$name,$desc){
		$today = UPLOAD_DIRECTORY.date("My").'/';
		$status['status'] = "The file ". basename( $file["name"]). " has been uploaded.";
		$status['name'] = $name;
		$status['desc'] = $desc;
		$status['dest'] = $today;
		echo json_encode($status);
		return;
		// echo json_encode($today);
		if(!is_dir($today)) {
			mkdir($today);
		}

		$target = $today.basename($file['name']);
		// code for file upload
		// if (move_uploaded_file($file["tmp_name"], $target)) {
		// 	$status['status'] = "The file ". basename( $file["name"]). " has been uploaded.";
		// 	echo json_encode($status);
		// } else {
		// 	$status['status'] = "Sorry, there was an error uploading your file.";
		// 	echo json_encode($status);
		// }
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