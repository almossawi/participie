<?php
add_action('init', 'of_options');
if (!function_exists('of_options')) {
    function of_options() {
        // VARIABLES
        $themename = get_theme_data(get_stylesheet_directory() . '/style.css');
        $themename = $themename['Name'];
        $shortname = "of";
        // Populate OptionsFramework option in array for use in theme
        global $of_options;
        $of_options = inkthemes_get_option('of_options');       
        // Multicheck Defaults      
        $back_array = array("image" => "Image", "color" => "Color");
        //Stylesheet Reader
        $alt_stylesheets = array("black" =>"black", "cyan" => "cyan", "green" => "green", "pink" => "pink", "red" => "red", "yellow" => "yellow", "" => "none");
        //Option for on off
        $cols_two = array("on" => "On", "off" => "Off");
        $cols_three = array("on" => "On", "off" => "Off");
        // Test data
        $test_array = array("one" => "One", "two" => "Two", "three" => "Three", "four" => "Four", "five" => "Five");
        // Multicheck Array
        $multicheck_array = array("one" => "OK");
        // Multicheck Defaults
        $multicheck_defaults = array("one" => "1", "five" => "1");
        // Background Defaults
        $background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat', 'position' => 'top center', 'attachment' => 'scroll');
        // Pull all the categories into an array
        $options_categories = array();
        $options_categories_obj = get_categories();
        foreach ($options_categories_obj as $category) {
            $options_categories[$category->cat_ID] = $category->cat_name;
        }
        // Pull all the pages into an array
        $options_pages = array();
        $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
        $options_pages[''] = 'Select a page:';
        foreach ($options_pages_obj as $page) {
            $options_pages[$page->ID] = $page->post_title;
        }
        // If using image radio buttons, define a directory path
        $imagepath = get_stylesheet_directory_uri() . '/images/';
        $options = array();
        $options[] = array("name" => "General Settings",
            "type" => "heading");
        $options[] = array("name" => "Custom Logo",
            "desc" => "Choose your own logo. Optimal Size: 160px Wide by 30px Height",
            "id" => "inkthemes_logo",
            "type" => "upload");
        //Background Image
        $options[] = array("name" => "Body Background Image",
            "desc" => "Choose your own background image,pattern.",
            "id" => "inkthemes_bodybg",
            "type" => "upload");
        $options[] = array("name" => "Custom Favicon",
            "desc" => "Specify a 16px x 16px image that will represent your website's favicon.",
            "id" => "inkthemes_favicon",
            "type" => "upload");
        $options[] = array("name" => "Tracking Code",
            "desc" => "Paste your Google Analytics (or other) tracking code here.",
            "id" => "inkthemes_analytics",
            "std" => "",
            "type" => "textarea");
//------------------------------------------------------------------//
//-----------This code is used for creating slider settings---------//							
//------------------------------------------------------------------//						
        $options[] = array("name" => "Home Top Section",
            "type" => "heading");
        //First slider
        $options[] = array("name" => "Top Section Image",
            "desc" => "Choose Image for your top section. Optimal Size: 950px x 350px",
            "id" => "inkthemes_slideimage1",
            "type" => "upload");
        $options[] = array("name" => "Top Section Caption Heading",
            "desc" => "Enter the Heading for Top Section Caption",
            "id" => "inkthemes_slideheading1",
            "std" => "",
            "type" => "textarea");
        $options[] = array("name" => "Top Section Caption Description",
            "desc" => "Enter description for Top Section Caption",
            "id" => "inkthemes_slidedescription1",
            "std" => "",
            "type" => "textarea");
        $options[] = array("name" => "Top Section Link",
            "desc" => "Enter the Link URL for Top Section",
            "id" => "inkthemes_slidelink1",
            "std" => "",
            "type" => "text");
//------------------------------------------------------------------//
//---------This code is used for creating homepage settings---------//							
//------------------------------------------------------------------//
        $options[] = array("name" => "Home Page Settings",
            "type" => "heading");       
        $options[] = array("name" => "Home Page Heading",
            "desc" => "Enter your heading text for home page",
            "id" => "inkthemes_mainheading",
            "std" => "",
            "type" => "textarea");
        //***Code for homepage main heading description***//
        $options[] = array("name" => "Homepage Heading Description",
            "desc" => "Enter heading descriptions",
            "id" => "inkthemes_heading_desc",
            "std" => "",
            "type" => "textarea");

//------------------------------------------------------------------//
//---------Homepage featured two columns---------//							
//------------------------------------------------------------------//
        $options[] = array("name" => "Home Page 2 Cols",
            "type" => "heading");
        //**Column left heading
        $options[] = array("name" => "Column Left Heading",
            "desc" => "Enter heading for column left",
            "id" => "inkthemes_col_left_heading",
            "std" => "",
            "type" => "textarea"); 
        $options[] = array("name" => "Column Left Image",
            "desc" => "Choose your image for column left",
            "id" => "inkthemes_col_left_image",
            "std" => "",
            "type" => "upload");
        $options[] = array("name" => "Column Left Text",
            "desc" => "Enter text description for column left. You can put html tags, embed code in this area.",
            "id" => "inkthemes_col_left_desc",
            "std" => "",
            "type" => "textarea");
        $options[] = array("name" => "Column Left Redirect Link",
            "desc" => "Enter url for column left redirect link",
            "id" => "inkthemes_col_left_readmore",
            "std" => "",
            "type" => "text");
        //**Column right heading
        $options[] = array("name" => "Column Right Heading",
            "desc" => "Enter heading for column right",
            "id" => "inkthemes_col_right_heading",
            "std" => "",
            "type" => "textarea");   
        $options[] = array("name" => "Column Right Image",
            "desc" => "Choose your image for column right",
            "id" => "inkthemes_col_right_image",
            "std" => "",
            "type" => "upload");
        $options[] = array("name" => "Column Right Text",
            "desc" => "Enter text description for column right. You can put html tags, embed code in this area.",
            "id" => "inkthemes_col_right_desc",
            "std" => "",
            "type" => "textarea");
        $options[] = array("name" => "Column Right Redirect Link",
            "desc" => "Enter url for column right redirect link",
            "id" => "inkthemes_col_right_readmore",
            "std" => "",
            "type" => "text");          
//------------------------------------------------------------------//
//-------------This code is used for creating social logos----------//							
//------------------------------------------------------------------//
        $options[] = array("name" => "Social Icons",
            "type" => "heading");
        $options[] = array("name" => "Facebook URL",
            "desc" => "Enter your Facebook URL if you have one.",
            "id" => "inkthemes_facebook",
            "std" => "",
            "type" => "text");
        $options[] = array("name" => "Stumbleupon URL",
            "desc" => "Enter your stumbleupon URL if you have one.",
            "id" => "inkthemes_upon",
            "std" => "",
            "type" => "text");
        $options[] = array("name" => "Twitter URL",
            "desc" => "Enter your Twitter URL if you have one.",
            "id" => "inkthemes_twitter",
            "std" => "",
            "type" => "text");
        $options[] = array("name" => "RSS Feed URL",
            "desc" => "Enter your RSS Feed URL if you have one.",
            "id" => "inkthemes_rss",
            "std" => "",
            "type" => "text");       
//------------------------------------------------------------------//
//-------------This code is used for creating SEO description-------//							
//------------------------------------------------------------------//
        inkthemes_update_option('of_template', $options);
        inkthemes_update_option('of_themename', $themename);
        inkthemes_update_option('of_shortname', $shortname);
    }
}
?>
