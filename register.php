<?php
$jsonfile = 'userpasswd.json';
$username = $_POST["username"];
$password = $_POST["password"];
if($username=='') exit;
if(!ctype_alnum($username)) exit('帳號：請輸入英文或數字');
$hashed = hash('sha256', $password);
if(is_file($jsonfile)){
	$json_string = file_get_contents($jsonfile);
	$data = json_decode($json_string, true);
	if(array_key_exists($username, $data)) exit('用戶已存在');
    if(strlen($password)<8)exit('密碼：請輸入至少8個字元');
}
else $data = array();
$data[$username] = $hashed;
$json_string = json_encode($data);
file_put_contents($jsonfile, $json_string);

echo "success";
?>

