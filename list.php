<?php

  session_start();
  require_once('assist/functions.php');

  if (Alien()) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    echo "403 Forbidden";
    exit;
  }

   $dir = 'test/';
   $check = false;
   $files = [];


		if (is_dir($dir)) {
   		
      	if ($dh = opendir($dir)) {
   				
       			while (($file = readdir($dh)) !== false) {
	           		
	           		if (end(explode(".", $file))=='json') {
	           			$check=true;
	           			$files[]=$dir . $file;
	           		}
       			} 

       		closedir($dh);
   			}
   	}	
  	
   	if (!$check & !Guest()) {
   		header('Location: admin.php');
    } 
    elseif (!$check & Guest()) {
      header('Location: index.php');
   	}

  ?>

<html>
<head>
  <title>Выбор теста</title>
</head>
<body>
  <h2>Выберите тест</h2>

  <form method='GET' action='test.php'>
    <?php foreach ($files as $value) : ?>
        <p><input type='radio' name='rb' value=<?=$value?>><?=$value?></p>
    <?php endforeach; ?>
  
  <input type='submit' value='Отправить'>
  </form>
  
  <style type="text/css">
    <?php if (Guest()) : ?>
      .ref {display: none;}
    <?php endif; ?> 
  </style>

  <p class='ref'><a href='admin.php'>возврат к загрузке тестов</a></p>
  <p><a href='index.php'>авторизация</a></p>
</body>
</html>