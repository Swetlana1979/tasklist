<div class = "container">
	<h2>Добро пожаловать, <span><?php echo $_SESSION['session_login'];?>! </span></h2>
	<p><a href = "logout.php">Выйти</a> из системы</p>
	<h1>Task list</h2>
	<div id = 'add'>
		<form id = 'add_description' name = 'add_description' action = '' method = 'post'>
			<input type = 'text' name = 'description' id = 'description'>
			<input type = 'submit' id = 'add_desc' name = 'add_desc'  class = 'sub' value = "ADD TASK"><br>
			<input type = 'submit' id = 'del' name = 'del' class = 'sub' value = "REMOVE ALL">
			<input type = 'submit' id = 'ready' name='ready' class='sub' value="READY ALL">
		</form>
	</div>
</div>