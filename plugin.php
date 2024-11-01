<?php

/*
  Plugin Name: Simple Comment Rating
  Plugin URI: http://www.eracer.de/simplecommentrating
  Description: ALPHA VERSION - DON'T USE IT!
  Author: Stefan Helmer
  Version: 0.1 Alpha
  Author URI: http://www.eracer.de
 */

define("SCR_PLUGIN_DIR", plugin_dir_path(__FILE__));
define("SCR_PLUGIN_URL", plugin_dir_url(__FILE__));
define("SCR_PLUGIN_RELATIVE_DIR", dirname(plugin_basename(__FILE__)));
define("SCR_COOKIE_NAME", "wp_simple_comment_rating" . COOKIEHASH);     

//classes
include(SCR_PLUGIN_DIR . "/classes/Constants.php");

//controller
include(SCR_PLUGIN_DIR . "/controller/PluginController.php");
include(SCR_PLUGIN_DIR . "/controller/SettingsController.php");
include(SCR_PLUGIN_DIR . "/controller/CommentsController.php");
include(SCR_PLUGIN_DIR . "/controller/AjaxController.php");
include(SCR_PLUGIN_DIR . "/controller/DatabaseController.php");
include(SCR_PLUGIN_DIR . "/controller/ViewController.php");

//wigets
include(SCR_PLUGIN_DIR . "/widgets/TopRatedCommentsWidget.php");

//add_action('plugins_loaded', array("PluginControllerSCR", "wpLoaded"));
//add_action('init', array("PluginControllerSCR", "initializePlugin"));
//add_action('widgets_init', array('PluginControllerSCR', 'initializeWidgets'));
if (is_admin()) {
    //add_action('init', array("PluginControllerSCR", "ininitalizeAdmin"));
}
?>