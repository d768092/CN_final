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
$timestamp = $_POST['timestamp'];
/*
$username = 'd768092';
$chat_to = 'cwg50805';
$input_msg = null;
$timestamp = '1579190075';
*/
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
	if(isset($input_msg)&&$input_msg!=''){
		$data_msg[$user_time] = $input_msg;
		$json_string_msg = json_encode($data_msg);
		file_put_contents($msgfile, $json_string_msg);
	}
	$all = '';
	foreach($data_msg as $key => $value)
	{
		$lasttime = substr($key, -10, 10);
		if($lasttime>$timestamp){
			$talker = substr($key,0,-11);
			if($talker==$username) $msg = '<div class="mine">';
			else if($talker==$chat_to) $msg = '<div class="others">';
			$all =  $all.$msg.'<div class="words">'.$value.'</div></div>';
		}
	}
	$json = array('timestamp'=>$lasttime, 'message'=>$all);
	echo json_encode($json);
}
else echo '{}';
?>


