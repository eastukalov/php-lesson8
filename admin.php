<?php
	session_start();
	require_once('assist/functions.php');

	if (Alien() || Guest()) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
		echo "403 Forbidden";
		exit;
	}
?>

<html>
<head>
	<title>Обработка форм</title>
</head>
<body>

	<form method='post' action="redirect.php" enctype='multipart/form-data'>
		<p>Файл <input type='file' name='myfile'></p>
		<p><input type='submit' value='Отправить'></p>
	</form>
	
	<p><a href='index.php'>авторизация</a></p>
</body>
</html>

