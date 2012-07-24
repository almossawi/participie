<?php	

//actions
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'getFederalBudgetPieById' : getFederalBudgetPieById($_POST['id']); break;
        case 'getTalkingPointsPieById' : getTalkingPointsPieById($_POST['id']); break;
        case 'voteUp' : voteUp($_POST['id'], $_POST['pie']); break;
        case 'voteDown' : voteDown($_POST['id'], $_POST['pie']); break;
        case 'flagSubmission' : flagSubmission($_POST['id'], $_POST['pie']); break;
        case 'populateSeeMoreBox' : getAllDiscussionDataForSlice($_POST['slice'], $_POST['for_or_against'], $_POST['pie']); break;
        case 'submitArgument' : submitArgument($_POST); break;
        case 'submitOpinion' : submitOpinion($_POST); break;
    }
}


//e.g. $table can be = _talkingpoints or null for default
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
	
	//rebuild where clause to protect against injections (better way need, pass in as csv, todo)
	//where = {politics='RS', politics='RS' AND gender='M'}
	//it's decoded at this point (decoded in wallofpies_handler)
	if(strstr($where,";") || strlen($where) > 40) return "naughty naughty...";
	
	//quick check for sql injection (should be more elaborate than this, really...)
	//$where = mysql_real_escape_string($where);
	
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
	
	//rebuild where clause to protect against injections (better way need, pass in as csv, todo)
	//where = {politics='RS', politics='RS' AND gender='M'}
	//it's decoded at this point (decoded in wallofpies_handler)
	if(strstr($where,";") || strlen($where) > 40) return "naughty naughty...";
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "SELECT count(id) as n, avg(slice_war) as war, avg(slice_gay) as gay, avg(slice_mar) as mar, "
		. "avg(slice_edu) as edu, avg(slice_hel) as hel, avg(slice_eco) as eco, avg(slice_gun) as gun, "
		. "avg(slice_pri) as pri, avg(slice_glo) as glo "
		. "FROM `cooked_pies_talkingpoints`";
		
	if($where != "") $query .= " WHERE $where";

	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result)) {
		if($row['gay'] == "") //if we don't have at least one pie for the politics category, return null
			return array(0,0);
			
		//build json and return it
		$strJson = "{'name': 'US_Talking_Points','children': [{'name': 'WAR','label': 'War in Afghanistan','size': {$row['war']},'which_pie': 'tp','color': '#cc3333'},{'name': 'GAY','label': 'Gay marriage','size': {$row['gay']},'which_pie': 'tp','color': '#ea4c88'},{'name': 'MAR','label': 'Legalization of marijuana','size': {$row['mar']},'which_pie': 'tp','color': '#663399'},{'name': 'EDU','label': 'Education','size': {$row['edu']},'which_pie': 'tp','color': '#0066cc'},{'name': 'HEL','label': 'Healthcare','size': {$row['hel']},'which_pie': 'tp','color': '#669900'},{'name': 'ECO','label': 'Economy','color': '#ffcc33'},{'name': 'GUN','label': 'Gun laws','size': {$row['gun']},'which_pie': 'tp','color': '#ff9900'},{'name': 'PRI','label': 'Net Neutrality','size': {$row['pri']},'which_pie': 'tp','color': '#353535'},{'name': 'GLO','label': 'Global warming','size': {$row['glo']},'which_pie': 'tp','color': '#999999'}]}";
		return array($row['n'], $strJson); //return count of rows that were averages and the json block
	}
	else return array(0,0);
}	

