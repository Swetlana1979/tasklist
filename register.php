<?php
	session_start();
?>
<?php require_once("includes/connection.php");
 function try_log($login, $user_id){
	 $_SESSION['session_login']=$login;
	 $_SESSION['session_id']=$user_id;
     header("Location:index.php");
 }
if(isset($_POST["register"])){
	if(!empty($_POST['login']) && !empty($_POST['password'])){
		$login=htmlspecialchars($_POST['login']);
		$password=htmlspecialchars($_POST['password']);
		$stmt = mysqli_prepare($con, "SELECT * FROM users WHERE login=?"); 
		if(!$stmt){
			'не удалось получить данные';		  
		}
		mysqli_stmt_bind_param($stmt, "s", $login);
		mysqli_stmt_execute($stmt);
		$numrows = mysqli_stmt_get_result($stmt);
		mysqli_stmt_close($stmt);
		
		if($numrows==0)
		{
			$created_at = date("Y-m-d H:i:s");
			$stmt = mysqli_prepare($con, "INSERT INTO users(login, password,created_at)VALUES(?,?,?)"); 
			mysqli_stmt_bind_param($stmt, "sss", $login, $password, $created_at);
		
			if(mysqli_stmt_execute($stmt)){
				$login=htmlspecialchars($_POST['login']);
				$password=htmlspecialchars($_POST['password']);
				header("Location:register.php?login=$login&password=$password");
			} else {
				echo 'ошибка авторизации';
			}
			mysqli_stmt_close($stmt);
		} else {
			foreach($numrows as $key=>$value){
				$dblogin=$value['login'];
				$dbpassword=$value['password'];
				$dbid=$value['id'];
			
			}
			if($login == $dblogin && $password == $dbpassword)
			{
				try_log($login,$dbid);
			} else {
				echo  "Invalid username or password!";
			}
		} 
	}
}

include("includes/header.php"); 
include("includes/form.php");
include("includes/footer.php"); 

if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>