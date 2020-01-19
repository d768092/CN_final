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
	$filename = $_POST['path'];
	$namehash = hash('sha256', $username);
	$hash_filename = substr($namehash,0,16)."_".$filename;
	if(is_file($jsonfile)){
        $json_string = file_get_contents($jsonfile);
        $data = json_decode($json_string, true);
        $time = time();
	}
	
	$flag = "You can't access the file!";
	if($filename=='') exit('');
	foreach($data as $key => $value){
        if(abs($time - $value[1]) > 300){
			if($key == $hash_filename)	echo "File has been deleted by server!";
			unset($data[$hash_filename]);
			unlink("upload/".$hash_filename);
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