function getAveragePieData($pie) {
	if($pie != "federalbudget" && $pie != "talkingpoints") return null;

	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	if($pie == "federalbudget") {
		$query = "SELECT avg(slice_def) as def, avg(slice_sci) as sci, avg(slice_edu) as edu, "
				. "avg(slice_ene) as ene, avg(slice_tra) as tra, avg(slice_crd) as crd, avg(slice_agr) as agr, "
				. "avg(slice_oth) as oth, avg(slice_hel) as hel, avg(slice_inc) as inc, avg(slice_soc) as soc "
				. "FROM `cooked_pies`";
	}
	elseif($pie == "talkingpoints") {
		$query = "SELECT avg(slice_war) as war, avg(slice_gay) as gay, avg(slice_mar) as mar, "
				. "avg(slice_edu) as edu, avg(slice_hel) as hel, avg(slice_eco) as eco, avg(slice_gun) as gun, "
				. "avg(slice_pri) as pri, avg(slice_glo) as glo "
				. "FROM `cooked_pies_talkingpoints`";
	}
				
	$result = mysql_query($query);
	
	if($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if($row['edu'] == "") //if we don't have at least one pie, return null
			return null;
	
		return $row;
	}
	else return null;
}

/*function getDiscussionDataForSliceForFederalBudget($slice) {
	if(strlen($slice) != 3) return null;
	$slice = htmlentities(strip_tags(trim($slice)), ENT_QUOTES, 'UTF-8');
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "(SELECT `cpd_id`, `for_which_slice`, `for_or_against`, `statement`, `evidence_article`, `up_votes`, `down_votes`, `public_opinion`, `author`, `city`, `state`, `country`, `timestamp`, up_votes-down_votes as score FROM `cooked_pies_discussions` "
			. "WHERE for_which_slice='$slice' AND for_or_against='f' AND approved=1 ORDER BY score DESC LIMIT 2) "
			. "UNION "
			. "(SELECT `cpd_id`, `for_which_slice`, `for_or_against`, `statement`, `evidence_article`, `up_votes`, `down_votes`, `public_opinion`, `author`, `city`, `state`, `country`, `timestamp`, up_votes-down_votes as score FROM `cooked_pies_discussions` "
			. "WHERE for_which_slice='$slice' AND for_or_against='a' AND approved=1 ORDER BY score DESC LIMIT 2)";
				
	$result = mysql_query($query);
	
	$arr_data;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$arr_data[] = $row;
	}
	
	return $arr_data;
}*/

function getDiscussionDataForSlice($slice, $pie) {
	if(strlen($slice) != 3) return null;
	$slice = htmlentities(strip_tags(trim($slice)), ENT_QUOTES, 'UTF-8');
	
	if($pie != "federalbudget" && $pie != "talkingpoints") return null;
	if($pie == "federalbudget") { $pie = ""; $which_pie = "federalbudget"; }
	elseif($pie == "talkingpoints") { $pie = "talkingpoints_";  $which_pie = "talkingpoints"; }
	
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "(SELECT `cpd_id`, `for_which_slice`, `for_or_against`, `statement`, `evidence_article`, `up_votes`, `down_votes`, `public_opinion`, A.author, A.city, A.state, A.country, A.timestamp, B.author as opinion_author, B.city as opinion_city, B.state as opinion_state, B.country as opinion_country, B.timestamp as opinion_timestamp, up_votes-down_votes as score FROM `cooked_pies_" . $pie . "discussions` A "
			. "LEFT JOIN public_opinions B ON cpd_id = pie_discussion_id and A.approved=1 and B.approved=1 AND which_pie='$which_pie' "
			. "WHERE for_which_slice='$slice' AND for_or_against='f' GROUP BY cpd_id ORDER BY score DESC LIMIT 2) "
			. "UNION "
			. "(SELECT `cpd_id`, `for_which_slice`, `for_or_against`, `statement`, `evidence_article`, `up_votes`, `down_votes`, `public_opinion`, A.author, A.city, A.state, A.country, A.timestamp, B.author as opinion_author, B.city as opinion_city, B.state as opinion_state, B.country as opinion_country, B.timestamp as opinion_timestamp, up_votes-down_votes as score FROM `cooked_pies_" . $pie . "discussions`  A "
			. "LEFT JOIN public_opinions B ON cpd_id = pie_discussion_id and A.approved=1 and B.approved=1 AND which_pie='$which_pie' "
			. "WHERE for_which_slice='$slice' AND for_or_against='a' GROUP BY cpd_id ORDER BY score DESC LIMIT 2)";
	//echo $query;		
	
	$result = mysql_query($query);
	
	$arr_data = null;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$arr_data[] = $row;
	}
	
	return $arr_data;
}

