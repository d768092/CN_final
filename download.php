<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	//header('Location: chatroom.php');
	exit;
}
	ini_set("Allow_url_fopen", "On");
	$namehash = hash('sha256', $username);
 	//echo $namehash;	
	//$file_path = $_POST["path"];
	//echo "File path is:".$file_path." ";
	//$filename = substr($file_path, 7);
	//echo $filename." ";
	$filename = $_POST["path"];
	$hash_filename = (substr($namehash,0,16)."_".$filename);

	header("Content-Type: application/octet-stream");
	header("Content-Transfer-Encoding: Binary");
	header("Content-disposition: attachment; filename=\"".$filename."\"");
	//echo $hash_filename;
	readfile(("upload/".$hash_filename));
	unlink("upload/".$hash_file_name);
?>
