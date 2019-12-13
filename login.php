<?php*
$jsonfile = 'userpasswd.json';
$username = $_POST["username"];
$password = $_POST["password"];
$hashed = hash('sha256', $password);

$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
if(array_key_exists($username, $data)){
	if($data[$username]==$hashed) echo "success";
	else echo "wrong password";
}
else echo "no such user";
?>
