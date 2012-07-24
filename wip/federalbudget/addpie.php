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
	$slice_def = htmlentities(strip_tags(trim($_POST['slice_def'])), ENT_QUOTES, 'UTF-8');
	$slice_hel = htmlentities(strip_tags(trim($_POST['slice_hel'])), ENT_QUOTES, 'UTF-8');
	$slice_sci = htmlentities(strip_tags(trim($_POST['slice_sci'])), ENT_QUOTES, 'UTF-8');
	$slice_agr = htmlentities(strip_tags(trim($_POST['slice_agr'])), ENT_QUOTES, 'UTF-8');
	$slice_crd = htmlentities(strip_tags(trim($_POST['slice_crd'])), ENT_QUOTES, 'UTF-8');
	$slice_soc = htmlentities(strip_tags(trim($_POST['slice_soc'])), ENT_QUOTES, 'UTF-8');
	$slice_edu = htmlentities(strip_tags(trim($_POST['slice_edu'])), ENT_QUOTES, 'UTF-8');
	$slice_tra = htmlentities(strip_tags(trim($_POST['slice_tra'])), ENT_QUOTES, 'UTF-8');
	$slice_ene = htmlentities(strip_tags(trim($_POST['slice_ene'])), ENT_QUOTES, 'UTF-8');
	$slice_inc = htmlentities(strip_tags(trim($_POST['slice_inc'])), ENT_QUOTES, 'UTF-8');
	$slice_oth = htmlentities(strip_tags(trim($_POST['slice_oth'])), ENT_QUOTES, 'UTF-8');


	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
	$ip = addslashes(strip_tags(trim($TheIp)));

	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$result_locale = mysql_query("SET NAMES 'utf8'");

	$query = "INSERT INTO `cooked_pies` (`politics`,`state`,`gender`,`zip`, `age`, `pie`, `ip`, `time`, `comment`, `slice_def`, `slice_hel`, `slice_sci`, `slice_agr`, `slice_crd`, `slice_soc`, `slice_edu`, `slice_tra`, `slice_ene`, `slice_inc`, `slice_oth`) " .
		"VALUES (" .
		"'$politics', '$state', '$gender', '$zip', $age, '$pie', '$ip', NOW(), '$comment', '$slice_def', '$slice_hel', '$slice_sci', '$slice_agr', '$slice_crd', '$slice_soc', '$slice_edu', '$slice_tra', '$slice_ene', '$slice_inc', '$slice_oth') ";

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