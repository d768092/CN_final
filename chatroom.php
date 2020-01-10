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
		$(document).ready(function() {
			$("#chatlist").load("chatlist.php");
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
	<!--<link rel="stylesheet" href="./login.css">-->
</head>
<body>
<h1><?php echo $username; ?></h1>
<input id="findname" type="text" placeholder="搜尋使用者名稱"><button id="finduser">搜尋</button>
<p id="error" style="color:red;"></p>
<div id="chatlist"></div>	
	
</body>

</html>
