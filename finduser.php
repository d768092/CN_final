<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	//alert('請重新整理網頁');
	exit;
}

$findname = $_POST["findname"];
echo $findname;
if($findname==$username) exit('');
$jsonfile = 'userpasswd.json';
$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
if(array_key_exists($findname, $data)){
	$namehash = hash('sha256', $username);
	$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
	$msgfilehash = hash('sha256', $username^$findname);
	$msgfile = 'msg_data/'.substr($msgfilehash, 0, 16).'.json';
	if(is_file($jsonfile)){
		$json_string = file_get_contents($jsonfile);
		$data = json_decode($json_string, true);
		if(array_key_exists($findname, $data)){
			exit('');
		}else{
			$data[$findname] = $msgfile;
		}

	}
	else $data = array();
	$data[$findname] = $msgfile;
	$json_string = json_encode($data);
	file_put_contents($jsonfile, $json_string);
	$func = "send('".$findname."')>";
	echo '<button onclick='.$func.$findname.'</button><br>';
}
else echo "not found";
?>
