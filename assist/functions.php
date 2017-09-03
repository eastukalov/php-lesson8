<?php
	define('JSON_FILE', __DIR__ . '/logins.json');

	function isPost() {
		return $_SERVER['REQUEST_METHOD']=='POST';
	}

	function checkAuth ($login, $password, $captcha) {
		
		if (!empty($login) && !empty($password)) {
			
			if (!is_readable(JSON_FILE)) {
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
				return false;
			}

			$users=json_decode(file_get_contents(JSON_FILE), true);

			if (count($users)==0) {
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
				return false;
			}

			foreach ($users as $user) {
				
				if ($user['login']==$login && $user['password']==md5($password)) {

					if (compareCaptcha($captcha)) {
						$_SESSION['s_count']=0;
						$_SESSION['s_time']=0;
						return true;
					}
					
				}

			}

		}

		$_SESSION['s_count'] = isset($_SESSION['s_count']) ? ($_SESSION['s_count'] + 1) : ($_SESSION['s_count'] = 1); 
		return false;
	}

	function checkCaptcha() {
		
		if (isset($_SESSION['s_count']) && $_SESSION['s_count'] > 6) {
			return true;
		}

		return false;
	}

	function compareCaptcha ($captcha) {
		
		if (!checkCaptcha()) {
			return true;
		}

		if (empty($captcha)) {
			return false;
		}

		$save_captcha = $_SESSION['captcha'];

		if (empty($save_captcha)) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
			return false;
		}

		if ($save_captcha!=$captcha) {
			return false;
		}

		return true;

	}

	function checkBlock() {

		if (isset($_SESSION['s_count']) && $_SESSION['s_count'] > 11) {
			
			if (isset($_SESSION['s_time']) && $_SESSION['s_time'] != 0) {

				if ((time() - $_SESSION['s_time']) <= 3600) {
					return true;
				}

				$_SESSION['s_count'] = 7;
				$_SESSION['s_time']=0;
			}
			else {
				$_SESSION['s_time']=time();
				return true;
			}
			
		}

		return false;

	}

	function Alien () {
		
		if (!isset($_SESSION['s_fio']) || empty($_SESSION['s_fio'])) {
			return true;
		}

		return false;
	}

	function Guest () {

		if (!isset($_SESSION['s_count']) || $_SESSION['s_count']!=0) {
			return true;
		}

		return false;
	}

?>