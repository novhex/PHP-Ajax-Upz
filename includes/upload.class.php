<?php

class Upload {

	private $allowed_file_size = 5;
	private $allowed_extensions = array('gif','png','jpeg','jpg');
	private $upload_dir = '';
	private $encrypt_filename = TRUE;
	private $upload_status;
	private $json_response = '';


	public function __construct($input_file,$directory){

			$this->upload_dir = $directory;

			if(!file_exists($this->upload_dir)){

				mkdir($this->upload_dir);

				if(file_exists($this->upload_dir)){

					$this->do_upload($input_file);

				}else{

					echo 'Unable to create directory';
				}

			}else{

				$this->do_upload($input_file);
			}
	}

private function do_upload($fileInput){


	$target_file = 	 $this->upload_dir.'/'. basename($_FILES[$fileInput]["name"]);    
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $is_image = getimagesize($_FILES[$fileInput]["tmp_name"]);

    if($is_image !== false) {
        $this->upload_status = 1;
    } else {
        $this->json_response = json_encode(array('message'=>'Sorry, your file is not an image.'));
        $this->upload_status = 0;
    }

	if (file_exists($target_file)) {
	    $this->json_response = json_encode(array('message'=>'Sorry, file already exists.'));
	    $this->upload_status = 0;
	}

	if ($_FILES[$fileInput]["size"] > ($this->allowed_file_size*1024*1024)) {

	    $this->json_response = json_encode(array('message'=>'Sorry, your file is too large.'));
	    $this->upload_status = 0;
	}

	if(!in_array($imageFileType, $this->allowed_extensions)) {

	    $this->json_response = json_encode(array('message'=>"Sorry only ".implode(",", $this->allowed_extensions)." are allowed to upload" ));
	    $this->upload_status = 0;
	}
if ($this->upload_status == 0) {

}
 else {


	    if (move_uploaded_file($_FILES[$fileInput]["tmp_name"], $target_file)) {

	    	if($this->encrypt_filename == TRUE){

	    	$new_name = md5(basename( $_FILES[$fileInput]["name"])).'.'.$imageFileType;	

	    	rename($this->upload_dir.'/'.basename( $_FILES[$fileInput]["name"]), $this->upload_dir.'/'.$new_name);

	    	}
	        $this->json_response =  json_encode(array('message'=>'The file '. basename( $_FILES[$fileInput]["name"]). ' has been uploaded.'));

	    } else {

	        $this->json_response =  json_encode(array('message'=>'Sorry, there was an error uploading your file'));
	    }

	}

	
}

public function getUploadStatus(){

	return $this->upload_status;
}

public function getJSONUploadStatus(){

	return $this->json_response ;
}


}