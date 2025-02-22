<?php
session_start();

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
}
else{
	header('Location: index.php');
	exit;
}
ini_set("Allow_url_Fopen", "On");
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		var onsend=0;

		function send(name){
			$('#chat_to').text(name);
			$.post('sendmsg.php',
				{chat_to: name, timestamp: 0, order: 'keep'},
				function(response){
					// console.log(response);
					var json=JSON.parse(response);
					if(json.hasOwnProperty("message")){
						$('#msg').html(json.message);
						$('#timestamp').text(json.timestamp);
				 		msg.scrollTop=msg.scrollHeight;
					}
					else{
						$('#findname').val('');
						$('#msg').text('');
						$('#timestamp').text('0');
					}
				}
			)
		}

		function sendmsg()
		{
			onsend=1;
			$.post('sendmsg.php',
			{chat_to: document.getElementById("chat_to").textContent,
			 input_msg: document.getElementById("input_msg").value,
             timestamp: document.getElementById("timestamp").textContent,
             order: 'change'},
			 function(response){
				onsend=0;
				var json=JSON.parse(response);
				if(json.hasOwnProperty("message")){
					$('#msg').append(json.message);
					$('#timestamp').text(json.timestamp);
			 		$('#input_msg').val('');
					msg.scrollTop=msg.scrollHeight;
			 	}
			})
		}

		function getmsg(){
			if(onsend==0){
				$.post('sendmsg.php',
					{chat_to: document.getElementById("chat_to").textContent,
					timestamp: document.getElementById("timestamp").textContent,
					order: 1},
					function(response){
						var json=JSON.parse(response);
						if(json.hasOwnProperty("message")){
							$('#msg').append(json.message);
							$('#timestamp').text(json.timestamp);
							if(json.message!="") msg.scrollTop=msg.scrollHeight;
						}
					}
				)
			}		
		}
		setInterval(getmsg, 2000);

		function sendfile()
		{
            var temp = ($("input[name=file]").val());
			if (temp=='') return;
			var form = document.getElementById("upload");
			var formData = new FormData(form);
			$.ajax({
				url: 'uploadfile.php',
				data: formData,
				type: 'POST',
				processData: false,
				contentType: false,
				success: function(response){
					if(response!='') alert(response);
					$("input[name=file]").val('');
					if(response.substr(0, 12)=='Successfully'){
						$.post('add_to_file.php',
						{chat_to : document.getElementById("chat_to").textContent,
						file_name: temp.substr(12)},
						function(response){;})
						onsend=1;
						$.post('sendmsg.php',
						{chat_to : document.getElementById("chat_to").textContent,
						input_msg: 'file: '+ temp.substr(12),
						timestamp:  document.getElementById("timestamp").textContent,
						order: 'change'},
						function(response){	
							var json=JSON.parse(response);
							if(json.hasOwnProperty("message")){
								$('#msg').append(json.message);
								$('#timestamp').text(json.timestamp);
								msg.scrollTop=msg.scrollHeight;
							}
						})
					}
				}
			});
		}

		function getwhofile(){
			$.post('getwhofile.php',
			{timestamp: document.getElementById("timestamp").textContent},
			function(response){
				if(response != "")	alert(response);
			})
		}
		setInterval(getwhofile, 60000);

		function showname(){
		 	var temp = ($("input[name=file]").val());
			if(temp!='') alert('Select Files: '+ temp.substr(12));
		}

		function setvalue(){
			$("input[name=chat_to]").val($("#chat_to").text());
		}

		function dissubmit(){
			$('#submit_download').prop("disabled", true);
		}

		function downloadfile(){
			var form = document.getElementById("download");
			var formData = new FormData(form);
			$.ajax({
				url:	'checkfile.php',
				type: 	'POST',
				data:	formData,
				processData: false,
				contentType: false,
				success: function(response){
                    if(response == '') return;
					alert(response);
					if(response == "You can download the file!"){
						$('#submit_download').prop("disabled", false);
					}
				}
			})
		}

        function find_user() {
			$.post('finduser.php',
				{findname: $('#findname').val()},
				function(response){
					if(response=='error'){
						alert('請重新整理網頁!');
					}
					else if(response=='找不到用戶'){
						$('#error').text(response);
					}
					else{
						$('#findname').val('');
						$('#error').text('');
						$('#chatlist').append(response);
					}
				}
			)
		}

        function friends_order() {        
            $.post('friends_order.php', {username: $('h1').html()},
                function(response){
                    //$('#chatlist').html('');
                    $('#chatlist').html(response);
                }
            )
        }
        setInterval(friends_order, 2000);
     

	</script>
	<title>popCorN</title>
	<link rel="stylesheet" href="./chatroom.css">
</head>
<body>

<div class="header">
<h1><?php echo $username; ?>的聊天室</h1>
<input type="button" value="登出" onclick="location.href='logout.php'">
</div>
<div class="chatroom">
<div class="sidebar">
<input id="findname" type="text" placeholder="搜尋使用者名稱" onclick="find_user()">
<button id="finduser" style="float: left;" onclick="find_user()">搜尋</button>
<div id="error" style="width: 100px; color:red; overflow:hidden"></div>
<div id="chatlist" class="chatlist">
<?php
$namehash = hash('sha256', $username);
if(!is_dir('user_data')) mkdir('user_data', 0755);
$jsonfile = 'user_data/'.substr($namehash, 0, 16).'.json';
$json_string = file_get_contents($jsonfile);
$data = json_decode($json_string, true);
foreach($data as $key => $value) echo "<button onclick='send(\"$key\")'>".$key."</button><br>";
?>
</div>
</div>
<div class="middle">
<div class="chat_to" id="chat_to">選個朋友來聊天吧!</div>
<div class="msg" id="msg"></div>
<div id="timestamp" style="display: none;"></div>
<div class="msg_end" id="msg_end" style="height:0px;"></div>
<input class="input_msg" id="input_msg" type="text" placeholder="輸入訊息">
<button type="button "id="commit" onclick="sendmsg()" style="float: right;">傳送</button> 
<div class="form" style="float: left;">
<form enctype = "multipart/form-data" id = "upload">
	<input type = "file" name = "file" onclick="setvalue()" onchange="showname()"/>
	<input type = "button" value="傳送" onclick="sendfile()"/>
	<input type = "hidden" name = "chat_to"/>
</form>
</div>
<div class="form" style="float: right;">
<form action="download.php" method="POST" enctype="multipart/form-data"  id="download" onsubmit="dissubmit()">
	<input type = "text" name="path"/>
	<input type = "button" value="確認" onclick="downloadfile()"/>
	<input type = "submit" value="下載" id="submit_download" disabled="disabled"/>
</form>
</div>
</div>
</div>
</body>
</html>