function getAllDiscussionDataForSlice($slice, $for_or_against, $pie) {
	if($for_or_against == 'f') $for_or_against = 'f';
	else if($for_or_against == 'a') $for_or_against = 'a';
	else return null;
	
	if($pie != "federalbudget" && $pie != "talkingpoints") return null;
	if($pie == "federalbudget") { $pie = ""; $which_pie = "federalbudget"; }
	elseif($pie == "talkingpoints") { $pie = "talkingpoints_";  $which_pie = "talkingpoints"; }
	
	
	$slice = htmlentities(strip_tags(trim($slice)), ENT_QUOTES, 'UTF-8');
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	/*$query = "SELECT `cpd_id`, `for_which_slice`, `for_or_against`, `statement`, `evidence_article`, `up_votes`, `down_votes`, `author`, `city`, `state`, `country`, `timestamp`, up_votes-down_votes as score "
			. "FROM `cooked_pies_" . $pie . "discussions` "
			. "WHERE for_which_slice='" . $slice . "' AND for_or_against='" . $for_or_against . "' AND approved=1 ORDER BY score DESC LIMIT 1000 ";
	*/

	//get one of the public opinions for this slice, if any; group by isn't really the best way to do this
	//better to use subqueries, but I've forgotten how to	
	//for some reason, the left outer join isn't working as expected, so for now, i give you, kluge...
	$row = mysql_query("SELECT count(*) from public_opinions where which_pie='$which_pie' and pie_discussion_id=");
	
	$query = "SELECT `cpd_id`, `for_which_slice`, `for_or_against`, `statement`, `evidence_article`, `up_votes`, `down_votes`, `public_opinion`, A.author, A.city, A.state, A.country, A.timestamp, B.author as opinion_author, B.city as opinion_city, B.state as opinion_state, B.country as opinion_country, B.timestamp as opinion_timestamp, up_votes-down_votes as score FROM `cooked_pies_" . $pie . "discussions` A "
		. "LEFT JOIN public_opinions B "
		. "ON  cpd_id = pie_discussion_id and A.approved=1 and B.approved=1 AND which_pie='$which_pie' "
		. "WHERE for_which_slice='$slice' AND for_or_against='".$for_or_against."' ORDER BY score DESC LIMIT 1000";
	
	//echo $query;
	
	$result = mysql_query($query);
	
	if($for_or_against == 'f') $for_or_against = 'for';
	else if($for_or_against == 'a') $for_or_against = 'against';
	
	//build html
	$data_html = "<a id='close_seemore_box' href='#' onclick='return false'><img src='../images/x_black_small.png' alt='close' style='border:0;cursor:pointer;width:14px;height:14px;position:absolute;top:6px;left:620px;z-index:999' /></a>
					<img src='../images/gradient.png' style='position:absolute;bottom:44px;z-index:99' />
					<span class='arguments_" . $for_or_against . "_title'>Arguments " . $for_or_against . " increasing</span><!--<img src='../images/arrow_up.png' alt='Vote up' title='Vote up' style='padding-left:10px' />-->
					<div id='f<?php echo $slice; ?>_discuss_arguments_" . $for_or_against . "' class='discuss_arguments_box_content' style='border-bottom:0;height:440px;width:600px;overflow-y:auto;overflow-x:hidden;background-color:#fff'>
					";

	//for all arguments
	//we may have more than one per id for each of the public opinions for a particular id, hence loop accordingly
	$i = 1;
	$mysql_pointer = 0;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$data = $row;
		
		if($data['evidence_article'] == "")  { $no_evidence_article = true; $evidence_article = "no evidence article provided"; }
		else { $no_evidence_article = false; $evidence_article = "<a href='{$data['evidence_article']}' target='_blank'>evidence article</a>"; }
		
		if($no_evidence_article) $no_evidence_article_formatting = "style='color:#717171'";
		else { $no_evidence_article_formatting = ""; }
		
		//build html here
		$data_html .= "<!-- begin argument block -->
						<div class='discuss_statement' " . $no_evidence_article_formatting . ">
							<div style='width:93%'>" . $i . ". {$data['statement']}
							<br /><span class='discuss_public_opinion'><i>- {$data['author']} ({$data['city']}, {$data['state']})</i></span>
							</div>
							<a href='#' onclick='return false'><img src='../images/arrow_up.png' alt='Vote up' title='Vote up' class='vote_statement_up_arrow' style='top:-20px;right:10px' id='u{$data['cpd_id']}' /></a><a href='#' onclick='return false'><img src='../images/arrow_down.png' alt='Vote down' title='Vote down' class='vote_statement_down_arrow' style='top:-18px;right:10px' id='d{$data['cpd_id']}' /></a>
						</div>
						<div class='discuss_comment_toolbox' " . $no_evidence_article_formatting . ">" . $evidence_article . " &middot; <a href='#' onclick='return false' id='fsm{$data['cpd_id']}' class='flag_the_mofo'>flag as inappropriate</a> &middot; <a href='#' onclick='return false' id='f{$data['cpd_id']}' class='agree_disagree'>agree/disagree?</a> &middot; <img src='../images/arrow_up.png' alt='up votes' title='p votes' style='width:10px' /> <span id='upvotes_seemore_{$data['cpd_id']}'>{$data['up_votes']}</span> &nbsp;<img src='../images/arrow_down.png' alt='down votes' title='down votes' style='width:10px' /> <span id='downvotes_seemore_{$data['cpd_id']}'>{$data['down_votes']}</span></div>
						<div class='discuss_public_opinion_container' " . $no_evidence_article_formatting . ">Public opinions:
						";
					
		//show public opinion(s)	
		if($data['opinion_author'] == "") {
			$mysql_pointer++;
			$data_html .= "<div class='discuss_public_opinion'><i>none yet</i></div>";
		}
		else {
			$id_of_current_argument = $data['cpd_id'];
			
			//loop through all public opinions
			do {
				$mysql_pointer++;

				if($id_of_current_argument == $data['cpd_id']) {
					$data_html .= "<div class='discuss_public_opinion'><strong>&raquo;</strong> <i>".$data['opinion_author']." (".$data['opinion_city'].", ".$data['opinion_state']."):</i> ".$data['public_opinion']."</div>";
				}
				else {
					//we can't lose this row, we need to show it in outer loop since it's the subsequent argument
					mysql_data_seek($result, $mysql_pointer-1);
					break; //i know, i know, i've made peace with the fact that I'm not knuth
				}
			} while($data = mysql_fetch_array($result, MYSQL_ASSOC));
		}

		$data_html .= "</div>
		";
		
		$i++;
	}
	
	if($mysql_pointer == 0) {
		$data_html .= "<div style='padding-top:150px;width:100%;text-align:center;font-style:italic;font-size:85%'>none yet</div>";
	}
	
	$data_html .= "<br />
			</div>
			<div class='edit' style='margin-top:2px;width:99%;padding-top:10px;padding-bottom:10px;z-index:100;border-top:1px dotted #989998'>
				<!--<a href='#' onclick='return false'>add your own argument</a>-->
				<span style='float:right;padding-top:3px;font-size:75%'>Showing all " . mysql_num_rows($result) . " arguments</span>
			</div>
			";
			
	echo $data_html;
	return $data_html;
}

