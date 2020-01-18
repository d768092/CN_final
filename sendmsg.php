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
$order = $_POST['order'];

if($chat_to=='選個朋友來聊天吧!') {
	echo '{"friends": "none"}';
	exit;
}

$time = time();

$namehash = hash('sha256', $username);
$friendhash = hash('sha256', $chat_to);

// upload time
$jsonfile_friend = 'user_data/'.substr($friendhash, 0, 16).'.json';
$json_string_friend = file_get_contents($jsonfile_friend);
$data_friend = json_decode($json_string_friend, true);
$msgfile = substr($data_friend[$username], 10);
if(array_key_exists($username, $data_friend)&&$order=='change') {
    $data_friend[$username] = $time.$msgfile;
    $json_string_friend = json_encode($data_friend);
    file_put_contents($jsonfile_friend, $json_string_friend);
}

$jsonfile_user = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string_user = file_get_contents($jsonfile_user);
$data_user = json_decode($json_string_user, true);
$msgfile = substr($data_user[$chat_to], 10);
if ($order=='change') {
    $data_user[$chat_to] = $time.$msgfile;
    $json_string_user = json_encode($data_user);
    file_put_contents($jsonfile_user, $json_string_user);
}

if(!is_dir('msg_data')) mkdir('msg_data',0755);
if(isset($input_msg)&&$input_msg!=''){
	if(is_file($msgfile)){
		$json_string_msg = file_get_contents($msgfile);
		$data_msg = json_decode($json_string_msg, true);
	}
	else $data_msg=array();
	$user_time = $username."_".$time;
	$data_msg[$user_time] = $input_msg;
	$json_string_msg = json_encode($data_msg);
	file_put_contents($msgfile, $json_string_msg);
}
else if(!is_file($msgfile)) exit('{}');
else {
	$json_string_msg = file_get_contents($msgfile);
	$data_msg = json_decode($json_string_msg, true);
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
?>


