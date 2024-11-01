<?php

class CommentsControllerSCR {

    public static function getLikes($commentId) {
        $currentLikeCount = get_comment_meta($commentId, ConstantsSCR::COMMENT_META_KEY_LIKES);
        return (empty($currentLikeCount)) ? 0 : $currentLikeCount[0];
    }

    public static function getDislikes($commentId) {
        $currentDislikeCount = get_comment_meta($commentId, ConstantsSCR::COMMENT_META_KEY_DISLIKES);
        return (empty($currentDislikeCount)) ? 0 : $currentDislikeCount[0];
    }
    
    public static function commentCssClass($classes, $class, $commentId, $postId) {
        $likes = get_comment_meta($commentId, ConstantsSCR::COMMENT_META_KEY_LIKES);
        $dislikes = get_comment_meta($commentId, ConstantsSCR::COMMENT_META_KEY_DISLIKES);        
        $settingCountLikes = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_LIKES);        
        $settingCountDislikes = get_option(SettingsSCR::SETTING_HIGHLIGHT_COMMENT_COUNT_DISLIKES);
                
        if($likes > $dislikes && $likes > $settingCountLikes):
            $classes[] = "scr-highly-highlight";        
        elseif($likes < $dislikes && $dislikes > $settingCountDislikes):
            $classes[] = "scr-poorly-highlight";                    
        endif;

        return $classes;
    }  
    

    public static function filterCommentText($text) {

        if (!is_admin()):
            global $comment;

            $commentId = $comment->comment_ID;
            $isRatingAllowed = self::isRatingAllowed($commentId);
            $likes = self::getLikes($commentId);  
            $disLikes = self::getDislikes($commentId);

            //read settings
            $settingPosition = get_option(SettingsSCR::SETTING_POSITION);
            $settingTextLike = get_option(SettingsSCR::SETTING_TEXT_LIKE) == false ? __("Like", ConstantsSCR::TEXT_DOMAIN) : get_option(SettingsSCR::SETTING_TEXT_LIKE);
            $settingTextDislike = get_option(SettingsSCR::SETTING_TEXT_DISLIKE) == false ? __("Like", ConstantsSCR::TEXT_DOMAIN) : get_option(SettingsSCR::SETTING_TEXT_DISLIKE);
            $settingDisplayMode = get_option(SettingsSCR::SETTING_DISPLAYMODE);

            $output .= "<div class=\"simple-comment-rating\">";
            if (!$isRatingAllowed):
                $output .= '<span id="scr-button-like-' . $commentId . '" class="scr-button-disabled scr-like"><span id="scr-like-count-' . $commentId . '">1</span>&nbsp;' . $settingTextLike . '</span>';
                if ($settingDisplayMode == "like_and_dislike"):
                    $output .= '<span id="scr-button-dislike-' . $commentId . '" class="scr-button-disabled scr-dislike"><span id="scr-dislike-count-' . $commentId . '">0</span>' . $settingTextDislike . '</span>';
                endif;
            else:
                $output .= '<a id="scr-button-like-' . $commentId . '" class="scr-button scr-like scr-is-href"><span id="scr-like-count-' . $commentId . '">' . $likes . '&nbsp;</span>' . $settingTextLike . '</a>';
                if ($settingDisplayMode == "like_and_dislike"):
                    $output .= '<a id="scr-button-dislike-' . $commentId . '" class="scr-button scr-dislike scr-is-href"><span id="scr-dislike-count-' . $commentId . '">' . $disLikes . '&nbsp;</span>' . $settingTextDislike . '</a>';
                endif;
            endif;

            $output .= "<div style=\"clear: both;\"></div></div>";

            if ($settingPosition == "above"):
                $output = $output . $text;
            else:
                $output = $text . $output;
            endif;

            return $output;
        endif;
    }

    public static function setComment($commentId) {
        add_comment_meta($commentId, ConstantsSCR::COMMENT_META_AUTHOR_HASH, self::getCurrentUserMD5Hash(), false);
    }

    public static function setCommentLikeOrDislike($commentId, $isLike) {
        $isRatingAllowed = self::isRatingAllowed($commentId);

        if ($isRatingAllowed == true):
            $metaKeyName = ($isLike == true) ? ConstantsSCR::COMMENT_META_KEY_LIKES : ConstantsSCR::COMMENT_META_KEY_DISLIKES;
            $currentCommentMeta = get_comment_meta($commentId, $metaKeyName, true);
            $newCommentMeta = empty($currentCommentMeta) ? 1 : intval($currentCommentMeta) + 1;
            update_comment_meta($commentId, $metaKeyName, $newCommentMeta);
            add_comment_meta($commentId, ConstantsSCR::COMMENT_META_VOTER_HASH, self::getCurrentUserMD5Hash());
            return true;
        else:
            return false;
        endif;
    }

    private static function getCurrentUserMD5Hash() {
        $cookieName = SCR_COOKIE_NAME;

        if (isset($_COOKIE[$cookieName])):
            $md5 = $_COOKIE[$cookieName];
        else:
            $md5 = PluginControllerSCR::getCookieContent();
        endif;

        return $md5;
    }

    private static function isCurrentUserAuthorOfComment($commentId) {
        $currentMD5 = self::getCurrentUserMD5Hash();
        $commentMD5 = get_comment_meta($commentId, ConstantsSCR::COMMENT_META_AUTHOR_HASH, true);
        return ($currentMD5 == $commentMD5);
    }

    private static function hasCurrentUserAlreadyVoted($commentId) {

        $currentMD5 = self::getCurrentUserMD5Hash();
        $commentRateMD5s = get_comment_meta($commentId, ConstantsSCR::COMMENT_META_VOTER_HASH);

        if ($commentRateMD5s === false):
            return false;
        endif;

        $md5Found = array_search($currentMD5, $commentRateMD5s);

        if ($md5Found === false):
            return false;
        endif;

        return true;
    }

    private static function isRatingAllowed($commentId) {

        $isCurrentUserAuthorOfComment = self::isCurrentUserAuthorOfComment($commentId);
        $hasCurrentUserAlreadyVoted = self::hasCurrentUserAlreadyVoted($commentId);

        if ($isCurrentUserAuthorOfComment):
            return false;
        elseif ($hasCurrentUserAlreadyVoted):
            return false;
        endif;

        return true;
    }

    private static function NajaFunction($someValue) {

        $text = "So toll ist der Editor nun auch wieder nicht, aber er sieht ganz schick aus, Fullscreen ist auch was tolles";
    }

    public static function addAdminCustomColumn($defaults) {

        $newDefaults = array();
        while ($default = current($defaults)):
            $key = key($defaults);
            $newDefaults[$key] = $default;
            if ($key == "response"):
                $newDefaults["simple_comment_rating"] = "Simple Comment Rating";
            endif;
            next($defaults);
        endwhile;

        return $newDefaults;
    }

    public static function showAdminCustomColumnContent($columnName, $commentId) {

        if ($columnName == "simple_comment_rating"):
            echo "Likes: " . self::getLikes($commentId) . "<br />Dislikes:" . self::getDislikes($commentId);
        endif;
    }

}

?>
