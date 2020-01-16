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
			//document.getElementById("upload").elements["chat_to"] = name;
			//echo document.getElementById("upload");
			$.post('sendmsg.php',
				{chat_to: name},
				function(response){
					$('#msg').html(response);
				}
			)
		}
		
	
		$(document).ready(function() {
			$("#finduser").click(function() {
				//document.getElementById("chat_to").textContent = "pogger"; 
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
<div id="error" style="color:red; overflow:hidden"></div>
<div id="chatlist">
<?php
$namehash = hash('sha256', $username);
$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
//echo $jsonfile;
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
<div class="msg" id="msg">
<!--<div class="others">別人的訊息框</div>-->
<!--<div class="mine">我的訊息框</div>-->
</div>
<div class="msg_end" id="msg_end" style="height:0px;"></div>
<input class="input_msg" id="input_msg" type="text" placeholder="輸入訊息">
<button type="button "id="commit" onclick="sendmsg()" style="float: right;">傳送</button> 
<form action = "uploadfile.php" method = "POST" enctype = "multipart/form-data" target = "_blank" id = "upload" onsubmit = "sendmsg_file()">
	<input type = "file" name = "image" onclick="setvalue()" onchange="showname()"/>
	<input type = "submit"/>
	<!--<input type = "hidden" name = "chat_to"/>-->
</form>
<form action="download.php" method = "POST" enctype="multipart/form-data" targer="_blank" id="download">
	<input type = "text" name="path"/>
	<input type = "submit" value ="下載"/>
</form>
</div>
</div>
<script> 
		function sendmsg_file(){
			var temp = ($("input[name=image]").val())
			$.post('sendmsg.php',
			{chat_to : document.getElementById("chat_to").textContent,
			input_msg: 'upload/'+ temp.substr(12)},
			function(response){;}
			)
		}
		function showname(){
		 	var temp = ($("input[name=image]").val());
			alert('Select Files: '+ temp.substr(12));
		}
		function setvalue(){
			$("input[name=chat_to]").val($("#chat_to").text());
			//alert($("input[name=chat_to]").val());

		}
		function sendmsg()
		{
			$.post('sendmsg.php',
			{chat_to: document.getElementById("chat_to").textContent,
			 input_msg: document.getElementById("input_msg").value},
			 function(response){
			 	 $('#input_msg').val('');
				 $('#msg').html(response);
				 msg.scrollTop=msg.scrollHeight;
			 })
		}
		function getmsg(){
			$.post('sendmsg.php',
				{chat_to: document.getElementById("chat_to").textContent},
				function(response){
					$('#msg').html(response);
				}
			)
		}
		setInterval(getmsg, 5000);
</script>
</body>
</html>
