<?php	

//actions
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'getFederalBudgetPieById' : getFederalBudgetPieById($_POST['id']); break;
        case 'getTalkingPointsPieById' : getTalkingPointsPieById($_POST['id']); break;
    }
}

//e.g. $table can be = _topics_to_discuss or null for default
function getPieCounts($table) {
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "SELECT COUNT(id) as n FROM `cooked_pies" . $table;
		
	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result)) {
		return $row['n'];
	}
	else return null;
}

function getAverageFederalBudgetPie($where = "") {
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "SELECT count(id) as n, avg(slice_def) as def, avg(slice_sci) as sci, avg(slice_edu) as edu, "
		. "avg(slice_ene) as ene, avg(slice_tra) as tra, avg(slice_crd) as crd, avg(slice_agr) as agr, "
		. "avg(slice_oth) as oth, avg(slice_hel) as hel, avg(slice_inc) as inc, avg(slice_soc) as soc "
		. "FROM `cooked_pies`";
		
	if($where != "") $query .= " WHERE $where";
		
	//echo $query;

	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result)) {
		if($row['def'] == "") //if we don't have at least one pie for the politics category, return null
			return array(0,0);
			
		//build json and return it
		$strJson = "{'name': 'US_Budget','children': [{'name': 'DEF','label': 'Defense','size': {$row['def']},'which_pie': 'fb','color': '#cc3333'},{'name': 'SCI','label': 'Science, Space and Technology','size': {$row['sci']},'which_pie': 'fb','color': '#ea4c88'},{'name': 'EDU','label': 'Education','size': {$row['edu']},'which_pie': 'fb','color': '#663399'},{'name': 'ENE','label': 'Energy','size': {$row['ene']},'which_pie': 'fb','color': '#0066cc'},{'name': 'TRA','label': 'Transportation','size': {$row['tra']},'which_pie': 'fb','color': '#669900'},{'name': 'CRD','label': 'Community and Regional Development','size': {$row['crd']},'which_pie': 'fb','color': '#ffcc33'},{'name': 'AGR','label': 'Agriculture','size': {$row['agr']},'which_pie': 'fb','color': '#ff9900'},{'name': 'OTH','label': 'Other','size': {$row['oth']},'which_pie': 'fb','color': '#996633'},{'name': 'HEL','label': 'Healthcare','size': {$row['hel']},'which_pie': 'fb','color': '#663300'},{'name': 'INC','label': 'Income Security','size': {$row['inc']},'which_pie': 'fb','color': '#353535'},{'name': 'SOC','label': 'Social Security','size': {$row['soc']},'which_pie': 'fb','color': '#999999'}]}";
		return array($row['n'], $strJson); //return count of rows that were averages and the json block
	}
	else return array(0,0);
}

function getAverageTalkingPointsPie($where = "") {
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "SELECT count(id) as n, avg(slice_war) as war, avg(slice_gay) as gay, avg(slice_mar) as mar, "
		. "avg(slice_edu) as edu, avg(slice_hel) as hel, avg(slice_eco) as eco, avg(slice_gun) as gun, "
		. "avg(slice_pri) as pri, avg(slice_glo) as glo "
		. "FROM `cooked_pies_topics_to_discuss`";
		
	if($where != "") $query .= " WHERE $where";
		
	//echo $query;

	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result)) {
		if($row['gay'] == "") //if we don't have at least one pie for the politics category, return null
			return array(0,0);
			
		//build json and return it
		$strJson = $strJson = "{'name': 'US_Talking_Points','children': [{'name': 'WAR','label': 'War in Afghanistan','size': {$row['war']},'which_pie': 'tp','color': '#cc3333'},{'name': 'GAY','label': 'Gay marriage','size': {$row['gay']},'which_pie': 'tp','color': '#ea4c88'},{'name': 'MAR','label': 'Legalization of marijuana','size': {$row['mar']},'which_pie': 'tp','color': '#663399'},{'name': 'EDU','label': 'Education','size': {$row['edu']},'which_pie': 'tp','color': '#0066cc'},{'name': 'HEL','label': 'Healthcare','size': {$row['hel']},'which_pie': 'tp','color': '#669900'},{'name': 'ECO','label': 'Economy','color': '#ffcc33'},{'name': 'GUN','label': 'Gun laws','size': {$row['gun']},'which_pie': 'tp','color': '#ff9900'},{'name': 'PRI','label': 'Net Neutrality','size': {$row['pri']},'which_pie': 'tp','color': '#353535'},{'name': 'GLO','label': 'Global warming','size': {$row['glo']},'which_pie': 'tp','color': '#999999'}]}";
		return array($row['n'], $strJson); //return count of rows that were averages and the json block
	}
	else return array(0,0);
}	

