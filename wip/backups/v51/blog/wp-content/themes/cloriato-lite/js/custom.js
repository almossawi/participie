/*--------DDsmoothmenu Initialization--------*/
jQuery(document).ready(function() { 
ddsmoothmenu.init({
	mainmenuid: "menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
});
//Font replace
Cufon.replace('h1')('h2')('h3')('h4')('h5')('h6');
});
//Fade images
 jQuery(document).ready(function(){
    jQuery(".feature_inner img,.sidebar .recent_post li img").hover(function() {
      jQuery(this).stop().animate({opacity: "0.5"}, '500');
    },
    function() {
      jQuery(this).stop().animate({opacity: "1"}, '500');
    });
  });