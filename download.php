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
	$filename = $_POST["path"];
	$hash_filename = (substr($namehash,0,16)."_".$filename);

	header("Content-Type: application/octet-stream");
	header("Content-Transfer-Encoding: Binary");
	header("Content-disposition: attachment; filename=\"".$filename."\"");
	readfile("upload/".$hash_filename);
	unlink("upload/".$hash_filename);
?>
