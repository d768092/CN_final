<?php
session_start();

if(isset($_SESSION['username'])){
    header('Location: chatroom.php');
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
		$(document).ready(function() {
			$("#login").click(function () {
				$.post('login.php', 
					{username: $('#username').val(),
					password: $('#password').val()},
					function(response){
                    
						if(response=='success'){
							window.location='chatroom.php';
                        }
                        else if(response=='密碼錯誤'){
							$('#error').text(response);
							$('#password').val(''); 
                        }
						else{
							$('#error').text(response);
							$('#username').val('');
							$('#password').val('');
						}
					}
				)
			});
			$("#register").click(function () {
				$.post('register.php',
					{username: $('#username').val(),
					password: $('#password').val()},
					function(response){
						if(response=='success\n'){
							$('#error').text('帳號建立完成~');
						}
                        else if(response=='密碼：請輸入至少8個字元'){
                            $('#error').text(response);
                            $('#password').val('');
                        }
						else{
							$('#error').text(response);
							$('#username').val('');
							$('#password').val('');
						}
					}
				)
			});
		});
	</script>
    <title>popCorN</title>
	<link rel="stylesheet" href="./login.css">
</head>

<body>
    <div class="login">
	<div class="center">
		<h1>popCorN</h1>
			<div class="inputLi">
				<input id="username" type="text" class="user" placeholder="帳號" required>
			</div>
			<div class="inputLi">
				<input id="password" type="password" class="pwd" placeholder="密碼" required>
			</div>
			<p id="error" style="color:red; font-size: 18px;"></p>
			<div class="inputLi">
				<button id="login">登入</button>
			</div>
			<div class="inputLi">
				<button id="register">註冊</button>
			</div>
        </div>
    </div>	
</body>

</html>
