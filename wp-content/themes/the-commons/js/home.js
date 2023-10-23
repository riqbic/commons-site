/*
Theme Name: The Commons
Author: Alec Reduker
Author URI: http://reduker.wordpress.com
Description: Theme for The Commons Parkour brand
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Version: 1.21
*/

/*
 * Let's begin with validation functions
 */
jQuery.extend(jQuery.fn, {
	/*
	 * check if field value lenth more than 3 symbols ( for name and comment ) 
	 */
	validate: function () {
		if (jQuery(this).val().length < 3) {jQuery(this).addClass('error');return false} else {jQuery(this).removeClass('error');return true}
	},
	/*
	 * check if email is correct
	 * add to your CSS the styles of .error field, for example border-color:red;
	 */
	validateEmail: function () {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
		    emailToValidate = jQuery(this).val();
		if (!emailReg.test( emailToValidate ) || emailToValidate == "") {
			jQuery(this).addClass('error');return false
		} else {
			jQuery(this).removeClass('error');return true
		}
	},
});

(function($) {
	$(document).ready(function() {
        //bool var to see if we loaded a post automatically yet
        var loadedPost = 0;
        //automatically load a post on page load or pop
        function loadPostFromURL() {
            //see if the popout container has a blog post
            if($('#popout-container').hasClass('active-unpaid-videos') || $('#popout-container').hasClass('active-paid-videos') || $('#popout-container').hasClass('active-articles')) {
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
        
        //clicking paid previews
        $('#paid-videos-preview .blog-preview').on('click',function() {
            //Load the popout
            popOut('paid-videos',1,1);
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setActivePopoutPost($this);
        });

        //clicking unpaid previews
        $('#unpaid-videos-preview .blog-preview').on('click',function() {
            //Load the popout
            popOut('unpaid-videos',1,1);
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setActivePopoutPost($this);
        });

        //clicking articles
        $('#articles-preview .blog-preview').on('click',function() {
            //Load the popout
            popOut('articles',1,1);
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setActivePopoutPost($this);
        });

        //clicking menu items
        $('#videos-menu-item .blog-item','#videos-menu-item-mobile .blog-item').on('click',function() {
            //Load the popout
            popOut('paid-videos',1,1);
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
                if($('#popout-container').hasClass('active-unpaid-videos')) {
                    history.replaceState('unpaid-videos', "",'?pop=unpaid-videos&post_id='+post_id);
                } else if($('#popout-container').hasClass('active-paid-videos')) {
                    history.replaceState('paid-videos', "",'?pop=paid-videos&post_id='+post_id);
                } else if($('#popout-container').hasClass('active-articles')) {
                    history.replaceState('articles-videos', "",'?pop=articles&post_id='+post_id);
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
                        //replace login link for comments
                        if($('#popout-container #blog-ajax-container .must-log-in a').length) {
                            //https://alec.local/wp-login.php?redirect_to=https%3A%2F%2Falec.local%2Fpaid-film%2Ftether%2F
                            $('#popout-container #blog-ajax-container .must-log-in a').attr('href',home_js.blog_url+'wp-login.php?redirect_to='+encodeURIComponent(window.location.href));
                        }
                        if($('#popout-container #blog-ajax-container .must-log-in a').length) {
                            //https://alec.local/wp-login.php?redirect_to=https%3A%2F%2Falec.local%2Fpaid-film%2Ftether%2F
                            $('#popout-container #blog-ajax-container .must-log-in a').attr('href',home_js.blog_url+'wp-login.php?redirect_to='+encodeURIComponent(window.location.href));
                        }
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

        /** Ajax commenting, adapted from https://rudrastyh.com/wordpress/ajax-comments.html */
        $( document ).on('submit','.popout-container #commentform',function(){
            // define some vars
            var button = $('.popout-container #submit'), // submit button
                respond = $('.popout-container #respond'), // comment form container
                commentlist = $('.popout-container .comment-list'), // comment list container
                cancelreplylink = $('.popout-container #cancel-comment-reply-link');
                
            // validate comment in any case
            $( '#comment' ).validate();
            
            // if comment form isn't in process, submit it
            if ( !button.hasClass( 'loadingform' ) && !$( '#comment' ).hasClass( 'error' ) ){
                
                // ajax request
                $.ajax({
                    type : 'POST',
                    url : home_js.ajax_url, // admin-ajax.php URL
                    data: $(this).serialize() + '&action=commons_ajaxcomments', // send form data + action parameter
                    beforeSend: function(xhr){
                        // what to do just after the form has been submitted
                        button.addClass('loadingform').val('Loading...');
                    },
                    error: function (request, status, error) {
                        if( status == 500 ){
                            alert( 'Error while adding comment' );
                        } else if( status == 'timeout' ){
                            alert('Error: Server doesn\'t respond.');
                        } else {
                            // process WordPress errors
                            var wpErrorHtml = request.responseText.split("<p>"),
                                wpErrorStr = wpErrorHtml[1].split("</p>");
                                
                            alert( wpErrorStr[0] );
                        }
                    },
                    success: function ( addedCommentHTML ) {
                    
                        // if this post already has comments
                        if( commentlist.length > 0 ){
                        
                            // if in reply to another comment
                            if( respond.parent().hasClass( 'comment' ) ){
                            
                                // if the other replies exist
                                if( respond.parent().children( '.children' ).length ){	
                                    respond.parent().children( '.children' ).append( addedCommentHTML );
                                } else {
                                    // if no replies, add <ol class="children">
                                    addedCommentHTML = '<ol class="children">' + addedCommentHTML + '</ol>';
                                    respond.parent().append( addedCommentHTML );
                                }
                                // close respond form
                                cancelreplylink.trigger("click");
                            } else {
                                // simple comment
                                commentlist.append( addedCommentHTML );
                            }
                        }else{
                            // if no comments yet
                            addedCommentHTML = '<ol class="comment-list">' + addedCommentHTML + '</ol>';
                            respond.before( $(addedCommentHTML) );
                        }
                        // clear textarea field
                        $('.popout-container #comment').val('');
                    },
                    complete: function(){
                        // what to do after a comment has been added
                        button.removeClass( 'loadingform' ).val( 'Post Comment' );
                    }
                });
            }
            return false;
        });
	});
})(jQuery); // Fully reference jQuery after this point.