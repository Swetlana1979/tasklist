<?php
	session_start();

if(empty($_SESSION['session_login'])){
	header("Location:register.php");
}
require_once("includes/connection.php");
include("includes/header.php"); ?>
<div class="container">
	<div id="welcome">
		<h2>Добро пожаловать, <span><?php echo $_SESSION['session_login'];?>! </span></h2>
		<p><a href="logout.php">Выйти</a> из системы</p>
		<h1>Task list</h2>
	</div>
	<div id='add'>
	<form id='add_description' name='add_description' action='' method='post'>
		<input type='text' name='description' id='description'>
		<input type='submit' id='add_desc' name='add_desc' value="ADD TASK">
		<input type='submit' id='del' name='del' value="REMOVE ALL">
		<input type='submit' id='ready' name='ready' value="READY ALL">
	</form>
	</div>
	<?php
	$name=$_SESSION['session_login'];
	$user_id=$_SESSION['session_id'];
	function Output($arr){
		
		if(!empty($arr)){
			for($i=0; $i<count($arr); $i++){
				foreach ($arr[$i] as $key=>$value){
				echo $arr['0']." ".$value[1]." ".$value[2]." ".$value[3]."<br>";
					//$num=$i+1
					//echo "<div id=blok".$i."><form name= action='index.php' method='post'>".$value."<input type='submit' name='ready' value='READY'> "."<input type='submit' name='delete' value='DELETE'> <input type='text' name='status' value='".$status."'></form></div>"."<br>";
				}
				
                //unset($array[$i]);				
			}
		}
	}
	function reverse_date($date)
	{
        $s=substr($date,2,1);
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
	$sql="SELECT users.login, tasks.id, tasks.description, tasks.created_at,tasks.status FROM `users`,`tasks` WHERE users.login='".$name."'AND tasks.user_id=users.id";
	$result=mysqli_query($con,$sql);
	$res=array();
	if($result){
		foreach($result as $key=>$value){
			$status="готово";
			if($value['status']==0){$status="не готово";}
			$created_at=reverse_date($value['created_at']);
			/*echo "<div id=blok".$value['id']."><form name='' action='index.php' method='post'>";
			echo $value['id']." ".$value['description']." ".$value['created_at']." ".$status."<br>";*/
			$res[]=array($value['id'],$value['description'],$created_at,$status);
			/*echo "<input type='hidden'  name='num' value='".$value['id']."'>
			<input type='submit'  name='raedy_task' value='READY'>
			<input type='submit' name= 'del_task' value='DELETE'>
			</fotm>.</div>";*/
		}
		
	$_SESSION['array']=$res;
	$res_arr=$_SESSION['array'];
	print_r($res);
	Output($res_arr);
	
	} else {
		echo "Произошла ошибка";
	}
	if(isset($_POST["add_desc"])){
		if(!empty($_POST['description'])){
			$created_at=date("Y-m-d H:i:s");
			
			$description=htmlspecialchars($_POST["description"]);
			$sql="INSERT INTO tasks(user_id, description, created_at, status)VALUES('$user_id','$description','$created_at', 0)";
			$result=mysqli_query($con,$sql);
		}
		echo("<meta http-equiv='refresh' content='1'>");
	}
	if(isset($_POST["del"])){
		$sql="DELETE FROM tasks WHERE user_id=$user_id";
		$result=mysqli_query($con,$sql);
		echo("<meta http-equiv='refresh' content='1'>");
	}
	if(isset($_POST["ready"])){
		$sql="UPDATE tasks SET status = 1 WHERE user_id=$user_id";
		$result=mysqli_query($con,$sql);
		echo("<meta http-equiv='refresh' content='1'>");
	}
	if(isset($_POST["ready_task"])){
		echo "hello";
		/*$id_task=htmlspecialchars($_POST["task_num"]);
		echo $id_task;
		$sql="UPDATE tasks SET status = 1 WHERE user_id=$user_id AND id=$id_task";
		$result=mysqli_query($con,$sql);
		echo("<meta http-equiv='refresh' content='1'>");*/
	}
	?>
</div>
<?php include("includes/footer.php"); ?>
	

