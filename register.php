<?php
$jsonfile = 'userpasswd.json';
$username = $_POST["username"];
$password = $_POST["password"];
if(strlen($username)==0)exit;
$hashed = hash('sha256', $password);
if(is_file($jsonfile)){
	$json_string = file_get_contents($jsonfile);
	$data = json_decode($json_string, true);
	if(array_key_exists($username, $data)) exit('username exists');
    if(strlen($password)<8)exit('password too short (at least 8 characters)');
}
else $data = array();
$data[$username] = $hashed;
$json_string = json_encode($data);
file_put_contents($jsonfile, $json_string);

echo "success";
?>

