<?php	
session_start();

require_once("/var/www/vhosts/participie.com/httpdocs/config.php");
			
if(isset($_POST)) {
	$politics = htmlentities(strip_tags(trim($_POST['politics'])), ENT_QUOTES, 'UTF-8');
	$state = htmlentities(strip_tags(trim($_POST['state'])), ENT_QUOTES, 'UTF-8');
	$gender = htmlentities(strip_tags(trim($_POST['gender'])), ENT_QUOTES, 'UTF-8');
	$age = htmlentities(strip_tags(trim($_POST['age'])), ENT_QUOTES, 'UTF-8');
	$zip = htmlentities(strip_tags(trim($_POST['zip'])), ENT_QUOTES, 'UTF-8');
	$comment = htmlentities(strip_tags(trim($_POST['comment'])), ENT_QUOTES, 'UTF-8');
	$pie = htmlentities(strip_tags(trim($_POST['pie'])), ENT_QUOTES, 'UTF-8');
	
	//extract the pie's slices' values so that we can store them individually
	$slice_war = htmlentities(strip_tags(trim($_POST['slice_war'])), ENT_QUOTES, 'UTF-8');
	$slice_gay = htmlentities(strip_tags(trim($_POST['slice_gay'])), ENT_QUOTES, 'UTF-8');
	$slice_mar = htmlentities(strip_tags(trim($_POST['slice_mar'])), ENT_QUOTES, 'UTF-8');
	$slice_edu = htmlentities(strip_tags(trim($_POST['slice_edu'])), ENT_QUOTES, 'UTF-8');
	$slice_hel = htmlentities(strip_tags(trim($_POST['slice_hel'])), ENT_QUOTES, 'UTF-8');
	$slice_eco = htmlentities(strip_tags(trim($_POST['slice_eco'])), ENT_QUOTES, 'UTF-8');
	$slice_gun = htmlentities(strip_tags(trim($_POST['slice_gun'])), ENT_QUOTES, 'UTF-8');
	$slice_pri = htmlentities(strip_tags(trim($_POST['slice_pri'])), ENT_QUOTES, 'UTF-8');
	$slice_glo = htmlentities(strip_tags(trim($_POST['slice_glo'])), ENT_QUOTES, 'UTF-8');
	
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
	$ip = addslashes(strip_tags(trim($TheIp)));

	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$result_locale = mysql_query("SET NAMES 'utf8'");

	$query = "INSERT INTO `cooked_pies_talkingpoints` (`politics`,`state`,`gender`,`zip`, `age`, `pie`, `ip`, `time`, `comment`, `slice_war`, `slice_gay`, `slice_mar`, `slice_edu`, `slice_hel`, `slice_eco`, `slice_gun`, `slice_pri`, `slice_glo`) " .
		"VALUES (" .
		"'$politics', '$state', '$gender', '$zip', $age, '$pie', '$ip', NOW(), '$comment', '$slice_war', '$slice_gay', '$slice_mar', '$slice_edu', '$slice_hel', '$slice_eco', '$slice_gun', '$slice_pri', '$slice_glo') ";
		
	//echo $query;
		
	$result = mysql_query($query);
		
	if(!$result) {
		$content .= "Oops, something messed up";
		$content .= 'Oops, mysql messed up: ' . mysql_error() . "\n";
		$content .= 'Whole query: ' . $query;
		echo $content;
	}
	else {
		//echo "SUCCESS!";
		echo mysql_insert_id();
	}
}
?>