<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	header('Location: index.html');
	exit;
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		function send(name){
			$('#chat_to').text(name);
			$.post('sendmsg.php',
				{chat_to: name},
				function(response){
					$('#msg').text(response);
				}
			)
		}
		$(document).ready(function() {
			$("#finduser").click(function() {
				$.post('finduser.php',
					{findname: $('#findname').val()},
					function(response){
						if(response=='not found'){
							$('#error').text(response);
						}
						else{
							$('#error').val('');
							$('#chatlist').append(response);
						}
					}
				)
			});
		});
	</script>
	<title>popCorN</title>
	<link rel="stylesheet" href="./chatroom.css">
</head>
<body>

<div class="header">
<h1><?php echo $username; ?>的聊天室</h1>
</div>
<div class="chatroom">
<div class="sidebar">
<input id="findname" type="text" placeholder="搜尋使用者名稱">
<button id="finduser">搜尋</button>
<div id="error" style="color:red;"></div>
<div id="chatlist">
<?php
$namehash = hash('sha256', $username);
$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
foreach($data as $key => $value){
	$func = "send('".$key."')>";
	echo '<button onclick='.$func.$key.'</button><br>';
}
?>
</div>
</div>
<div class="middle">
<div class="chat_to" id="chat_to">選個朋友來聊天吧!</div>
<div class="msg" id="msg"></div>
<input class="input_msg" id="input_msg" type="text" placeholder="輸入訊息"><button id="commit" style="float: right;">傳送</button><button id="upload" style="float: left;">上傳檔案</button>
<form action = "uploadfile.php" method = "POST" enctype = "multipart/form-data" target = "_blank">
	<input type = "file" name = "image" />
	<input type = "submit"/>
</form>
</div>
</div>
	
</body>

</html>
