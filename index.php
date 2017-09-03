<?php
	require_once('assist/functions.php');
	session_start();
	
	if (isPost()) {

		$fio=htmlspecialchars($_POST['fio']);
		

		if (!empty($fio)) {

			$login = htmlspecialchars($_POST['login']);
			$password=htmlspecialchars($_POST['password']);
			$captcha=htmlspecialchars($_POST['captcha']);
			$_SESSION['s_fio']=$fio;

			if (empty($login) & empty($password)) {
				header('Location: list.php');	
			}

			if (checkBlock()) {
				echo '<p>Вы заблокированы, попробуйте авторизоваться через час</p>';
			}
			else {

				if (checkAuth($login, $password, $captcha)) {
					header('Location: admin.php');	
				}
				else {
					echo '<p>Ошибка: неправильные логин / пароль</p>';
				}

			}

		}
		else {
			echo '<p>Ошибка:введите имя</p>';
		}
	}	
	
?>

<html>
	<head>
	<title>Авторизация</title>
	</head>
	<body>
		<form method='POST'>
			<h1>Авторизуйтесь (либо введите только ФИО, чтобы зайти как гость)</h1>
			<p>Для преподаватель логин / пароль: admin и user (соответственно)</p>
			<p>ФИО <input type="text" name="fio" placeholder='ФИО'></p>
			<p>Логин <input type="text" name="login" placeholder='Логин'></p>
			<p>Пароль <input type="password" name="password" placeholder='Пароль'></p>
			<style type="text/css">
				<?php if (!checkCaptcha()) : ?>
					.captcha {display: none;}
				<?php endif; ?>	
			</style>
			<div class='captcha'>
				<img src="assist/captcha.php?visible=<?=checkCaptcha().'"'?> alt="">
				<p>Введите текст с картинки <input type="text" name="captcha" placeholder='Капча'></p>
			</div>

			<p><input type='submit' value='Отправить'></p> 
		</form>
	</body>
</html>		

