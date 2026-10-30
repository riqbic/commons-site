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
            //console.log(window.history.state);
            var current_url = window.location.search;
            var params = new URLSearchParams(current_url);
            var activePost = params.get("post_id");
            if(activePost != null) {

                //Set active popup
                var category = params.get("pop");
                if(category !== null) {
                    setActivePopup(category);
                    //Same issue you were having, content firing too quickly. Just added a settimeout as a temp fix
                    //setTimeout(function() {
                        //check if a post has been loaded or not
                        if(loadedPost == 0) {
                            if(activePost != null) {
                                //we found a post in the url, load that
                                var $this = $('#popout-container .blog-sidebar .blog-item[data-id='+activePost+']');
                                //sidebar is a random selection, so the post may not be in it; load it by id instead
                                if(!$this.length) {
                                    $this = $('<div>').attr('data-id', activePost);
                                }
                                setCurrentPostInActivePopup($this,false);
                            } else {
                                //no post in url, click the first item in the sidebar
                                $('#popout-container .blog-sidebar .blog-item:first-of-type').trigger('click');
                            }
                            //set our bool var to true so it doesnt happen again
                            loadedPost = 1;
                        } else {
                            //console.log('no loaded post');
                            //do nothing for now  
                        }
                   // },200);
                }
            } else {
                loadedPost = 0;
                closePopout();
            }
        }
        //check on page load if a post should be loaded
        loadPostFromURL();
        
        //Load post on popstate change
        window.addEventListener('popstate', function() {
            console.log(window.history.state);
            loadedPost = 0;
            loadPostFromURL();
        });
        
        //clicking paid previews
        $('#paid-videos-preview .blog-preview').on('click',function() {
            //Load the popout
            setActivePopup('videos');
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setCurrentPostInActivePopup($this);
        });

        //Video Feature carousel: arrows, dots, and swipe (native scroll-snap). No autoplay.
        $('#paid-videos-preview .video-carousel').each(function() {
            var $carousel = $(this);
            var track = $carousel.find('.video-carousel-track')[0];
            var slideCount = $(track).children('.video-slide').length;
            var $dots = $('#paid-videos-preview .carousel-dot');

            function currentIndex() {
                return track.clientWidth ? Math.round(track.scrollLeft / track.clientWidth) : 0;
            }
            function goTo(index) {
                //wrap around at either end
                index = (index + slideCount) % slideCount;
                track.scrollTo({ left: index * track.clientWidth, behavior: 'smooth' });
            }
            function updateDots() {
                $dots.removeClass('is-active').eq(currentIndex()).addClass('is-active');
            }

            //Size the track to the visible slide. Mid-swipe, blend between the two slides' heights
            //so the content below moves smoothly with the swipe instead of jumping at the end.
            var slides = $(track).children('.video-slide').toArray();
            function syncHeight() {
                var width = track.clientWidth;
                if (!width || !slides.length) return;
                var position = track.scrollLeft / width;
                var i = Math.min(Math.floor(position), slideCount - 1);
                var fraction = position - i;
                var current = slides[i].offsetHeight;
                var next = slides[Math.min(i + 1, slideCount - 1)].offsetHeight;
                track.style.height = (current + (next - current) * fraction) + 'px';
            }

            //Batch scroll updates to one per animation frame
            var frameRequested = false;
            function onScroll() {
                if (frameRequested) return;
                frameRequested = true;
                requestAnimationFrame(function() {
                    frameRequested = false;
                    updateDots();
                    syncHeight();
                });
            }

            track.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll);
            //re-measure once fonts and images have finished loading
            window.addEventListener('load', syncHeight);
            syncHeight();

            //stopPropagation so arrow/dot clicks never open the popout
            //arrows live in #paid-videos-preview (outside .video-carousel) so they center on the header + carousel
            $('#paid-videos-preview .carousel-prev').on('click', function(e) {
                e.stopPropagation();
                goTo(currentIndex() - 1);
            });
            $('#paid-videos-preview .carousel-next').on('click', function(e) {
                e.stopPropagation();
                goTo(currentIndex() + 1);
            });
            $dots.on('click', function(e) {
                e.stopPropagation();
                goTo(parseInt($(this).attr('data-index'), 10));
            });

            //Clicking the "Video Feature" header (title or play icon) opens the video currently shown
            $('#paid-videos-preview .block-header').on('click', function() {
                $(slides[currentIndex()]).trigger('click');
            });
        });

        //clicking unpaid previews
        $('#unpaid-videos-preview .blog-preview').on('click',function() {
            //Load the popout
            setActivePopup('videos');
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setCurrentPostInActivePopup($this);
        });

        //clicking articles
        $('#articles-preview .blog-preview').on('click',function() {
            //Load the popout
            setActivePopup('articles');
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setCurrentPostInActivePopup($this);
        });

    //Load the ponst instead of using the link on sub items in nav (desktop and mobile)
    $('.has-children .pop-item a').on('click',function(e) {
        e.preventDefault();
        //close menu
        $('#menu-toggle').prop('checked',false);
    });

        //Load the ponst instead of using the link on sub items in nav (desktop and mobile)
        $('.load-from-url').on('click',function(e) {
            e.preventDefault();
            //get category
            var category = $(this).attr('data-category');
            //get link and set it in the url
            var link = $(this).attr('href');
            link = link.replace('paid-videos','videos');
            link = link.replace('unpaid-videos','videos');
            if(category == 'paid-videos' || category == 'unpaid-videos'){
                category = 'videos';
            }
            history.pushState(category,"",link);
            setActivePopup(category);
            loadPostFromURL();
        });

        function setActivePopup(category) {
            loadedPost = 0;
            var html = $('#preview-content #'+category+'-html').html();
            setPopoutSize();
            opacityToggle(1);
            if(window.scrollY < 120 && window.innerWidth > 768){
                window.scrollTo({top: 120, left: 0, behavior: "smooth",});
            }
            $('body').addClass('noscroll');
            $('#popout-shadow').css('display','block');
            $('#popout-container').html(html).removeClass('active-articles').removeClass('active-videos').addClass('active-'+category).css('display','block');
            $('#popout-container .grid-content').css('display','block');
        }

        $(document).on('click','.force-close-popout',function() {
            closePopout();
        });

        function closePopout() {
            history.pushState('close', "",home_js.blog_url);
            $('#popout-container').css('display','none');
            $('#popout-shadow').css('display','none');
            $('body').removeClass('noscroll');
        }

        //load the post in the popout contain when it's sidebar item is clicked
        $('#popout-container').on('click','.blog-sidebar .blog-item',function(e) {
            e.stopPropagation();
            var $this = $(this);
            setCurrentPostInActivePopup($this);
        });

        //Set the active post to be displayed in the popout
        function setCurrentPostInActivePopup($this, updatePopstate = true) {
            var post_id = $this.attr('data-id');
            //console.log('loading '+post_id);
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
                if(updatePopstate) {
                    if($('#popout-container').hasClass('active-videos')) {
                        history.pushState('videos', "",'?pop=videos&post_id='+post_id);
                    } else if($('#popout-container').hasClass('active-articles')) {
                        history.pushState('articles-videos', "",'?pop=articles&post_id='+post_id);
                    }
                }
                jQuery.ajax({
                    url: home_js.ajax_url,
                    data: {
                        'action': 'load_commons_blog_post',
                        'post_id': post_id
                    }, success: function( data ) {
                        //console.log('popout done');
                        var response = JSON.parse(data);
                        //load post into container
                        $('#popout-container #blog-ajax-container').html(response.post_content);
                        //replace login link for comments
                        if($('#popout-container #blog-ajax-container .must-log-in a').length) {
                            //https://alec.local/wp-login.php?redirect_to=https%3A%2F%2Falec.local%2Fpaid-film%2Ftether%2F
                            $('#popout-container #blog-ajax-container .must-log-in a').attr('href',home_js.blog_url+'my-account/?redirect_to='+encodeURIComponent(window.location.href));
                        }
                        if($('#popout-container #blog-ajax-container .must-log-in a').length) {
                            //https://alec.local/wp-login.php?redirect_to=https%3A%2F%2Falec.local%2Fpaid-film%2Ftether%2F
                            $('#popout-container #blog-ajax-container .must-log-in a').attr('href',home_js.blog_url+'my-account/?redirect_to='+encodeURIComponent(window.location.href));
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
                //console.log('already here');
            }
        }

        $('.opens-popup').on('click',function() {
            var div = $(this).attr('data-popup');
            var url = '?pop='+div+'&post_id=1';
            history.pushState(div,"",url);
            setActivePopup(div);
        });
        
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