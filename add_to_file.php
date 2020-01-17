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
$namehash = hash('sha256', $chat_to);
echo "chat_to ".$chat_to."\n";
if(is_file($jsonfile)){
	$json_string = file_get_contents($jsonfile);
	$data = json_decode($json_string, true);
}
else $data = array();

$time = time();
//$data[$file_name] = [$username, $time];
$data[substr($namehash,0,16)."_".$file_name] = $time;
//echo $data[$file_name][0]." time ".$data[$file_name][1];
$json_string = json_encode($data);
file_put_contents($jsonfile, $json_string);

echo "success";
?>
