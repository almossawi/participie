
var arr_data_files = [
	"data-abstracted"
];


/**
 * Display division name instead of person's name (just for use in demo, probably)
 * Returns array with division name is first param and short form (for referencing data file) as
 * second param
 **/
function checkIfLeadParent(node_name) {
	//console.log(node_name);
	switch(node_name) {
		case "10011120":
			return new Array("Design", "D");
			break;
		case "10014068":
			return new Array("Chief Technical Officer", "CTO");
			break;
		case "10020591":
			return new Array("Location and Commerce", "LC");
			break;
		case "10005730":
			return new Array("Markets", "M");
			break;
		case "10013409":
			return new Array("Mobile Phones", "MP");
			break;
		case "10012974":
			return new Array("Smart Devices", "SD");
			break;
		case "10002060":
			return new Array("Human Resources", "HR");
			break;
		case "10005046":
			return new Array("Corporate Development", "CD");
			break;
		case "10003440":
			return new Array("Chief Financial Officer", "CFO");
			break;
		case "10005218":
			return new Array("Chief and Legal Officer", "CLO");
			break;
		case "10031210":
			return new Array("Corporate Relations and Responsibility", "CRR");
			break;
		case "10043254":
			return new Array("Creative Services", "CS");
			break;
		case "10010241":
			return new Array("Media Relations", "MR");
			break;
		default:
			return new Array("", "");
	}
}


/**
 * Display division name instead of person's name (just for use in demo, probably)
 * Returns array with division name is first param and short form (for referencing data file) as
 * second param
 **/
function getDivisionName(node_name) {
	//console.log(node_name);
	
	switch(node_name) {
		case "10011120":
			return new Array("Design", "D");
			break;
		case "10014068":
			return new Array("Chief Technical Officer", "CTO");
			break;
		case "10020591":
			return new Array("Location and Commerce", "LC");
			break;
		case "10005730":
			return new Array("Markets", "M");
			break;
		case "10013409":
			return new Array("Mobile Phones", "MP");
			break;
		case "10012974":
			return new Array("Smart Devices", "SD");
			break;
		case "10002060":
			return new Array("Human Resources", "HR");
			break;
		case "10005046":
			return new Array("Corporate Development", "CD");
			break;
		case "10003440":
			return new Array("Chief Financial Officer", "CFO");
			break;
		case "10005218":
			return new Array("Chief and Legal Officer", "CLO");
			break;
		case "10031210":
			return new Array("Corporate Relations and Responsibility", "CRR");
			break;
		case "10043254":
			return new Array("Creative Services", "CS");
			break;
		case "10010241":
			return new Array("Media Relations", "MR");
			break;
		case "10041796":
			return new Array("CEO", "CEO");
			break;
		default:
			return new Array(the_division_im_inside_the_bloody_intestines_of, division_name_short_form);
			//return new Array("","");
	}
}


/**
 * Simulates a click on the VP's element
 * Open VP's data file, find his/her block, copy all lines before it to a new file and replace 
 * all occurrences of 'name'.  Put the value for the number of replacements here
 */
function getNodeForVP(node_name) {
	//TODO replace with lookup table (put in text file)
	switch(node_name) {
		case "MP":
			return 15;
			break;
		case "D":
			return 201;
			break;
		case "CTO":
			return 212;
			break;
		case "LC":
			return 188;
			break;
		case "SD":
			return 1;
			break;
		case "M":
			return 64;
			break;
		case "HR":
			return 217;
			break;
		case "CFO":
			return 230;
			break;
		case "CD":
			return 251;
			break;
		case "CLO":
			return 258;
			break;
		case "MR":
			return 270;
			break;
		case "CRR":
			return 275;
			break;
		case "CS":
			return 279;
			break;
		case "MP~10002030":
			return 16;
			break;
		case "MP~10005840":
			return 276;
			break;
		case "MP~10012158":
			return 327;
			break;
		case "MP~10017057":
			return 606;
			break;
		case "MP~10031788":
			return 837;
			break;
		case "M~10002999":
			return 65;
			break;
		case "M~10006193":
			return 163;
			break;
		case "M~10044451":
			return 99;
			break;
		case "M~10005344":
			return 108;
			break;
		case "M~10008696":
			return 164;
			break;
		case "M~10011041":
			return 177;
			break;
		case "M~10004094":
			return 134;
			break;
		case "M~10011429":
			return 198;
			break;
		case "M~10023563":
			return 126;
			break;
		case "M~10005117":
			return 118;
			break;
		case "M~10001999":
			return 109;
			break;
		case "M~10006781":
			return 234;
			break;
		case "M~10030813":
			return 214;
			break;
		case "M~10017828":
			return 207;
			break;
		case "M~10015852":
			return 200;
			break;
		case "M~10006345":
			return 192;
			break;
		case "M~10002103":
			return 186;
			break;
		case "M~10001145":
			return 178;
			break;
		case "M~10007267":
			return 249;
			break;
		case "M~10002918":
			return 241;
			break;
		case "M~10002779":
			return 234;
			break;
		case "M~10004094":
			return 133;
			break;
		case "M~10019974":
			return 156;
			break;
		case "M~10001555":
			return 136;
			break;
		case "M~10004458":
			return 156;
			break;
		case "M~10042460":
			return 270;
			break;
		case "M~10005497":
			return 278;
			break;
		case "M~10016421":
			return 291;
			break;
		case "M~10016567":
			return 256;
			break;
		case "M~10020077":
			return 283;
			break;
		case "M~10045480":
			return 287;
			break;
		case "M~10047321":
			return 274;
			break;
		case "M~10030066":
			return 176;
			break;
		case "M~10008374":
			return 174;
			break;
		case "M~10002887":
			return 139;
			break;
		case "M~10002915":
			return 145;
			break;
		case "M~10032317":
			return 154;
			break;
		case "M~10002086":
			return 158;
			break;
		case "M~10002043":
			return 164;
			break;
		case "M~10025205":
			return 169;
			break;
		case "M~10010398":
			return 174;
			break;
		case "M~10022414":
			return 179;
			break;
		default:
			return 0;
	}
}