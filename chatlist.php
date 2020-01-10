<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
/*
else{
	header('Location: index.html');
	exit;
}
*/
$namehash = hash('sha256', $username);
$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
//echo sizeof($data);
foreach($data as $key => $value){
	echo '<button id="chatto">'.$key.'</button>';
}
?>

