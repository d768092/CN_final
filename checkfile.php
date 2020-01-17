<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	//header('Location: index.html');
	exit;
}
	
	$path = $_POST['path'];
	$jsonfile = 'upload_record.json';
	$filename = substr($path, 7);
	$namehash = hash('sha256', $username);
	//echo substr($namehash,0,16)."\n";
	$hash_filename = substr($namehash,0,16)."_".$filename;
	//echo $hash_filename;
	if(is_file($jsonfile)){
	$json_string = file_get_contents($jsonfile);
	$data = json_decode($json_string, true);
	$time = time();
	}
	
	$flag = "You can't access the file!";
	foreach($data as $key => $value){
		//echo $key." ".$hash_filename."\n";
		if(abs($time- $value) > 10000){
			if($key == $hash_filename)	echo "File has been deleted by server!";
			unset($data[$hash_filename]);
			unlink("upload/".$hash_filename);
			//echo "key is : ".$key." abs() is : ".abs($time-$value)."deleted".$hash_filename."\n";
		}
		else{
			if($key == $hash_filename){
				$flag =  "You can download the file!";
				unset($data[$hash_filename]);
			}
		}
	}
	echo $flag;	
	$json_string = json_encode($data);
	file_put_contents($jsonfile, $json_string);
?>
