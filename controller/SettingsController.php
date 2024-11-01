<?php

class SettingsControllerSCR {

    public static function registerSettings() {
        
        
        $settings[] = array();
        
        array_push($settings, array("ID"=> SettingsSCR::SETTING_POSITION, "Title"=>"Position", "callback"=>  array("SettingsControllerSCR", "settingsCallback")));
        
        
        add_settings_section(SettingsSCR::SETTING_SECTION_DISPLAY, "Normal Settings", array("SettingsControllerSCR", "settingsCallback"), SettingsSCR::SETTING_PAGE);
        add_settings_section(SettingsSCR::SETTING_SECTION_SECURITY, "Security Settings", array("SettingsControllerSCR", "settingsCallback"), SettingsSCR::SETTING_PAGE);

        add_settings_field(SettingsSCR::SETTING_POSITION, "Position", array("SettingsControllerSCR", "settingCallbackForPosition"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_DISPLAYMODE, "Display Mode", array("SettingsControllerSCR", "setttingCallbackForDisplayMode"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_SIZE, __("Size", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "setttingCallbackForSize"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);

        add_settings_field(SettingsSCR::SETTING_TEXT_LIKE, __("Like text", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingTextLike"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_LIKES, __("Highlight highly-rated comment", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingHighlightCommentLikes"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_LIKES, __("Highly-rated comments have (Likes - Dislikes) >=", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingHighlightCommentCountLikes"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_LIKES, __("Color for highly-rated comments", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingHighlightCommentColorLikes"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);

        add_settings_field(SettingsSCR::SETTING_TEXT_DISLIKE, __("Dislike text", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingTextDislike"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_DISLIKES, __("Highlight poorly-rated comment", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingHighlightCommentDislikes"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_DISLIKES, __("Highly-rated comments have (Likes - Dislikes) >=", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingHighlightCommentCountDislikes"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);
        add_settings_field(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_DISLIKES, __("Color for poorly-rated comments", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingHighlightCommentColorDislikes"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_DISPLAY);

        add_settings_field(SettingsSCR::SETTING_IP_CHECK, __("IP Check", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingIpCheck"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_SECURITY);
        add_settings_field(SettingsSCR::SETTING_AUTHOR_COMMENT_RATING, __("Turn off rating for comments by author", ConstantsSCR::TEXT_DOMAIN), array("SettingsControllerSCR", "settingAuthorCommentRating"), SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SECTION_SECURITY);

        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_HIGHLIGHT_COMMENT_LIKES);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_LIKES);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_HIGHLIGHT_COMMENT_DISLIKES);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_DISLIKES);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_LIKES, array("SettingsControllerSCR", "validateSettingHighlightCommentCountLikes"));
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_DISLIKES, array("SettingsControllerSCR", "validateSettingHighlightCommentCountLikes"));

        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_POSITION);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_DISPLAYMODE);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_SIZE);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_TEXT_LIKE, array("SettingsControllerSCR", "validateSettingTextLike"));
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_TEXT_DISLIKE, array("SettingsControllerSCR", "validateSettingTextDislike"));

        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_IP_CHECK);
        register_setting(SettingsSCR::SETTING_PAGE, SettingsSCR::SETTING_AUTHOR_COMMENT_RATING);
    }

    public static function settingsCallback() {

        echo "";
    }

    public static function settingCallbackForPosition($args) {

        $setting = get_option(SettingsSCR::SETTING_POSITION);

        $checkedAbove = $setting == "above" ? " selected=\"selected\" " : "";
        $selectedBelow = $setting == "below" ? " selected=\"selected\" " : "";

        $html .= '<select name="' . SettingsSCR::SETTING_POSITION . '">';
        $html .= '<option value="below"' . $selectedBelow . '>' . __("Below", ConstantsSCR::TEXT_DOMAIN) . '</option>';
        $html .= '<option value="above"' . $checkedAbove . '>' . __("Above", ConstantsSCR::TEXT_DOMAIN) . '</option>';
        $html .= '</select>';

        echo $html;
    }

    public static function setttingCallbackForDisplayMode() {

        $setting = get_option(SettingsSCR::SETTING_DISPLAYMODE);

        $checkedLikeAndDislike = $setting == "like_and_dislike" ? " selected=\"selected\" " : "";
        $checkedLikeOnly = $setting == "like_only" ? " selected=\"selected\" " : "";

        $html = '<select name="' . SettingsSCR::SETTING_DISPLAYMODE . '">';
        $html .= '<option value="like_and_dislike"' . $checkedLikeAndDislike . '>' . __("Like and dislke", ConstantsSCR::TEXT_DOMAIN) . '</option>';
        $html .= '<option value="like_only"' . $checkedLikeOnly . '>' . __("Like only", ConstantsSCR::TEXT_DOMAIN) . '</option>';
        $html .= '</select>';

        echo $html;
    }

