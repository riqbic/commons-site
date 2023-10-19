/*
Theme Name: The Commons
Author: Alec Reduker
Author URI: http://reduker.wordpress.com
Description: Theme for The Commons Parkour brand
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Version: 1.21
*/

(function($) {
	$(document).ready(function() {
        //bool var to see if we loaded a post automatically yet
        var loadedPost = 0;
        //automatically load a post on page load or pop
        function loadPostFromURL() {
            //see if the popout container has a blog post
            if($('#popout-container').hasClass('active-blog') || $('#popout-container').hasClass('active-features')) {
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
                            var $this = $('#popout-container .blog-sidebar .blog-item[data-id='+activePost+']');
                            setActivePopoutPost($this);
                        } else {
                            //no post in url, click the first item in the sidebar
                            $('#popout-container .blog-sidebar .blog-item:first-of-type').trigger('click');
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
        //check on page load if a post should be loaded
        loadPostFromURL();

        //Mutation observer to watch for changes in popcontainer and load the post if so
        var popoutContainer = new MutationObserver(function() {
            loadPostFromURL();
        });
        //watch said popout-container for changes and trigger load post function if so (var popoutContainer = new MutationObserver(function() .... )
        popoutContainer.observe($("#popout-container")[0], {
            attributes: true
        });
        
        //Load post on popstate change
        window.addEventListener('popstate', function() {
            //loadedPost = 0;
            loadPostFromURL();
        });
        
        //clicking sidebar post in blog-preview or blog-preview-alt
        $('#blog-preview .blog-preview,#articles-preview .blog-preview').on('click',function() {
            //Load the popout
            popOut('blog',1,1);
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setActivePopoutPost($this);
        });

        //load the post in the popout contain when it's sidebar item is clicked
        $('#popout-container').on('click','.blog-sidebar .blog-item',function(e) {
            e.stopPropagation();
            var $this = $(this);
            setActivePopoutPost($this);
        });

        //Set the active post to be displayed in the popout
        function setActivePopoutPost($this) {
            var post_id = $this.attr('data-id');
            let current_url = window.location.search;
            let params = new URLSearchParams(current_url);
            var activePost = params.get("post_id");

            //Dont do anything if the user clicks a link that is already loaded
            if(post_id != activePost || loadedPost == 0) {
                //Add loading style
                if(loadedPost==0){
                    $('.blog-single-content > .loader').addClass('loader-active');
                }
                $('.blog-single-content').addClass('loading');

                //Change title of popout bar to show loading (optional)
                $('#popout-container .post-title').text('Loading...');
                //Set post loading content
                $('#popout-container #blog-ajax-container').html('<div class="post-ajax-loader"></div>');
                
                //remove other is-active
                $('.blog-item.is-active').removeClass('is-active');
                //add current class
                $this.addClass('is-active');
                //Pop history, buggy but kind of working
                if($('#popout-container').hasClass('active-blog')) {
                    history.replaceState('blog', "",'?pop=blog&post_id='+post_id);
                } else if($('#popout-container').hasClass('active-features')) {
                    history.replaceState('features', "",'?pop=features&post_id='+post_id);
                }
                jQuery.ajax({
                    url: home_js.ajax_url,
                    data: {
                        'action': 'load_commons_blog_post',
                        'post_id': post_id
                    }, success: function( data ) {
                        var response = JSON.parse(data);
                        //load post into container
                        $('#popout-container #blog-ajax-container').html(response.post_content);
                        //Update the title in the popout bar
                        $('#popout-container .post-title').html(response.post_title);
                        //Scroll to top
                        $('#popout-container #blog-ajax-container').scrollTop(0);
                        if(window.innerWidth<768){
                            $('#popout-container .blog-flex-container').scrollTop(0);
                        }

                        //remove loading class
                        $('.blog-single-content').removeClass('loading');
                        $('.blog-single-content > .loader').removeClass('loader-active');
                    }
                });

            } else {
                //user clicked the same post that already is loaded
                console.log('already here');
            }
        }
	});
})(jQuery); // Fully reference jQuery after this point.