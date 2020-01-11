<?php
session_start();
if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	alert('time out');
	exit;
}
$chat_to = $_POST['chat_to'];
//echo $chat_to;
//$username = 'd768092';
//$chat_to = 'cwg50805';
$namehash = hash('sha256', $username);
$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
$msgfile = $data[$chat_to];
//echo $msgfile;
if(!is_file($msgfile)){
	$file = fopen($msgfile, 'w');
	fclose($file);
	exit('');
}
$file = fopen($msgfile, 'r');
while(!feof($file)){
	echo fgets($file);
}
fclose($file);
?>