function submitArgument($post) {
	//defensive, never use the passed in one
	if($post['for_or_against'] == 'f') $f_or_a = 'f';
	else if($post['for_or_against'] == 'a') $f_or_a = 'a';
	else return null;
	
	$pie = $post['pie'];
	if($pie != "federalbudget" && $pie != "talkingpoints") return null;
	if($pie == "federalbudget") $pie = "";
	elseif($pie == "talkingpoints") $pie = "talkingpoints_";
	
	
	$slice = htmlentities(strip_tags(trim($post['slice'])), ENT_QUOTES, 'UTF-8');
	//$f_or_a = htmlentities(strip_tags(trim($post['f_or_a'])), ENT_QUOTES, 'UTF-8');
	$statement = htmlentities(strip_tags(trim($post['statement'])), ENT_QUOTES, 'UTF-8');
	$evidence_article = htmlentities(strip_tags(urldecode(trim($post['evidence_article']))), ENT_QUOTES, 'UTF-8');
	$author = htmlentities(strip_tags(trim($post['author'])), ENT_QUOTES, 'UTF-8');
	$city = htmlentities(strip_tags(trim($post['city'])), ENT_QUOTES, 'UTF-8');
	$state = htmlentities(strip_tags(trim($post['state'])), ENT_QUOTES, 'UTF-8');

	if(strlen($slice) > 255 || strlen($statement) > 255 
			|| strlen($author) > 255 || strlen($city) > 255 || strlen($state) > 128) {
		return null;
	}
	
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "INSERT INTO `cooked_pies_" . $pie . "discussions` (`for_which_slice`, `for_or_against`, `statement`, `evidence_article`, `author`, `city`, `state`, `timestamp`, `approved`) "
			. "VALUES ('$slice', '$f_or_a', '$statement', '$evidence_article', '$author', '$city', '$state', NOW(), 1)";

	//echo $query;
	
	if(mysql_query($query)) {
		echo "1";
		return "1";
	}
	else {
		echo "error is " . mysql_error();
		return "error is " . mysql_error();
	}
}

