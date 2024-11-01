jQuery(document).ready(function() {
    jQuery("#scr_highlight_comment_color_likes").wpColorPicker();
    jQuery("#scr_highlight_comment_color_dislikes").wpColorPicker();

    jQuery("#scr_highlight_comment").bind("click", function() {
        showOrHideCommentColorLikeOptions();
    });

    var showOrHideCommentColorLikeOptions = function() {
        var checked = jQuery("#scr_highlight_comment").prop("checked");

        if (!checked) {
            jQuery("#scr_highlight_comment_color").parent().parent().parent().parent().hide();
        } else {
            jQuery("#scr_highlight_comment_color").parent().parent().parent().parent().show();
        }
    }

    showOrHideCommentColorLikeOptions();
    //showOrHideCommentColorDisLikeOptions();

});

