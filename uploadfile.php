<?php
ini_set("display_errors", "On");
$chat_to=$_POST['chat_to'];
if($chat_to=='選個朋友來聊天吧!') {
	echo '';
	exit;
}
if(isset($_FILES['file'])){
	$errors = array();
	$file_name = $_FILES['file']['name'];
	$file_size = $_FILES['file']['size'];
	$file_tmp = $_FILES['file']['tmp_name'];
	$file_type = $_FILES['file']['type'];
	$file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
	$extensions= array("jpeg", "jpg", "png", "mp3", "txt");

	if(in_array($file_ext, $extensions)=== false){
		$errors[]= "extension not allowed, please choose a .jpeg, .jpg, .png, .mp3, .txt file.";
	}

	if($file_size > 15728640){
		$errors[]= 'File size must less than 15MB';
	}

	if(empty($errors) == true){
		$namehash = hash('sha256', $chat_to);
		$hash_filename = substr($namehash, 0, 16)."_".$file_name;
		if(!is_dir('upload')) mkdir('upload', 0755);
		move_uploaded_file($file_tmp, "upload/".$hash_filename);
		$jsonfile = 'upload_record.json';
		echo "Successfully send file to: ";
		echo $chat_to;
	}else{
		print_r($errors);
	}
}
exit();
?>
