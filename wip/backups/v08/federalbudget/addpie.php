<?php	
session_start();

require_once("config.php");

if(isset($_POST)) {
	$politics = htmlentities(strip_tags(trim($_POST['politics'])), ENT_QUOTES, 'UTF-8');
	$state = htmlentities(strip_tags(trim($_POST['state'])), ENT_QUOTES, 'UTF-8');
	$gender = htmlentities(strip_tags(trim($_POST['gender'])), ENT_QUOTES, 'UTF-8');
	$age = htmlentities(strip_tags(trim($_POST['age'])), ENT_QUOTES, 'UTF-8');
	$pie = htmlentities(strip_tags(trim($_POST['pie'])), ENT_QUOTES, 'UTF-8');
	$zip = htmlentities(strip_tags(trim($_POST['zip'])), ENT_QUOTES, 'UTF-8');
	$comment = htmlentities(strip_tags(trim($_POST['comment'])), ENT_QUOTES, 'UTF-8');

	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
	$ip = addslashes(strip_tags(trim($TheIp)));

	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$result_locale = mysql_query("SET NAMES 'utf8'");

	$query = "INSERT INTO `cooked_pies` (`politics`,`state`,`gender`,`zip`, `age`, `pie`, `ip`, `time`, `comment`) " .
		"VALUES (" .
		"'$politics', '$state', '$gender', '$zip', $age, '$pie', '$ip', NOW(), '$comment') ";
		
	$result = mysql_query($query);
		
	if(!$result) {
		$content .= "Oops, something messed up";
		$content .= 'Oops, mysql messed up: ' . mysql_error() . "\n";
		$content .= 'Whole query: ' . $query;
		echo $content;
	}
	else {
		echo "SUCCESS!";
	}
}
?>