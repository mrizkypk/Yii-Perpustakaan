<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Masukkan Kata Sandi</title>
	<link rel="stylesheet" href="<?php echo Url::home(true); ?>css/login.css">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo Url::home(true); ?>favicon.png">
</head>

<body>

  <div class="wrapper">
	<div class="container">
		<?php if (isset($_GET['proses'])): ?>
		<h1 class="error">Kata Sandi Salah</h1>
		<?php else: ?>
		<h1>Masukkan Kata Sandi</h1>
		<?php endif; ?>
		<form method="post" class="form" action="<?php echo Url::to('masuk-proses'); ?>?root=ya">
			<input name="password" type="password" placeholder="Ketik di sini...">
			<button type="submit" id="login-button">Masuk</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<script src="<?php echo Url::home(true); ?>js/jquery.js"></script>
<script src="<?php echo Url::home(true); ?>js/login.js"></script>
</body>
</html>