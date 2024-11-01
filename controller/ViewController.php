<?php

class ViewControllerSCR {

    //put your code here

    private static function getAdminHeader() {
        if (isset($_GET['noheader'])):
            require_once(ABSPATH . 'wp-admin/admin-header.php');
        endif;
    }
    
    public static function getSettingsPage() {
          include(SCR_PLUGIN_DIR . '/views/admin/settings.php');

    }    
}

?>
