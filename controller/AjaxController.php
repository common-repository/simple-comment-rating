<?php

class AjaxControllerSCR {

    public static function setCommentsLikeOrDislike() {
        $commentId = $_POST["commentId"];
        $isLike = $_POST["isLike"] == "true" ? true : false; 
        $result = CommentsControllerSCR::setCommentLikeOrDislike($commentId, $isLike);

        if ($result):
            $currentLikeCount = CommentsControllerSCR::getLikes($commentId);
            $currentDislikeCount = CommentsControllerSCR::getDislikes($commentId);
            $json_data = array("success" => true, "commentId" => $commentId, "likes" => $currentLikeCount, "dislikes" => $currentDislikeCount);
        else:
            $json_data = array("success" => false, "commentId" => $commentId);
        endif;
        
        echo json_encode($json_data);
        die;
    }

}

?>
