<?php

class PluginControllerSCR {

    private static function setCookie() {
        if (!isset($_COOKIE[SCR_COOKIE_NAME])):
            setcookie(SCR_COOKIE_NAME, self::getCookieContent(), time() + 3600, COOKIEPATH, COOKIE_DOMAIN);
        endif;
    }

    private static function getCookie() {
        return $_COOKIE[SCR_COOKIE_NAME];
    }

    public static function wpLoaded() {
        self::setCookie();
    }

    public static function wpLogin() {
        if (isset($_COOKIE[SCR_COOKIE_NAME])):
            $oldString = getCookie();
            $newString = "dome";
            self::setCookie();
        endif;
    }

    public static function getCookieContent() {
        return md5($_SERVER["REMOTE_ADDR"] . rand(10000000, 1000000000));
    }

    public static function initializePlugin() {
        load_plugin_textdomain(ConstantsSCR::TEXT_DOMAIN, true, SCR_PLUGIN_RELATIVE_DIR . '/language/');

        add_filter("comment_text", array("CommentsControllerSCR", "filterCommentText"), 9000);
        add_filter('manage_edit-comments_columns', array("CommentsControllerSCR", "addAdminCustomColumn"));

        if (get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_LIKES) == "1" || get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_DISLIKES) == "1") {
            add_filter("comment_class", array("CommentsControllerSCR", "commentCssClass"), 10, 4);
        }

        add_action('wp_enqueue_scripts', array("PluginControllerSCR", "addFrontendStylesAndScripts"));
        add_action('wp_ajax_nopriv_scr_set_comment_like_dislike', array("AjaxControllerSCR", "setCommentsLikeOrDislike"));
        add_action('wp_ajax_scr_set_comment_like_dislike', array("AjaxControllerSCR", "setCommentsLikeOrDislike"));
        add_action('comment_post', array("CommentsControllerSCR", "setComment"), 10, 1);
        add_action("wp_head", array("PluginControllerSCR", "addFrontendHighlightStyle"));
       
    }

    public static function ininitalizeAdmin() {
            add_action("admin_menu", array('PluginControllerSCR', 'addMenu'));
            add_action('manage_comments_custom_column', array("CommentsControllerSCR", "showAdminCustomColumnContent"), 10, 2);
            add_action("admin_init", array("SettingsControllerSCR", "registerSettings"));
            add_action('admin_print_scripts-toplevel_page_scr_settings', array("PluginControllerSCR", "addAdminScripts"));
    }

    public static function addMenu() {
        add_menu_page("Simple Comment Rating", "Comment Rating", 10, "scr_settings", array("ViewControllerSCR", "getSettingsPage"), null, 26);
    }

    public static function initializeWidgets() {
        register_widget("TopRatedCommentsWidgetSCR");
    }

    public static function addAdminScripts() {
        wp_enqueue_style("wp-color-picker");
        wp_enqueue_script("wp-color-picker");
        wp_enqueue_script("scr-admin-script", SCR_PLUGIN_URL . "scripts/settings.js", array("jquery", "wp-color-picker"));
    }

    public static function addFrontendStylesAndScripts() {

        if (get_option(SettingsSCR::SETTING_SIZE) == "normal"):
            wp_register_style("simple-comment-rating", SCR_PLUGIN_URL . "styles/simple-comment-rating.css");
        else:
            wp_register_style("simple-comment-rating", SCR_PLUGIN_URL . "styles/simple-comment-rating-small.css");
        endif;
        wp_register_style("simple-comment-rating-highlight", SCR_PLUGIN_URL . "styles/simple-comment-rating-highlight.css.php");

        wp_register_script("simple-comment-rating-js", SCR_PLUGIN_URL . "scripts/simple-comment-rating.js", array("jquery"));
        wp_localize_script('simple-comment-rating-js', 'scr_ajax', array('ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('scr-ajax-nonce')));
        wp_enqueue_script('jquery');
        wp_enqueue_script('simple-comment-rating-js');
        wp_enqueue_style("simple-comment-rating");
      
    }

    public static function addFrontendHighlightStyle() {
        $colorHighly = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_LIKES);
        $colorPoorly = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_DISLIKES);
        ?>
        <style type="text/css" media="screen">
            .scr-highly-highlight {
                background-color: <?php echo $colorHighly; ?> !important;
            }
            .scr-poorly-highlight {
                background-color: <?php echo $colorPoorly; ?> !important;
            }
        </style>
        <?php
    }

}
?>
