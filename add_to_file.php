<?php

session_start();
if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	//alert('time out');
	exit;
}
$chat_to = $_POST['chat_to'];
$file_name = $_POST['file_name'];
$jsonfile = 'upload_record.json';
if(is_file($jsonfile)){
	$json_string = file_get_contents($jsonfile);
	$data = json_decode($json_string, true);
}
else $data = array();

$time = time();
$data[$file_name] = [$chat_to, $time];
//echo $data[$file_name][0]." time ".$data[$file_name][1];
$json_string = json_encode($data);
file_put_contents($jsonfile, $json_string);

echo "success";
?>
