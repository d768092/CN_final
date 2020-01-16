<?php
	$file_path = $_POST["path"];
	//echo $file_path." ";
	$filename = substr($file_path, 7);
	//echo $filename;
	header("Content-Type: application/octet-stream");
	header("Content-Transfer-Encoding: Binary");
	header("Content-disposition: attachment; filename=\"".$filename."\"");
	readfile($file_path);
?>
