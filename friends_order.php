<?php

session_start();
if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	//alert('time out');
	exit;
}

$username = substr($_POST["username"], 0, -12);
$namehash = hash('sha256', $username);
if(!is_dir('user_data')) mkdir('user_data', 0755);
$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
arsort($data);
foreach($data as $key => $value) echo "<button onclick='send(\"$key\")'>".$key."</button><br>";
$json_string = json_encode($data);
file_put_contents($jsonfile, $json_string);
?>
