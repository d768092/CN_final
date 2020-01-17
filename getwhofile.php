<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	//header('Location: index.html');
	exit;
}

	$jsonfile = 'upload_record.json';
	$namehash = hash('sha256', $username);
	if(is_file($jsonfile)){
	$json_string = file_get_contents($jsonfile);
	$data = json_decode($json_string, true);
	$time = time();
	}

	foreach($data as $key => $value){
		if(substr($key,0,16) == substr($namehash,0,16)){
			echo $value[0]." send a file to you";
		}
	}
?>
