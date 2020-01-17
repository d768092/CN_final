<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	header('Location: index.html');
	exit;
}
	
	$path = $_POST['path'];
	$jsonfile = 'upload_record.json';
	$filename = substr($path, 7);
	if(is_file($jsonfile)){
	$json_string = file_get_contents($jsonfile);
	$data = json_decode($json_string, true);
	}


	if(array_key_exists($filename, $data)){
		if($data[$filename][0] == $username){
			$time = time();
			if(abs($time - $data[$filename][1]) > 10){
				echo "File has been deleted by server!";
				unlink($path);
			}else
			{
				echo "You can download the file!";
			}
		}else{
			echo "You can't access this file!";
		}

	}else{
		echo "File not exits!";
	}


















?>
