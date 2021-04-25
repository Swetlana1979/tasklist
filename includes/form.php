<?php ?>
<div class="container mregister">
	<div id="login">
	<h1>Регистрация</h1>
	<form action="register.php" id="registerform" method="post"name="registerform">
		<p><label for="user_pass">Имя пользователя<br>
		<input class="input" id="login" name="login"size="20" type="text" value=""></label></p>
		<p><label for="user_pass">Пароль<br>
		<input class="input" id="password" name="password"size="32"   type="password" value=""></label></p>
		<p class="submit"><input class="button" id="register" name= "register" type="submit" value="Зарегистрироваться"></p>
		<p class="regtext">Уже зарегистрированы? <a href= "login.php">Введите имя пользователя</a>!</p>
	</form>
	</div>
</div>