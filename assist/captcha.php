<?php
	session_start();

	if ($_GET['visible']) {
		$im = imagecreatetruecolor(250, 187);
		$text_color = imagecolorallocate($im, 19, 136, 8);
		$back_color = imagecolorallocate($im, 220, 220, 220);
		imagefill($im, 0, 0, $back_color);
		$imgpic=imagecreatefrompng('../images/captcha.png');
		$font = '../font/' . 'ofont.ru_Microsoft Sans Serif.ttf';
		$text=mt_rand(1,100000);
		$_SESSION['captcha']=$text;
		imagecopy($im, $imgpic, 0, 0, 0, 0, 250, 187);
		imagettftext($im, 45, -20, 10, 70, $text_color, $font, $text);
		header('Content-Type: image/png');
		imagepng($im);
		imagedestroy($im);
	}

?>