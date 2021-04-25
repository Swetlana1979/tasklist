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
		$query=mysqli_query($con, "SELECT * FROM users WHERE login='".$login."'");
		$numrows=mysqli_num_rows($query);
	if($numrows==0)
	{
		$created_at = date("Y-m-d H:i:s");
		$sql="INSERT INTO users(login, password,created_at)VALUES('$login','$password','$created_at')";
		$result=mysqli_query($con,$sql);
		$sql_id="SELECT id FROM 'users' WHERE login=$login AND created_at=$created_at";
		$user_id=mysqli_query($con,$sql_id);
		try_log($login, $user_id);
	} else {
			while($row=mysqli_fetch_assoc($query))
			{
				$dblogin=$row['login'];
				$dbpassword=$row['password'];
				$dbid=$row['id'];
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