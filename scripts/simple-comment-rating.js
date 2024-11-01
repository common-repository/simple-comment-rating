jQuery(document).ready(function() {

    var scrDisabledButton = function(button) {                       
        jQuery(button).removeClass("scr-is-href");        
        var classes = jQuery(button).attr("class");
        var text = jQuery(button).html();
        var id = jQuery(button).attr("id");
 
        jQuery(button).replaceWith('<span id="' + id + '" class="' + classes +'">' + text +'</span>');
    }

    jQuery('.scr-button').click(function() {
        
        var jQueryId = jQuery(this).attr("id");
        var commentId = jQueryId.substring(jQueryId.lastIndexOf("-")+1);       
        var isLike = jQuery(this).hasClass("scr-like") == true ? true : false;

        
        var self = this;
       
        var dataShareCount = {
            action: "scr_set_comment_like_dislike",
            commentId: commentId,
            isLike: isLike,
            nonce: scr_ajax.nonce
        };
       
       jQuery(self).addClass("scr-loading");
       
        jQuery.post(scr_ajax.ajaxurl, dataShareCount, function(response) {       
            var jsonData = jQuery.parseJSON(response);         
            jQuery(self).removeClass("scr-loading");
            
            var likeButton = jQuery("#scr-button-like-" + commentId);
            var dislikeButton = jQuery("#scr-button-dislike-" + commentId);
            
            
            if(jsonData.success) {
                
                scrDisabledButton(likeButton);                
                scrDisabledButton(dislikeButton);
                
                jQuery("#scr-like-count-" + commentId).html(jsonData.likes);                    
                jQuery("#scr-dislike-count-" + commentId).html(jsonData.dislikes);
         
                jQuery(likeButton).addClass("scr-dislike-disabled");                
                jQuery(dislikeButton).addClass("scr-like-disabled");                

                

            } else {
                alert("Simple Comment Rating: Something went wrong");
            }
        });
    });
});