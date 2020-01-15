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
$input_msg = $_POST['input_msg'];
$namehash = hash('sha256', $username);
$jsonfile_user = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string_user = file_get_contents($jsonfile_user);
$data_user = json_decode($json_string_user, true);
$msgfile = $data_user[$chat_to];
$time = time();
if(is_file($msgfile)){

	$json_string_msg = file_get_contents($msgfile);
	$data_msg = json_decode($json_string_msg, true);
	$user_time = $username."_".$time;
	$data_msg[$user_time] = $input_msg;

	foreach($data_msg as $key => $value)
	{
		if(strpos($key, 'upload') !== false){ 
			echo "upload!";
		}else{
			echo nl2br("User ".substr($key,0,-11)." says ".$value."\n");
		}
	}
	$json_string_msg = json_encode($data_msg);
	file_put_contents($msgfile, $json_string_msg);
}
?>


