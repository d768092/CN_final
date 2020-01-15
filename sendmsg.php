<?php
session_start();
if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
/*else{
	alert('time out');
	exit;
}*/

$chat_to = $_POST['chat_to'];
$input_msg = $_POST['input_msg'];
//echo $chat_to;
//$username = 'd768092';
//$chat_to = 'cwg50805';
$namehash = hash('sha256', $username);
$jsonfile_user = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string_user = file_get_contents($jsonfile_user);
$data_user = json_decode($json_string_user, true);
$msgfile = $data_user[$chat_to];
//echo $msgfile;
if(is_file($msgfile)){
	/*$file = fopen($msgfile, 'w');
	fclose($file);
	exit('');*/

	$json_string_msg = file_get_contents($msgfile);
	$data_msg = json_decode($json_string_msg, true);
	$data_msg[$input_msg] = $username;

	foreach($data_msg as $key => $value){
		echo "User ".$value." says ".$key."\r\n";
	}
	$json_string_msg = json_encode($data_msg);
	file_put_contents($msgfile, $json_string_msg);
}



//echo $input_msg;

?>