function submitOpinion($post) {
	if(!is_numeric($post['discussion_item_id'])) return null;
	
	$pie = $post['pie'];
	if($pie != "federalbudget" && $pie != "talkingpoints") return null;
	if($pie == "federalbudget") $pie = "federalbudget";
	elseif($pie == "talkingpoints") $pie = "talkingpoints";
	
	
	$discussion_item_id = htmlentities(strip_tags(trim($post['discussion_item_id'])), ENT_QUOTES, 'UTF-8');
	$public_opinion = htmlentities(strip_tags(trim($post['public_opinion'])), ENT_QUOTES, 'UTF-8');
	$author = htmlentities(strip_tags(trim($post['author'])), ENT_QUOTES, 'UTF-8');
	$city = htmlentities(strip_tags(trim($post['city'])), ENT_QUOTES, 'UTF-8');
	$state = htmlentities(strip_tags(trim($post['state'])), ENT_QUOTES, 'UTF-8');

	if(strlen($public_opinion) > 255 || strlen($author) > 255 
			|| strlen($city) > 255 || strlen($state) > 128) {
		return null;
	}
	
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "INSERT INTO public_opinions (pie_discussion_id, `which_pie`, `author`, `city`, `state`, timestamp, approved, `public_opinion`) "
			. "VALUES ($discussion_item_id, '$pie', '$author', '$city', '$state', NOW(), 1, '$public_opinion')";

	//echo $query;
	
	if(mysql_query($query)) {
		echo "1";
		return "1";
	}
	else {
		echo "error is " . mysql_error();
		return "error is " . mysql_error();
	}
}

function voteUp($id, $pie) {
	if(!isset($id) || empty($id) || !is_numeric($id)) {
		echo "0";
		return "0";
	}
	
	if($pie != "federalbudget" && $pie != "talkingpoints") { echo "0"; return "0"; }
	if($pie == "federalbudget") $pie = "";
	elseif($pie == "talkingpoints") $pie = "talkingpoints_";

	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "UPDATE `cooked_pies_" . $pie . "discussions` set up_votes = up_votes+1 WHERE cpd_id = $id";
	$result = mysql_query($query);
	
	if($result) {
		echo "1";return "1";
	}
	else {
		echo "0";return "0";
	}
}

