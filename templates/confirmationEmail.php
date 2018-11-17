<?php return $mail = '<!DOCTYPE html>
<html>
<head>
	<title>Confirmation Email</title>
</head>
<body>
<style>
	*{margin:0px;padding:0px;font-family: Tahoma,  Helvetica, Arial, Verdana,  Georgia, Lucida, Trebuchet;}
	#container{max-width:800px; background:#eee;margin:0 auto;min-height:300px;margin-top:0px;padding-top:20px;}
	#container h1{
		margin:0px auto;
		color:#999;
		text-align: center;
	}
	p{
		padding:20px;
		color:#666;
	}
</style>

	<div id="container">
		<h1>Confirmation Email!</h1>
		<p>Good day from all of us in the Arabic Church, we would like to thank you for taking time and registering with us for our next conference, This is a confirmation email that we recieved your request to the coming conference</p>

		<p>Thanks</p>
		<p style="text-align:right;padding-right:80px">Church Team<br />' . date('m/d/Y') . '</p>
	</div>
</body>
</html>';