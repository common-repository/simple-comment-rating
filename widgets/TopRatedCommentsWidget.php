<?php
class TopRatedCommentsWidgetSCR extends WP_Widget {

    public function __construct() {
        parent::__construct("scr_top_rated_comments_widget", "Top Rated Comments", array("description" => "Top Rated Comments Widget Description"));
    }

    function widget($args, $instance) {

        extract($args);
        $title = $instance["title"];

        echo $before_widget;
        if (!empty($title)):
            echo $before_title . $title . $after_title;
        endif;
        echo $after_widget;
    }

}

?>
