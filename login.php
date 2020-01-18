<?php
$jsonfile = 'userpasswd.json';
$username = $_POST["username"];
$password = $_POST["password"];
if($username=='')exit;
if(!ctype_alnum($username)) exit('帳號：請輸入英文或數字');
$hashed = hash('sha256', $password);

$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
if(array_key_exists($username, $data)){
	if($data[$username]==$hashed){
		session_start();
		$_SESSION['username']=$username;
		echo "success";
	}
	else echo "密碼錯誤";
}
else echo "找不到用戶";
?>
