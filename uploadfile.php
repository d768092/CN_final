<?php
//phpinfo();
	//header("Location: chatroom.php");
	ini_set("display_errors", "On");
	$chat_to=$_POST['chat_to'];
	//echo "Success First";
	if(isset($_FILES['image'])){
		$errors = array();
		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_tmp = $_FILES['image']['tmp_name'];
		$file_type = $_FILES['image']['type'];
		$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

		$extensions= array("jpeg", "jpg", "png");

		if(in_array($file_ext, $extensions)=== false){
			$errorsp[]= "extension not allowed, please choose a JPEG or PNG file.";
		}

		if($file_size > 15728640){
			$errors[]= 'File size must be exactly 2MB';
		}

		if(empty($errors) == true){
			move_uploaded_file($file_tmp, "upload/".$file_name);
			echo "Success";
			echo $chat_to;
		}else{
			print_r($errors);
		}
	}
	exit();
?>
