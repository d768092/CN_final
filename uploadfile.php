<?php
session_start();
if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	//alert('time out');
	exit;
}
ini_set("display_errors", "On");
$chat_to=$_POST['chat_to'];
if($chat_to=='選個朋友來聊天吧!') {
	echo '';
	exit;
}
//echo "Success First";
if(isset($_FILES['file'])){
	//echo "Success Here";
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
		if(is_file($jsonfile)){
			$json_string = file_get_contents($jsonfile);
			$data = json_decode($json_string, true);
		}
		else $data = array();
		$time = time();
		$data[$hash_filename] = [$username, $time];
		$json_string = json_encode($data);
		file_put_contents($jsonfile, $json_string);
		echo "Successfully send file to: ";
		echo $chat_to;
		sleep(300);
		$json_string = file_get_contents($jsonfile);
		$data = json_decode($json_string, true);
		if(isset($data[$hash_filename])){
			unset($data[$hash_filename]);
			unlink("upload/".$hash_filename);
			$json_string = json_encode($data);
			file_put_contents($jsonfile, $json_string);
		}
	}else{
		print_r($errors);
	}
}
exit();
?>