function voteDown($id, $pie) {
	if(!isset($id) || empty($id) || !is_numeric($id)) {
		echo "0";
		return "0";
	}
	
	if($pie != "federalbudget" && $pie != "talkingpoints") { echo "0"; return "0"; }
	if($pie == "federalbudget") $pie = "";
	elseif($pie == "talkingpoints") $pie = "talkingpoints_";

	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "UPDATE `cooked_pies_" . $pie . "discussions` set down_votes = down_votes+1 WHERE cpd_id = $id";
	$result = mysql_query($query);
	
	if($result) {
		echo "1";return "1";
	}
	else {
		echo "0";return "0";
	}
}

function flagSubmission($id, $pie) {
	if(!isset($id) || empty($id) || !is_numeric($id)) {
		echo "0";
		return "0";
	}
	
	if($pie != "federalbudget" && $pie != "talkingpoints") { echo "0"; return "0"; }
	if($pie == "federalbudget") $pie = "";
	elseif($pie == "talkingpoints") $pie = "talkingpoints_";

	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$query = "UPDATE `cooked_pies_" . $pie . "discussions` set flagged = flagged+1 WHERE cpd_id = $id";
	$result = mysql_query($query);
	
	if($result) {
		echo "1";return "1";
	}
	else {
		echo "0";return "0";
	}
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
		. "FROM `cooked_pies_talkingpoints` "
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

function decodePolitics($politics) {
	switch($politics) {
		case "DS":
			return "Strong Democrat";
		case "DL":
			return "Lean Democrat";
		case "RS":
			return "Strong Republican";
		case "RL":
			return "Lean Republican";
		case "NN":
			return "Neutral";
	}
}

function formatComment($str) {
	if(strlen($str) > 35)
		return substr($str, 0, 35) . "...";
	else
		return $str;
}

function getStats($whichPie) {
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	if($whichPie == "federalbudget") $whichPie = "";
	elseif($whichPie == "talkingpoints") $whichPie = "_talkingpoints";

	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);
	$db_selected = mysql_select_db($config['db_name'],$connection);
	$result_locale = mysql_query("SET NAMES 'utf8'");
	
	$result = mysql_query("select count(id) as n from cooked_pies" . $whichPie);	
	if($result) {
		$row = mysql_fetch_assoc($result);
		$stats['n'] = $row['n'];
	}
	
	$result = mysql_query("SELECT state, COUNT(state) AS mode_state FROM cooked_pies" . $whichPie . " GROUP BY state ORDER BY mode_state DESC LIMIT 1");
	if($result) {
		$row = mysql_fetch_assoc($result);
		$stats['most_state'] = $row['state'];
	}
	
	$result = mysql_query("SELECT gender, COUNT(gender) AS mode_gender FROM cooked_pies" . $whichPie . " GROUP BY gender ORDER BY mode_gender DESC LIMIT 1");
	if($result) {
		$row = mysql_fetch_assoc($result);
		$stats['most_gender'] = $row['gender'];
	}
	
	$result = mysql_query("SELECT count(id) as comments FROM `cooked_pies" . $whichPie . "` where OCTET_LENGTH(comment) > 0");
	if($result) {
		$row = mysql_fetch_assoc($result);
		$stats['comments_n'] = $row['comments'];
	}
	
	return $stats;
}

function getLatestComments($whichPie, $howMany) {
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	if($whichPie == "federalbudget") $whichPie = "";
	elseif($whichPie == "talkingpoints") $whichPie = "_talkingpoints";

	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);
	$db_selected = mysql_select_db($config['db_name'],$connection);
	$result_locale = mysql_query("SET NAMES 'utf8'");
	
	$result = mysql_query("SELECT id, comment FROM `cooked_pies" . $whichPie . "` where OCTET_LENGTH(comment) > 0 order by time DESC LIMIT " . $howMany);
	$comments = array();

	if($result) {
		while($row = mysql_fetch_assoc($result)) {
			$comments[$row['id']] = $row['comment'];
		}
	}
	
	return $comments;
}

