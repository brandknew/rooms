<?php
/**
 * Plugin Name: Taboola
 * Plugin URI: http://taboola.com
 * Description: Taboola
 * Version: 1.0.7
 * Author: Taboola
 */

define ("XPATH_MARKER","/");
define ("JS_INDICATOR","{JS}");
define ("JS_MARKER","{");
define ("TABOOLA_CONTENT_FORMAT_STRING",'string');
define ("TABOOLA_CONTENT_FORMAT_SCRIPT",'script');
define ("TABOOLA_CONTENT_FORMAT_HTML",'html');


include_once('widget.php');

if (!class_exists('TaboolaWP')) {
    class TaboolaWP
    {
        //save internal data
        public $data = array();
        public $_is_widget_on_page;
        public $_is_head_script_loaded = false;

        function TaboolaWP()
        {
            global $wpdb;

            //initialize plugin constant
            DEFINE('TaboolaWP', true);

            $this->_is_widget_on_page = false;
            $this->_is_head_script_loaded = false;

            $this->plugin_name = plugin_basename(__FILE__);
            $this->plugin_directory = plugin_dir_path(__FILE__);
            $this->plugin_url = trailingslashit(WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
            $this->settings = $wpdb->get_row("select * from ".$wpdb->prefix."_taboola_settings limit 1");

            $this->tbl_taboola_settings = $wpdb->prefix . '_taboola_settings';

            //activation function
            register_activation_hook($this->plugin_name, array(&$this, 'activate'));

            // Enable sidebar widgets
            if($this->settings != NULL && !empty($this->settings->publisher_id)){
                //register Taboola widget
                add_action('widgets_init',
                    create_function('', 'return register_widget("WP_Widget_Taboola");')
                );
            }

            if (is_admin()) {
                //add menu for plugin
                add_action( 'admin_menu', array(&$this, 'admin_generate_menu') );
                add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
            } else {
                if($this->settings != NULL){
                    add_action('wp_head', array(&$this, 'taboola_header_loader_inject'));
                    add_action('wp_footer', array(&$this, 'taboola_footer_loader_js'));
                    add_filter('the_content', array(&$this, 'load_taboola_content'));
                }
            }
        }




        function plugin_action_links($links, $file) {
            static $this_plugin;

            if (!$this_plugin) {
                $this_plugin = plugin_basename(__FILE__);
            }

            if ($file == $this_plugin) {
                $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=taboola_widget">Settings</a>';
                array_unshift($links, $settings_link);
            }

            return $links;
        }

        private function should_show_content_widget(){
            $retVal = ((trim($this->settings->publisher_id) != '') && is_single() && $this->settings->first_bc_enabled && trim($this->settings->first_bc_widget_id) != '');
            return $retVal;
        }

        private function should_show_sidebar_widget(){
            $retVal = ((trim($this->settings->publisher_id) != '') && is_active_widget( false, false, TABOOLA_WIDGET_BASE_ID, true ));
            return $retVal;
        }

        // Determine if a taboola widget should be added somewhere on the current page (content or sidebar)
        function is_widget_on_page(){
            return  $this->should_show_content_widget() || $this->should_show_sidebar_widget();
        }

        function get_page_type(){

            $page_type='article';
            if (is_front_page()){
            $page_type='home';
            }else if (is_category() || is_archive() || is_search()){
                $page_type='category';
            }
            return $page_type;
        }

        // return the head loader script
        function taboola_header_loader_js() {
            $head_string = "";

            // Only adding Script1 if a widget is going to be placed on the page.
            if ($this->is_widget_on_page()){

                $script1_content = str_replace('{{PUBLISHER_ID}}', $this->settings->publisher_id, file_get_contents($this->plugin_directory.'js/script1.js'));
                $script1_content = str_replace('{{PAGE_TYPE}}',$this->get_page_type(),$script1_content);

                $head_string = '<script type="text/javascript">'.$script1_content.'</script>';
            }

            return $head_string;
        }


        // This function is used for the hook action, injects the header content to the <head> tag.
        function taboola_header_loader_inject(){

            echo $this->taboola_header_loader_js();
        }


        function taboola_footer_loader_js() {

            // Only adding Script1 if a widget is going to be placed on the page.
            if ( $this->is_widget_on_page() ){
                $script3_content = file_get_contents($this->plugin_directory.'js/script3.js');
                echo '<script type="text/javascript">'.$script3_content.'</script>';
            }
        }

        function load_taboola_content($content)
        {
            $taboola_content = array();
            if ($this->should_show_content_widget()){

                $script2_content = str_replace('{{WIDGET_ID}}', $this->settings->first_bc_widget_id, file_get_contents($this->plugin_directory.'js/script2.js'));
                $script2_content = str_replace('{{CONTAINER}}', 'taboola-below-article', $script2_content);
                $script2_content = str_replace('{{PLACEMENT}}', 'below-article', $script2_content);

                $taboola_content[TABOOLA_CONTENT_FORMAT_HTML][] = '<div id="taboola-below-article"></div>';
                $taboola_content[TABOOLA_CONTENT_FORMAT_SCRIPT][] = $script2_content;

                // Adding the 2nd widget if needed
                if($this->settings->second_bc_enabled && trim($this->settings->second_bc_widget_id) != ''){
                    $script2_content = str_replace('{{WIDGET_ID}}', $this->settings->second_bc_widget_id, file_get_contents($this->plugin_directory.'js/script2.js'));
                    $script2_content = str_replace('{{CONTAINER}}', 'taboola-below-article-second', $script2_content);
                    $script2_content = str_replace('{{PLACEMENT}}', 'below-article-2nd', $script2_content);

                    $taboola_content[TABOOLA_CONTENT_FORMAT_HTML][] = '<div id="taboola-below-article-second"></div>';
                    $taboola_content[TABOOLA_CONTENT_FORMAT_SCRIPT][] = $script2_content;
                }

                $content = $this->embed_taboola_content_location($content,$taboola_content,trim($this->settings->location_string));
            }

            return $content;
        }


        // Extract the taboola content in the required format:
        // String - for injecting on the servr side
        // Script or HTML - for injecting on the client side
        function format_taboola_content($taboola_content,$format){
            $ret_val = null;

            switch($format){
                case TABOOLA_CONTENT_FORMAT_STRING:
                    $result_string = join("",$taboola_content[TABOOLA_CONTENT_FORMAT_HTML]).
                        "<script type='text/javascript'>".join("\n",$taboola_content[TABOOLA_CONTENT_FORMAT_SCRIPT])."</script>";
                    $ret_val = $result_string;
                    break;

                // script or html
                default:
                    $ret_val = str_replace("\n","",join("",$taboola_content[$format]));
                    break;
            }

            return $ret_val;
        }


        // Do the actual logic of choosing where to place the taboola content based on the "location" attribute
        function embed_taboola_content_location($content, $taboola_content, $location){
            $do_default = true;

            if (isset($location) && $location != ''){
                $first_char = substr($location,0,1);

                // DIV/XPATH provided for JS handling
                if ($first_char == JS_MARKER){
                    $full_indicator = substr($location,0,strlen(JS_INDICATOR));

                    if ($full_indicator == JS_INDICATOR){

                        $xpath = substr($location,strlen(JS_INDICATOR));
                        $js_inject_script = file_get_contents($this->plugin_directory.'js/js_inject.min.js');
                        $js_inject_script = str_replace("{{XPATH}}",$xpath,$js_inject_script);
                        $js_inject_script = str_replace("{{HTML}}",$this->format_taboola_content($taboola_content,TABOOLA_CONTENT_FORMAT_HTML),$js_inject_script);
                        $js_inject_script = str_replace("{{SCRIPT}}",$this->format_taboola_content($taboola_content,TABOOLA_CONTENT_FORMAT_SCRIPT),$js_inject_script);

                        $content = $content."<span id='tbdefault'></span><script type='text/javascript'>".$js_inject_script."</script>";
                        $do_default = false;
                    }

                // server side selector provided (see simple_html_dom selectors http://simplehtmldom.sourceforge.net/manual.htm)
                // basically it's CSS selectors like in jQuery
                } else{

                    require_once('simple_html_dom.php');

                    $html_doc = str_get_html($content);
                    $target_location = $html_doc->find($location,0);

                    // if the location was found within the html content
                    if (isset($target_location) && is_object($target_location)){

                        // adding taboola content AFTER the target location
                        $target_location->outertext = $target_location->outertext.$this->format_taboola_content($taboola_content,TABOOLA_CONTENT_FORMAT_STRING);
                        $content = $html_doc;
                        $do_default = false;
                    }
                }
            }

            // Default - add to the end of the content
            if ($do_default){
                $content = $content.$this->format_taboola_content($taboola_content,TABOOLA_CONTENT_FORMAT_STRING);
            }

            return $content;
        }


        function admin_generate_menu(){
            global $current_user;
            add_menu_page('Taboola', 'Taboola', 'manage_options', 'taboola_widget', array(&$this, 'admin_taboola_settings'), $this->plugin_url.'img/taboola_icon.png', 110);
        }

        function admin_taboola_settings(){
            global $wpdb;
            $settings = $wpdb->get_row("select * from ".$wpdb->prefix."_taboola_settings limit 1");
            $taboola_errors = array();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                if(trim($_POST['publisher_id']) == ''){
                    $taboola_errors[] = "Please add a 'Publisher ID' in order to apply changes to your widgets";
                }
                if(($_POST['first_bc_enabled'] == 'on' && trim($_POST['first_bc_widget_id']) == '') ||
                    ($_POST['second_bc_enabled'] == 'on' && trim($_POST['second_bc_widget_id']) == '')
                ){
                    $taboola_errors[] = "Please add a 'Widget ID' in order to apply changes to your widgets";
                }
                if (trim($_POST['location_string']) != '' && !$this->is_location_string_valid($_POST['location_string'])){
                    $taboola_errors[] = "Location string not valid, please contact your Taboola account manager to get a valid location string";
                }
                if(count($taboola_errors) == 0){

                    $data = array(
                        "publisher_id" => trim($_POST['publisher_id']),
                        "first_bc_enabled" => $_POST['first_bc_enabled'] == 'on' ? true : false,
                        "first_bc_widget_id" => trim($_POST['first_bc_widget_id']),
                        "second_bc_enabled" => $_POST['second_bc_enabled'] == 'on' ? true : false,
                        "second_bc_widget_id" => trim($_POST['second_bc_widget_id']),
                        "location_string" => trim($_POST['location_string'])
                    );

                    //var_dump($settings);
                    if($settings == NULL){
                        $wpdb->insert($this->tbl_taboola_settings, $data, null, null);
                    } else {
                        $wpdb->update($this->tbl_taboola_settings, $data, array('id' => $settings->id));
                    }
                }
                $settings = $wpdb->get_row("select * from ".$wpdb->prefix."_taboola_settings limit 1");
            }


            include_once('settings.php');
        }

        function is_location_string_valid($location_string){
            // TODO:: validate the location string
            return true;
        }
        function activate(){
            global $wpdb;

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $settings_table = $this->tbl_taboola_settings;

            //check mysql version
            if (function_exists('mysql_get_server_info') && version_compare(mysql_get_server_info(), '4.1.0', '>=')) {
                if (!empty($wpdb->charset))
                    $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
                if (!empty($wpdb->collate))
                    $charset_collate .= " COLLATE $wpdb->collate";
            }

            //settings table structure
            $sql_table_settings = "
                CREATE TABLE `" . $wpdb->prefix . "_taboola_settings` (
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `publisher_id` VARCHAR(255) DEFAULT NULL,
                    `first_bc_enabled` TINYINT(1) NOT NULL DEFAULT FALSE,
                    `first_bc_widget_id` VARCHAR(255) DEFAULT NULL,
                    `first_bc_custom_css` TEXT DEFAULT NULL,
                    `second_bc_enabled` TINYINT(1) NOT NULL DEFAULT FALSE,
                    `second_bc_widget_id` VARCHAR(255) DEFAULT NULL,
                    `second_bc_custom_css` TEXT DEFAULT NULL,
                    `location_string` TEXT DEFAULT NULL,
                    PRIMARY KEY (`id`)
                )" . $charset_collate . ";";

                // creat/update the table
                dbDelta($sql_table_settings);
        }
    }
}

global $taboolaWP;
$taboolaWP = new TaboolaWP();

//
