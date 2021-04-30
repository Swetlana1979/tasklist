<?php
	session_start();

if(empty($_SESSION['session_login'])){
	header("Location:register.php");
}
require_once("includes/connection.php");
include("includes/header.php"); ?>

<div class="container">
	<h2>Добро пожаловать, <span><?php echo $_SESSION['session_login'];?>! </span></h2>
	<p><a href="logout.php">Выйти</a> из системы</p>
	<h1>Task list</h2>
	
	<div id='add'>
	<form id='add_description' name='add_description' action='' method='post'>
		<input type='text' name='description' id='description'>
		<input type='submit' id='add_desc' name='add_desc'  class='sub' value="ADD TASK"><br>
		<input type='submit' id='del' name='del' class='sub' value="REMOVE ALL">
		<input type='submit' id='ready' name='ready' class='sub' value="READY ALL">
	</form>
</div>

<?php
	$name=$_SESSION['session_login'];
	$user_id=$_SESSION['session_id'];
		
	function reverse_date($date)
	{
        $s=substr($date,3,1);
        if($s=="."){
	        $mass=explode('.',$date);
			$mass=array_reverse($mass);
			$date=implode('-',$mass);
			
			}
		else{
		  $mass=explode('-',$date);
			$mass=array_reverse($mass);
		  $date=implode('.',$mass);
		}
		return $date;
	}
	function Output($arr){
		if(!empty($arr)){
			echo"<table><tr><td>№</td><td>description</td><td>created_at</td><td>status</td></tr>";
			for($i=0; $i<count($arr); $i++){
				$status=$arr[$i]['3'];
				$read_stat=($status=='готово')? "NO READY":"READY";
				$created_at=$arr[$i]['2'];
				$dateTime=explode(" ", $created_at);
				$time=$dateTime[1];
				$date=reverse_date($dateTime[0]);
				$created_at=$date." ".$time;
				$str="<tr><form class=blok name='task_form".$i."' action='index.php' method='post'><td>".
				$arr[$i]['0']."</td><td>".$arr[$i]['1']."</td><td>".$created_at."</td><td>".$arr[$i]['3'].
				"</td></tr><tr><td>
				<input type='submit' name='ready_task' class='sub' value='".$read_stat."'></td><td>
				<input type='hidden' id='stat' name='stat' size='10' width='10' color='red' value='".$status."'></td><td>
				<input type='submit' name='delete_task' class='sub' value='DELETE'></td><td>
				<input type='hidden' name='num' value='".$arr[$i]['0']."'></td>
				</form></tr>";
				echo $str;				
			}
			echo"</table>";
		}
	}
	$stmt = mysqli_prepare($con, "SELECT users.login, tasks.id, tasks.description, tasks.created_at,tasks.status FROM `users`,`tasks` 
	WHERE tasks.user_id = users.id AND users.login= ?"); 
	if(!$stmt){
		'не удалось получить данные';		  
	}
	 mysqli_stmt_bind_param($stmt, "s", $name);
		
     function to_get_data($stmt){
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
		return $result;
	 }
	 $result=to_get_data($stmt);

	$res=array();
	if($result){
		foreach($result as $key=>$value){
			$status="готово";
			if($value['status']==0){
				$status="не готово";
			}
			$res[]=array($value['id'],$value['description'],$value['created_at'],$status);
		}
		Output($res);
	} else {
		echo "Произошла ошибка";
	}
	
	if(isset($_POST["add_desc"])){
		if(!empty($_POST['description'])){
			$created_at=date("Y-m-d H:i:s");
			$description=htmlspecialchars($_POST["description"]);
			$stmt = mysqli_prepare($con, "INSERT INTO tasks(user_id, description, created_at, status)VALUES(?,?,?, 0)"); 
        	mysqli_stmt_bind_param($stmt, "iss", $user_id, $description, $created_at);
		}
		if(mysqli_stmt_execute($stmt)){
			echo("<meta http-equiv='refresh' content='1'>");
		} else {
			echo 'задание не добавленно';
		}
		mysqli_stmt_close($stmt);
	}
	
	if(isset($_POST["del"])){
		$stmt = mysqli_prepare($con,"DELETE FROM tasks WHERE user_id=?");
		mysqli_stmt_bind_param($stmt, "i", $user_id);
		if(mysqli_stmt_execute($stmt)){
			echo("<meta http-equiv='refresh' content='1'>");
		} else {
			echo 'не удалось удалить данные';
		}
		mysqli_stmt_close($stmt);
	}
	if(isset($_POST["ready"])){
		$stmt = mysqli_prepare($con,"UPDATE tasks SET status = 1 WHERE user_id=?");
		mysqli_stmt_bind_param($stmt, "i", $user_id);
		if(mysqli_stmt_execute($stmt)){
			echo("<meta http-equiv='refresh' content='1'>");
		} else {
			echo 'не удалось удалить данные';
		}
		mysqli_stmt_close($stmt);
	}
	if(isset($_POST["ready_task"])){
		$id_task=htmlspecialchars($_POST["num"]);
		$stat=htmlspecialchars($_POST["stat"]);
		if($stat =='не готово'){
			$num=1;
		} else{
			$num=0;
		} 
		$stmt = mysqli_prepare($con,"UPDATE tasks SET status = ? WHERE user_id=? AND id=?");
		mysqli_stmt_bind_param($stmt, "iii", $num,$user_id, $id_task);
		if(mysqli_stmt_execute($stmt)){
			echo("<meta http-equiv='refresh' content='1'>");
		} else {
			echo 'не удалось изменить статус';
		}
		mysqli_stmt_close($stmt);
	}
	
	if(isset($_POST["delete_task"])){
		$id_task=htmlspecialchars($_POST["num"]);
		$stmt = mysqli_prepare($con,"DELETE FROM tasks WHERE user_id=? AND id=?");
		mysqli_stmt_bind_param($stmt, "ii", $user_id, $id_task);
		if(mysqli_stmt_execute($stmt)){
			echo("<meta http-equiv='refresh' content='1'>");
		} else {echo 'не удалось удалить данные';}
		mysqli_stmt_close($stmt);
	}
	?>
</div>
<?php include("includes/footer.php"); ?>
	

