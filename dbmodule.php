<?php
include_once "config.php";
class dbmodule{
	var $hostname;
	var $username;
	var $password;
	var $database;

	function __construct(){

		$this->hostname = HOSTNAME;
		$this->username = USERNAME;
		$this->password = PASSWORD;
		$this->database = DATABASE;
	}

	function insert(){

	}

	function getAllLinks(){
		echo "links";
	}
	function getAllDocs(){
		echo "docs";
	}

// default functions
	function connect(){

	}
	function disconnect(){
		
	}
}

?>