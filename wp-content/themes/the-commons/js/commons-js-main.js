/*
Theme Name: The Commons
Author: Alec Reduker
Author URI: http://reduker.wordpress.com
Description: Theme for The Commons Parkour brand
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Version: 1.21
*/

//global variables
var popout_state = 0;
var push_state = 1;

//Pop state handler
window.addEventListener('popstate', onPopState);
function onPopState(ev) {
   activeID = ev.state;
   popOut(activeID,0,1);
}

const jod_art_join = document.getElementById("jod-art-join");
const jod_art = document.getElementById("events");
jod_art.addEventListener(
    "mouseover",
    (event) => {
      // random position of JOIN header every mouseover
      jod_art_join.style.display = "block";
      jod_art_join.style.transform = "translate(" + (Math.random()*jod_art.offsetWidth-jod_art_join.offsetWidth) + "px, " + (Math.random()*jod_art.offsetHeight*-1) + "px)";
      // reset display property after a delay
      setTimeout(() => {
        jod_art_join.style.display = "none";
      }, 500);
    },
    false
  );

// Create a condition that targets viewports below 768px wide
const mediaQuery = window.matchMedia('(max-width: 768px)');

function handleTabletChange(e){
  // Check if the media query is true
  //(we are under 768px)
  if (e.matches) {
    var newsy_container = document.getElementById("newsy-container");
    var popout_container = document.getElementById("popout-container");
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");
    var paid_videos = document.getElementById("paid-videos");
    newsy_container.appendChild(paid_videos);
  }
  //over 768px
  else{
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");
    var popout_container = document.getElementById("popout-container");
    var flex_desktop_sidebar = document.getElementById("flex-desktop-sidebar");
    var paid_videos = document.getElementById("paid-videos");
    flex_desktop_grid.appendChild(paid_videos);
  }
}

// Register event listener
mediaQuery.addEventListener("change",handleTabletChange);

// Initial check
handleTabletChange(mediaQuery);

//On page load, opens the pop out given by the URL paramater "pop", operates similarly to the popout funciton
window.addEventListener('load',onPageLoad);
function onPageLoad() {
    //read URL param
    let url = window.location.search;
    let params = new URLSearchParams(url);
    var activeID = params.get("pop");
    var postID = params.get("post_id");

    //declarations
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);
    var active_element = document.getElementById(activeID+"-content");
    var full_content = document.getElementsByClassName(activeID+"-content-full");
    var newsy_container = document.getElementById("newsy-container");
    //pop out the content in the URL parameter
    if (params.getAll("pop").length !== 0){
        popout_state = 1;
        popout_container.style.display = "block";
        popout_container.appendChild(active_element);
        active_element.style.display = "block";
        opacityToggle(1);
        setPopoutSize();

        document.body.style.setProperty('overflow-y', 'hidden', 'important');
        scrollTo(0,120);

        //replace history state to match pop variable
        history.replaceState(activeID,activeID,"?pop="+activeID);

        if (params.getAll("post_id").length !== 0){
            history.replaceState(activeID,activeID,"?pop="+activeID+"&post_id="+postID);
        }

        //Add which div id active
        popout_container.classList.add("active-"+activeID);
    }
    resize();
}

//Resize the popout container (and a few other things) when the page is resized
window.addEventListener('resize',resize);
function resize(){
    const about_us_flex_item = document.getElementsByClassName("about-us-flex-item");
    var about_us_grid_item = document.getElementById("about-us-preview");
    var get_involved_grid_item = document.getElementById("get-involved-preview");
    var sidebar_blog = document.getElementById("unpaid-videos-preview");
    var articles = document.getElementById("articles-preview");
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");

    setPopoutSize(); 

    articles.style.maxHeight = about_us_grid_item.offsetHeight+get_involved_grid_item.offsetHeight+20+"px";
    sidebar_blog.style.maxHeight = flex_desktop_grid.offsetHeight+"px";

    for (var i = 0; i < about_us_flex_item.length; i ++) {
        about_us_flex_item[i].style.width = about_us_grid_item.offsetWidth+"px";
    }
}

function menuHandler(activeID){
    var url = window.location.href.split('?')[0];
    var popout_container = document.getElementById("popout-container");
    var menu_toggle = document.getElementById("menu-toggle");

    menu_toggle.checked = '';
    console.log('menuHandler');

    if (url !== commons_main.blog_url && activeID!==''){
        window.location.href=commons_main.blog_url+'?pop='+activeID;
        console.log('1');
    }
    else if (url !== commons_main.blog_url && activeID===''){
        window.location.href=commons_main.blog_url;
        console.log('2');
    }
    else if (activeID=="" && popout_container.hasChildNodes()){
        popOut(popout_container.firstChild.id,1,1);
        console.log('3');
    }
    else if (activeID==""){
        console.log('4');
        return;
    }
    else if (popout_container.hasChildNodes()){
        console.log('5');
        popOut(popout_container.firstChild.id,1,1);
        setTimeout(function(){
            popOut(activeID,1,1);
        },1000);
    }
    else{
        console.log('6');
        popOut(activeID,1,1);
    }
}