function doFilter($filter, $whichPie) {
	require("/var/www/vhosts/participie.com/httpdocs/config.php");
	
	//defensive
	if($whichPie == "federalbudget") $piesTableSuffix = "";
	elseif($whichPie == "talkingpoints") $piesTableSuffix = "_talkingpoints";
	
	
	if($filter == "all") {
		$where = "1=1";
	}
	else if($filter == 1 || $filter == 2 || $filter == 3 || $filter == 4 || $filter == 5 || $filter == 6) {
		$where = "age=" . htmlentities(strip_tags(trim($filter)), ENT_QUOTES, 'UTF-8');
	}
	else if($filter == 'M' || $filter == 'F') {
		$where = "gender='" . htmlentities(strip_tags(trim($filter)), ENT_QUOTES, 'UTF-8') . "'";
	}
	else if($filter == 'NN' || $filter == 'DS' || $filter == 'DL' || $filter == 'RS' || $filter == 'RL') {
		$where = "politics='" . htmlentities(strip_tags(trim($filter)), ENT_QUOTES, 'UTF-8') . "'";
	}

	//construct sql statement with the filter value as the where clause
	$query = "SELECT `id`, `politics`,`state`,`gender`,`zip`, `age`, `pie`, `comment` FROM `cooked_pies". $piesTableSuffix ."` " .
			"WHERE " . $where . " " . 
			"ORDER BY `id` DESC LIMIT 100";

	//echo $query;

	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$result_locale = mysql_query("SET NAMES 'utf8'");
		
	$result = mysql_query($query);
		
	if(!$result) {
		$content .= "Oops, something messed up";
		$content .= 'Oops, mysql messed up: ' . mysql_error() . "\n";
		$content .= 'Whole query: ' . $query;
		echo $content;
	}
	else {
				echo "<h2 style='display:block;text-align:left;font-size:12pt;padding-left:8px'>Show</h2> ";
				//echo "<h2 style='font-size:12pt;display:inline;text-align:center;margin-left:auto;margin-right:auto'>Showing " . mysql_num_rows ($result) . " pies</h2>";
				
				while ($row = mysql_fetch_assoc($result)) {
					$permalink = "http://www.participie.com/wip/" . $whichPie . "/?p=" . $row['id'];
					
					$icon;
					//if($row['politics'] == 'RL' || $row['politics'] == 'RS') $icon = "republican_icon.png";  
					//elseif($row['politics'] == 'DL' || $row['politics'] == 'DS')   $icon = "democrat_icon.png";
					if($row['politics'] == 'RL') $icon = "republican_icon.png"; 
					elseif($row['politics'] == 'RS') $icon = "republican_strong_icon.png";
					elseif($row['politics'] == 'DL')   $icon = "democrat_icon.png";
					elseif($row['politics'] == 'DS') $icon = "democrat_strong_icon.png";
					elseif($row['politics'] == 'NN')   $icon = "neutral_icon.png";
					
					echo "<div class='minipie_container' id='container_" . $row['id'] . "'";
					if($icon != "") echo " style='background-image:url(../images/$icon)'";
					echo ">";
					
					echo "<a href='" . $permalink . "'><img src='../images/link_16.png' style='position:absolute;top:5px;left:216px;z-index:999' title='Permalink' alt='Permalink' /></a>";
					
					echo "<svg class='minipie' id='minipie_" . $row['id'] . "' width='180px' height='180px'></svg>";
					echo "<input type='hidden' id='piedata_" . $row['id'] . "' value='" . $row['pie'] . "' />";
				    echo "<br /><strong>" . decodePolitics($row['politics']) . " voter from " . $row['state'] . "</strong><br />";

				    echo "<i><a href='#' style='text-decoration:none' onclick='return false' onmouseover='showFullComment(\"" . $row['comment'] . "\", \"" . "#container_" . $row['id'] . "\")' onmouseout='hideFullComment()'>" . formatComment($row['comment'])  . "</a></i>";

				    echo "</div>";
				}
	}

}

function getFullStateName($abbreviation) {
	require("states.php");
	return $states[$abbreviation];
}

?>