    public static function setttingCallbackForSize() {

        $setting = get_option(SettingsSCR::SETTING_SIZE);

        $selectedNormal = $setting == "normal" ? " selected=\"selected\" " : "";
        $selectedSmall = $setting == "small" ? " selected=\"selected\" " : "";

        $html = '<select name="' . SettingsSCR::SETTING_SIZE . '">';
        $html .= '<option value="normal"' . $selectedNormal . '>' . __("Normal", ConstantsSCR::TEXT_DOMAIN) . '</option>';
        $html .= '<option value="small"' . $selectedSmall . '>' . __("Small", ConstantsSCR::TEXT_DOMAIN) . '</option>';
        $html .= '</select>';

        echo $html;
    }

    public static function settingTextLike() {
        $setting = get_option(SettingsSCR::SETTING_TEXT_LIKE);

        echo '<input type="text" class="regular-text" name="' . SettingsSCR::SETTING_TEXT_LIKE . '" value="' . $setting . '" />';
    }

    public static function settingHighlightCommentLikes() {
        $setting = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_LIKES);
        echo '<input type="checkbox"   id="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_LIKES . '" name="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_LIKES . '" value="1" ' . checked(1, $setting, false) . ' />';
    }

    public static function settingHighlightCommentCountLikes() {
        $setting = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_LIKES);

        echo '<input type="text" class="number" name="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_LIKES . '" value="' . $setting . '" />';
    }

    public static function settingHighlightCommentColorLikes() {
        $setting = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_LIKES);
        echo '<input type="text" id="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_LIKES . '" class="regular-text" name="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_LIKES . '" value="' . $setting . '" />';
    }

    public static function settingTextDislike() {
        $setting = get_option(SettingsSCR::SETTING_TEXT_DISLIKE);

        echo '<input type="text" class="regular-text" name="' . SettingsSCR::SETTING_TEXT_DISLIKE . '" value="' . $setting . '" />';
    }

    public static function settingHighlightCommentDislikes() {
        $setting = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_DISLIKES);
        echo '<input type="checkbox"   id="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_DISLIKES . '" name="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_DISLIKES . '" value="1" ' . checked(1, $setting, false) . ' />';
    }

    public static function settingHighlightCommentCountDislikes() {
        $setting = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_DISLIKES);

        echo '<input type="text" class="number" name="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_DISLIKES . '" value="' . $setting . '" />';
    }

    public static function settingHighlightCommentColorDislikes() {
        $setting = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_DISLIKES);
        echo '<input type="text" id="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_DISLIKES . '" class="regular-text" name="' . SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COLOR_DISLIKES . '" value="' . $setting . '" />';
    }

    public static function settingIpCheck() {
        $setting = get_option(SettingsSCR::SETTING_IP_CHECK);
        echo '<input type="checkbox" id="someid" name="' . SettingsSCR::SETTING_IP_CHECK . '" value="1" ' . checked(1, $setting, false) . ' />';
    }

    public static function settingAuthorCommentRating() {
        $setting = get_option(SettingsSCR::SETTING_AUTHOR_COMMENT_RATING);
        echo '<input type="checkbox" name="' . SettingsSCR::SETTING_AUTHOR_COMMENT_RATING . '" value="1" ' . checked(1, $setting, false) . ' />';
    }

    public static function validateSettingTextLike($input) {

        $valid = filter_var($input, FILTER_SANITIZE_STRING);

        if ($input == ""):
            add_settings_error(SettingsSCR::SETTING_TEXT_LIKE, "my_error", __("Bitte geben Sie einen Text an", ConstantsSCR::TEXT_DOMAIN), "error");
        endif;

        return $valid;
    }

    public static function validateSettingHighlightCommentCountLikes($input) {
        $input = filter_var($input, FILTER_SANITIZE_STRING);
        $valid = filter_var($input, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 1000)));

        if (!$valid) {
            add_settings_error(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_LIKES, "my_error", __("Nummer falsch", ConstantsSCR::TEXT_DOMAIN), "error");
        }

        return $valid;
    }

    public static function validateSettingTextDislike($input) {
        $valid = filter_var($input, FILTER_SANITIZE_STRING);

        if ($input == ""):
            add_settings_error(SettingsSCR::SETTING_TEXT_DISLIKE, "my_error", __("Bitte geben Sie einen Text an", ConstantsSCR::TEXT_DOMAIN), "error");
        endif;

        return $valid;
    }

}
?>


