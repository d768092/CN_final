<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	alert('請重新整理網頁');
	exit;
}

$findname = $_POST["findname"];
//echo $findname;
$jsonfile = 'userpasswd.json';
$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
if(array_key_exists($findname, $data)){
	$namehash = hash('sha256', $username);
	$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
	$findnamehash = hash('sha256', $findname);
	$msgfile = 'msg_data/'.substr($namehash ^ $findnamehash, 0, 16).'.json';
	if(is_file($jsonfile)){
		$json_string = file_get_contents($jsonfile);
		$data = json_decode($json_string, true);
	}
	else $data = array();
	$data[$findname] = $msgfile;
	$json_string = json_encode($data);
	file_put_contents($jsonfile, $json_string);
	echo '<button id="chatto">'.$findname.'</button>';
}
else echo "not found";
?>
