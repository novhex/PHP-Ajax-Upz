<?php

require_once 'includes/upload.class.php';


if($_FILES){
	$obj = new Upload('avatar','uploads');




	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])){

		echo $obj->getJSONUploadStatus();

	}else{

		$msg = json_decode($obj->getJSONUploadStatus(),true);

		echo($msg['message']);
	}
}else{
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])){

		echo json_encode(array('message'=>'Please select a file'));

	}else{

		

		echo('Please select a file');
	}

}