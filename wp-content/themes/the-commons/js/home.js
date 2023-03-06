
(function($) {
	//$(document).ready(function() {
        //bool var to see if we loaded a post automatically yet
        var loadedPost = 0;
        //Mutation observer to watch for dom changes
        var popoutContainer = new MutationObserver(function() {
            if($('#popout-container').hasClass('active-blog') && loadedPost == 0) {
                //load first post by clicking the first item in the sidebar
                $('#popout-container .blog-sidebar .blog-item:first-of-type').trigger('click');
                //set our bool var to true so it doesnt happen again
                loadedPost = 1;
            } else if (!$('#popout-container').hasClass('active-blog') && loadedPost == 1) {
                //reset it so we load the post automatically the next time blog is clicked
                loadedPost = 0;
            }
        });
        //watch popout-container for changes
        popoutContainer.observe($("#popout-container")[0], {
            attributes: true
        });
        //load the blog item into the blog ajax container when clicked
        $('#popout-container').on('click','.blog-sidebar .blog-item',function(e) {
            e.stopPropagation();
            var post_id = $(this).attr('data-id');
            jQuery.ajax({
                url: home_js.ajax_url,
                data: {
                    'action': 'load_commons_blog_post',
                    'post_id': post_id
                }, success: function( data ) {
                    $('#blog-ajax-container').html(data);
                }
            });
        });
	//});
})(jQuery); // Fully reference jQuery after this point.