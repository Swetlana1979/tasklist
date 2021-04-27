<?php
	session_start();
	unset($_SESSION['session_login']);
	unset($_SESSION['session_id']);
	session_destroy();
	header("location:index.php");
?>