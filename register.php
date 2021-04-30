<?php
	session_start();

	require_once("includes/connection.php");
	function Try_log($login, $user_id){
		$_SESSION['session_login'] = $login;
		$_SESSION['session_id'] = $user_id;
		header("Location:index.php");
	}
	
	if(isset($_POST["register"])){
		if(!empty($_POST['login']) && !empty($_POST['password'])){
			$login = htmlspecialchars($_POST['login']);
			$password = htmlspecialchars($_POST['password']);
			$stmt = mysqli_prepare($con, "SELECT * FROM users WHERE login = ?"); 
			if(!$stmt){
				echo 'не удалось получить данные';		  
			}
			mysqli_stmt_bind_param($stmt, "s", $login);
			mysqli_stmt_execute($stmt);
			$numrows = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_array($numrows, MYSQLI_NUM);
			mysqli_stmt_close($stmt);
			
		if($row == 0){
			$created_at = date("Y-m-d H:i:s");
			$stmt = mysqli_prepare($con, "INSERT INTO users(login, password,created_at)VALUES(?,?,?)"); 
			mysqli_stmt_bind_param($stmt, "sss", $login, $password, $created_at);
			if(mysqli_stmt_execute($stmt)){
				$login = htmlspecialchars($_POST['login']);
				$password = htmlspecialchars($_POST['password']);
				header("Location:register.php?login = $login&password = $password");
			} else {
				echo 'ошибка авторизации';
			}
			mysqli_stmt_close($stmt);
		} else {
				foreach($numrows as $key=>$value){
					$dblogin = $value['login'];
					$dbpassword = $value['password'];
					$dbid = $value['id'];
				}
				if($login == $dblogin && $password == $dbpassword){
					Try_log($login,$dbid);
				} else {
					echo  "Invalid username or password!";
				}
			} 
		}
	}

	include("includes/header.php"); 
	include("includes/form.php");
	include("includes/footer.php"); 

	if (!empty($message)) {
		echo "<p class = 'error'>" . "MESSAGE: ". $message . "</p>";
	} 
?>