//popOut(the ID of the grid item being popped out, did the function call come from the page? 0 or 1, should the transition play? 0 or 1)
function popOut(activeID,call_from_page,transition){
    //declarations
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);
    var active_element = document.getElementById(activeID+"-content");
    var preview_element = document.getElementById(activeID+"-preview");
    var newsy_container = document.getElementById("newsy-container");

    //if the popout container is populated, and we are not already doing a popout
    //then "un-popout" the active content
    if(popout_container.hasChildNodes() && popout_state){

        popout_state = 0;
        var contentID = popout_container.firstChild.id;
        var activeID = contentID.split("-content").join("")
        var active_element = document.getElementById(contentID);
        var grid_container = document.getElementById(activeID);
        opacityToggle(0);
        document.body.style.overflowY = "auto";

        setTimeout(function(){

            //Add which div id active
            popout_container.classList.remove("active-"+activeID);
            
            popout_container.style.display = "none";
            grid_container.appendChild(active_element);
            active_element.style.display = "none";

            //push the history stack, as long as the call came from the user, and not from a history push
            if(call_from_page){
                history.pushState(activeID,"The Commons",commons_main.blog_url);
            }
        },10);
    }

    //if the popout container is empty, and we are not currently doing a pop out
    //then add the content to the popout container, and pop it out.
    else if(!popout_container.hasChildNodes() && !popout_state){

        //Remove active div from classlist
        popout_container.classList.add("active-"+activeID);

        //push the history stack, as long as the call came from the user, and not from a history push
        if(call_from_page){
            history.pushState(activeID,activeID,"?pop="+activeID);
        }

        popout_state = 1;
        popout_container.style.display = "block";
        opacityToggle(1);
        popout_container.appendChild(active_element);
        active_element.style.display = "block";
        document.body.style.setProperty('overflow-y', 'hidden', 'important');

        setPopoutSize();

        if(window.scrollY < 120){
            scrollTo(0,120);
        }
    }
}

//toggle the popout shadow
function opacityToggle(state){
    var shadow = document.getElementById("popout-shadow");
    if(state){
        shadow.style.display = "block";
    }
    else{
        shadow.style.display = "none";
    }
}

//sets the popout container to the size of the grid element it is replacing
function resetPopoutSize(activeID){
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);

    popout_container.style.width = grid_container.offsetWidth+"px";
    popout_container.style.height = grid_container.offsetHeight+"px";
    popout_container.style.top = grid_container.offsetTop+"px";
    popout_container.style.left = grid_container.offsetLeft+"px";
}

function setPopoutSize(){
    var popout_container = document.getElementById("popout-container");
    var newsy_container = document.getElementById("newsy-container");
    popout_container.style.position = "fixed";
    popout_container.style.width = newsy_container.offsetWidth-100+"px";
    popout_container.style.left = newsy_container.offsetLeft+50+"px";
    popout_container.style.height = "80vh";
    popout_container.style.top = "100px";
}

function clamp(val, min, max) {
    return val > max ? max : val < min ? min : val;
}

//Mobile dropdown
var menuItems = document.getElementsByClassName("has-children");
var toggleActive = function() {
    this.classList.toggle("is-active");
};
for (var i = 0; i < menuItems.length; i++) {
    menuItems[i].addEventListener('click', toggleActive, false);
}

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
                },200);
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

        //clicking video menu items
        $('#videos-menu-item .blog-item').on('click',function() {
            //Load the popout
            menuHandler('paid-videos');
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setActivePopoutPost($this);
        });
         //clicking mobile video menu items
         $('#videos-menu-item-mobile .blog-item').on('click',function() {
            menuHandler('paid-videos');
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setActivePopoutPost($this);
        });

        //clicking article menu items
        $('#articles-menu-item .blog-item').on('click',function() {
            //Load the popout
            popOut('articles',1,1);
            loadedPost = 0;
            //set the post content to use in the popout 
            var $this = $(this);
            setActivePopoutPost($this);
        });
         //clicking mobile article menu items
         $('#articles-menu-item-mobile .blog-item').on('click',function() {
            var menu_toggle = document.getElementById("menu-toggle");
            menu_toggle.checked = '';
            
            //if popout container is already populated, clear it out first, then open new item
            var popout_container = document.getElementById("popout-container");
            if (popout_container.hasChildNodes()){
                popOut(popout_container.firstChild.id,0,1);
                setTimeout(function(){
                    popOut('articles',1,1);
                    loadedPost = 0;
                    //set the post content to use in the popout 
                    var $this = $(this);
                    setActivePopoutPost($this);
                },50);
            }
            else{
                popOut('articles',1,1);
                loadedPost = 0;
                //set the post content to use in the popout 
                var $this = $(this);
                setActivePopoutPost($this);
            }
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