<?php
	require("constants.php");
	$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

/* проверка соединения */
if (!$con) {
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
   exit;
}
/*function Connect($link,$sql,$variable){
	if ($stmt = mysqli_prepare($link, $sgl)) {

    //связываем параметры с метками 
    mysqli_stmt_bind_param($stmt, "s", $variable);

    // запускаем запрос 
    mysqli_stmt_execute($stmt);

    // связываем переменные с результатами запроса 
    mysqli_stmt_bind_result($stmt, $district);

    //получаем значения 
    $array=mysqli_stmt_fetch($stmt);

    // закрываем запрос 
    mysqli_stmt_close($stmt);
	return $array;
}*/

	/*$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die("no connect");
	mysqli_select_db($con, DB_NAME) or die("Cannot select DB");*/
?>