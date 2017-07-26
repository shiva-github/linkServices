<?php
require_once "dbmodule.php";
	// $headers = get_headers();
	// var_dump($headers);

$headers = getallheaders();
if(isset($headers["codetype"]) == "" || isset($headers["type"]) != "url-x" ){
	//enter the code for security of db
	echo "This is the security protocol activated for the security reasons";
}else{
	if(isset($_POST['tagname'])){
		$db = new dbmodule();
		switch ($_POST['tagname']) {
			case 'showlinks':
			$db->getAllLinks();
			break;
			case 'showdocuments':
			$db->getAllDocs();
			break;
			case 'form-data':
			if( isset($_POST['name']) && isset($_POST['link']) && isset($_POST['description']) && isset($_POST['type']) ){
				$db->insert_data_form($_POST['name'],$_POST['link'],$_POST['description'],$_POST['type']);	
			}else{
				echo "Not sure how do you get here but You need to leave now.";
			}
			
			break;
			case 'upload-form':
			$db->insert_uploaded_doc();
			break;
			default:
			echo "trying to be very smart. cheat'in huh.........";
			break;
		}
	}else{
		echo "trying to be very smart. cheat'in huh.........";
	}
}

?>