<?php	
session_start();

require_once("config.php");

if(isset($_POST)) {
	$politics = addslashes(strip_tags($_POST['politics']));
	$state = addslashes(strip_tags($_POST['state']));
	$gender = addslashes(strip_tags($_POST['gender']));
	$age = addslashes(strip_tags($_POST['age']));
	$pie = addslashes(strip_tags($_POST['pie']));
	$zip = addslashes(strip_tags($_POST['zip']));

	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
	$ip = addslashes(strip_tags(trim($TheIp)));

	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$result_locale = mysql_query("SET NAMES 'utf8'");

	$query = "INSERT INTO `cooked_pies` (`politics`,`state`,`gender`,`zip`, `age`, `pie`, `ip`) " .
		"VALUES (" .
		"'$politics', '$state', '$gender', '$zip', $age, '$pie', '$ip') ";
		
	$result = mysql_query($query);
		
	/*if (!$result) {
		$content .= "Oops, something messed up";
		$content .= 'Oops, mysql messed up: ' . mysql_error() . "\n";
		$content .= 'Whole query: ' . $query;
		echo $content;
	}
	else {
		echo "SUCCESS!";
	}*/
}
?>