function getFederalBudgetPieById($id) {
	if(!isset($id) || empty($id) || !is_numeric($id)) {
		echo 0;
		return 0;
	}
	
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "SELECT slice_def as def, slice_sci as sci, slice_edu as edu, "
		. "slice_ene as ene, slice_tra as tra, slice_crd as crd, slice_agr as agr, "
		. "slice_oth as oth, slice_hel as hel, slice_inc as inc, slice_soc as soc "
		. "FROM `cooked_pies` "
		. "WHERE id = " . $id;
		
	//echo $query;

	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result)) {
		//build json and return it
		$strJson = "{'name': 'US_Budget','children': [{'name': 'DEF','label': 'Defense','size': {$row['def']},'which_pie': 'fb','color': '#cc3333'},{'name': 'SCI','label': 'Science, Space and Technology','size': {$row['sci']},'which_pie': 'fb','color': '#ea4c88'},{'name': 'EDU','label': 'Education','size': {$row['edu']},'which_pie': 'fb','color': '#663399'},{'name': 'ENE','label': 'Energy','size': {$row['ene']},'which_pie': 'fb','color': '#0066cc'},{'name': 'TRA','label': 'Transportation','size': {$row['tra']},'which_pie': 'fb','color': '#669900'},{'name': 'CRD','label': 'Community and Regional Development','size': {$row['crd']},'which_pie': 'fb','color': '#ffcc33'},{'name': 'AGR','label': 'Agriculture','size': {$row['agr']},'which_pie': 'fb','color': '#ff9900'},{'name': 'OTH','label': 'Other','size': {$row['oth']},'which_pie': 'fb','color': '#996633'},{'name': 'HEL','label': 'Healthcare','size': {$row['hel']},'which_pie': 'fb','color': '#663300'},{'name': 'INC','label': 'Income Security','size': {$row['inc']},'which_pie': 'fb','color': '#353535'},{'name': 'SOC','label': 'Social Security','size': {$row['soc']},'which_pie': 'fb','color': '#999999'}]}";
		echo $strJson;
		return $strJson;
	}
	else {
		echo 0;
		return 0;
	}
}

function getTalkingPointsPieById($id) {
	if(!isset($id) || empty($id) || !is_numeric($id)) {
		echo 0;
		return 0;
	}
		
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "SELECT slice_war as war, slice_gay as gay, slice_mar as mar, "
		. "slice_edu as edu, slice_hel as hel, slice_eco as eco, slice_gun as gun, "
		. "slice_pri as pri, slice_glo as glo "
		. "FROM `cooked_pies_topics_to_discuss` "
		. "WHERE id = " . $id;
		
	//echo $query;

	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result)) {
		//build json and return it
		$strJson = "{'name': 'US_Talking_Points','children': [{'name': 'WAR','label': 'War in Afghanistan','size': {$row['war']},'which_pie': 'tp','color': '#cc3333'},{'name': 'GAY','label': 'Gay marriage','size': {$row['gay']},'which_pie': 'tp','color': '#ea4c88'},{'name': 'MAR','label': 'Legalization of marijuana','size': {$row['mar']},'which_pie': 'tp','color': '#663399'},{'name': 'EDU','label': 'Education','size': {$row['edu']},'which_pie': 'tp','color': '#0066cc'},{'name': 'HEL','label': 'Healthcare','size': {$row['hel']},'which_pie': 'tp','color': '#669900'},{'name': 'ECO','label': 'Economy','size': {$row['eco']},'color': '#ffcc33'},{'name': 'GUN','label': 'Gun laws','size': {$row['gun']},'which_pie': 'tp','color': '#ff9900'},{'name': 'PRI','label': 'Net Neutrality','size': {$row['pri']},'which_pie': 'tp','color': '#353535'},{'name': 'GLO','label': 'Global warming','size': {$row['glo']},'which_pie': 'tp','color': '#999999'}]}";
		echo $strJson;
		return $strJson;
	}
	else {
		echo 0;
		return 0;
	}
}
?>