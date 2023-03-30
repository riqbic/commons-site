(function($) {
	$(document).ready(function() {
        //More posts toggle for blog sidebar
        $('#popout-container').on('click','.more-posts-toggle',function() {
            var $this = $(this);
            //Toggle the toggle itself to be active or not
            $this.toggleClass('is-active');
            // Toggle the text in the toggle
            // The toggle text should match what is in the <span class="toggle-text"></span> on front-page.php
            var text = $this.find('.toggle-text').text();
            $this.find('.toggle-text').text(text == "Show More Posts" ? "Collapse Posts" : "Show More Posts");
            //Toggle the sidebar to expand or contract
            $(this).parent().find('.blog-sidebar').toggleClass('is-active');
            if(text == "Show More Posts"){
                var active_blog = document.getElementsByClassName("blog-item is-active")[0];
                window.scrollTo(0,active_blog.offsetTop);
            }
            else{
                var active_blog = document.getElementsByClassName("blog-item is-active")[0];
                window.scrollTo(0, 0);
            }   
        });
        //Reset toggle when close button is clicked
        $('#popout-container').on('click','#close-icon,.blog-item',function() {
            $('.more-posts-toggle,.blog-sidebar').removeClass('is-active');
            $('.more-posts-toggle').find('.toggle-text').text('Show More Posts');
        });
        

        //bool var to see if we loaded a post automatically yet
        var loadedPost = 0;
        //automatically load a post on page load or pop
        function loadPost() {
            //see if the popout container has a blog post
            if(($('#popout-container').hasClass('active-blog') || $('#popout-container').hasClass('active-blog-alt')) || $('#popout-container').hasClass('active-features')) {
                //Same issue you were having, content firing too quickly. Just added a settimeout as a temp fix
                setTimeout(function() {
                    //check if a post has been loaded or not
                    if(loadedPost == 0) {
                        //Check if a post id is set in the url
                        let current_url = window.location.search;
                        let params = new URLSearchParams(current_url);
                        var activePost = params.get("post_id");
                        if(activePost != null) {
                            //we found a post in the url, load that
                            $('#popout-container .blog-sidebar .blog-item[data-id='+activePost+']').trigger('click');
                        } else {
                            //no post in url, click the first item in the sidebar
                            if($('#popout-container').hasClass('active-blog-alt')) {
                                $('#popout-container .blog-sidebar .blog-item:nth-of-type(2)').trigger('click');
                            } else {
                                $('#popout-container .blog-sidebar .blog-item:first-of-type').trigger('click');
                            }
                            
                        }
                        //set our bool var to true so it doesnt happen again
                        loadedPost = 1;
                    } else {
                    //do nothing for now  
                    }
                },50);
            } else {
                //reset it so we load the post automatically the next time blog is clicked
                loadedPost = 0;
            }
        }
        //Mutation observer to watch for changes in popcontainer and load the post if so
        var popoutContainer = new MutationObserver(function() {
            loadPost();
        });

        //watch popout-container for changes and trigger load post function if so (line 36)
        popoutContainer.observe($("#popout-container")[0], {
            attributes: true
        });
        
        //Load post on popstate change
        window.addEventListener('popstate', function() {
            //loadedPost = 0;
            loadPost();
        });
        
        //load the blog item into the blog ajax container when clicked
        $('#popout-container').on('click','.blog-sidebar .blog-item',function(e) {
            e.stopPropagation();
            var post_id = $(this).attr('data-id');
            let current_url = window.location.search;
            let params = new URLSearchParams(current_url);
            var activePost = params.get("post_id");

            //Dont do anything if the user clicks a link that is already loaded
            if(post_id != activePost || loadedPost == 0) {
                //Add loading style
                $('.blog-single-content').addClass('loading');
                //remove other is-active
                $('.blog-item.is-active').removeClass('is-active');
                //add current class
                $(this).addClass('is-active');
                //Pop history, buggy but kind of working
                if($('#popout-container').hasClass('active-blog')) {
                    history.replaceState('blog', "",'?pop=blog&post_id='+post_id);
                } else if($('#popout-container').hasClass('active-blog-alt')) {
                    history.replaceState('blog-alt', "",'?pop=blog-alt&post_id='+post_id);
                }
                else if($('#popout-container').hasClass('active-features')) {
                    history.replaceState('features', "",'?pop=features&post_id='+post_id);
                }
                //get content for post from ajax function in functions.php
                var post_id = $(this).attr('data-id');
                jQuery.ajax({
                    url: home_js.ajax_url,
                    data: {
                        'action': 'load_commons_blog_post',
                        'post_id': post_id
                    }, success: function( data ) {
                        //load post into container
                        $('#popout-container #blog-ajax-container').html(data);
                        //remove loading class
                        $('.blog-single-content').removeClass('loading');
                    }
                });
            } else {
                //user clicked the same post that already is loaded
                console.log('already here');
            }
        });
	});
})(jQuery); // Fully reference jQuery after this point.