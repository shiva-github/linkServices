<?php
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Origin, Content-type, X-Auth-Token, Authorization');  
// header("Content-Type: application/json");
require_once "dbmodule.php";

// $headers = getallheaders();
// // var_dump($headers);
// // var_dump($_REQUEST);
// var_dump($_POST['json']);
// // $ab = (array) json_decode($_REQUEST);
// // var_dump($ab);
// echo json_encode('{"ab":"cd"}');
// // return;
// // echo json_encode($ab);
// return;



header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-type, X-Auth-Token, Authorization,accept, x-requested-with');  
header("Content-Type: application/json");
header("Access-Control-Max-Age:1800");
// header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

// $pstData = (array) json_decode($_FILES);

$pstData = (array) json_decode($_POST["json"]);

// This code is working with json encode printing actual params with 
// echo json_encode($v);
// $v = json_decode($v);
//  echo json_encode('{"fullname" : "'.$v['tagname'].'"}');
//  // echo json_encode("{'fullname' : 'Jeff Hansen'}");
// return;


$headers = getallheaders();
if((isset($headers["codetype"]) == "" || isset($headers["type"]) != "url-x" ) && false){
// if( isset($headers["type"]) != "url-x" && false ){
	//enter the code for security of db
	$ab = '{"error": "This is the security protocol activated for the security reasons"}';
	echo json_encode($_REQUEST);

}else{
	// echo $pstData['tagname'];
	if(isset($pstData['tagname'])){
		$db = new dbmodule();
		switch ($pstData['tagname']) {
			case "showlinks":
			if( isset($pstData['pageNumber']) ){
				$db->getAllLinks($pstData['pageNumber']);
			}
			break;
			case "linksCount":
			$db->totalLinksCount(); 
			break;
			case "docsCount":
			$db->totalDocsCount(); 
			break;
			case 'updatevote':
			if( isset($pstData['voteid']) && isset($pstData['vote']) ){
				$db->updatevote($pstData['vote'],$pstData['voteid']);
			}
			break;
			case 'showdocuments':
			if( isset($pstData['pageNumber']) ){
				$db->getAllDocs($pstData['pageNumber']);
			}
			break;
			case 'form-data':
			if( isset($pstData['name']) && isset($pstData['link']) && isset($pstData['description']) && isset($pstData['type']) ){
				$db->insert_data_form($pstData['name'],$pstData['link'],$pstData['description'],$pstData['type']);	
			}else{
				echo "Not sure how do you get here but You need to leave now.";
			}
			break;
			case 'upload-file':
			
			$db->insert_uploaded_doc($_FILES['file'],$pstData["name"],$pstData["description"]);
			break;
			default:
			$result["error"] = "trying to be very smart. cheat'in huh.........1";
			echo json_encode($result);
			break;
		}
	}else{
		$result["error"] = "trying to be very smart. cheat'in huh.........2";
		echo json_encode($result);
	}
}

?>