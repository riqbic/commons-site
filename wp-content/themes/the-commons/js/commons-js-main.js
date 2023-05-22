//global variables
var popout_state = 0;
var push_state = 1;

//Pop state handler
window.addEventListener('popstate', onPopState);
function onPopState(ev) {
   activeID = ev.state;
   popOut(activeID,0,1);
}

// Create a condition that targets viewports below 768px wide
const mediaQuery = window.matchMedia('(max-width: 768px)');

function handleTabletChange(e){
  // Check if the media query is true
  //(we are under 768px)
  if (e.matches) {
    var newsy_container = document.getElementById("newsy-container");
    var popout_container = document.getElementById("popout-container");
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");
    var features = document.getElementById("features");
    var blog_alt = document.getElementById("blog-alt");
    newsy_container.appendChild(features);
    flex_desktop_grid.appendChild(blog_alt);
  }
  //over 768px
  else{
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");
    var popout_container = document.getElementById("popout-container");
    var flex_desktop_sidebar = document.getElementById("flex-desktop-sidebar");
    var features = document.getElementById("features");
    var blog_alt = document.getElementById("blog-alt");
    flex_desktop_grid.appendChild(features);
    flex_desktop_sidebar.appendChild(blog_alt);
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
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");
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

    //hides sidebar blog posts that are below the grid
    let alt_blogs = document.getElementsByClassName('blog-item-2');
    for(var i = 0; i < alt_blogs.length; i ++){
        if(alt_blogs[i].offsetTop+alt_blogs[i].offsetHeight > flex_desktop_grid.offsetTop+flex_desktop_grid.offsetHeight){
            alt_blogs[i].style.display = 'none;';
        }
        else{
            alt_blogs[i].style.display = 'block;';
        }
    }
    //don't remember why this is here but it's important (?)
    resize();
}

//Resize the popout container (and a few other things) when the page is resized
window.addEventListener('resize',resize);
function resize(){
    const about_us_flex_item = document.getElementsByClassName("about-us-flex-item");
    var about_us_grid_item = document.getElementById("about-us");
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");

    setPopoutSize();

    for (var i = 0; i < about_us_flex_item.length; i ++) {
        about_us_flex_item[i].style.width = about_us_grid_item.offsetWidth+"px";
    }

    //hides sidebar blog posts that are below the grid
    let alt_blogs = document.getElementsByClassName('blog-item-2');
    for(var i = 0; i < alt_blogs.length; i ++){
        if(alt_blogs[i].offsetTop+alt_blogs[i].offsetHeight > flex_desktop_grid.offsetTop+flex_desktop_grid.offsetHeight){
            alt_blogs[i].style.display = 'none;';
        }
        else{
            alt_blogs[i].style.display = 'block;';
        }
    }
}

function menuHandler(activeID){
    var url = window.location.href.split('?')[0];
    var popout_container = document.getElementById("popout-container");
    var menu_toggle = document.getElementById("menu-toggle");

    menu_toggle.checked = '';

    if (url !== commons_main.blog_url && activeID!==''){
        window.location.href=commons_main.blog_url+'?pop='+activeID;
    }
    else if (url !== commons_main.blog_url && activeID===''){
        window.location.href=commons_main.blog_url;
    }
    else if (activeID=="" && popout_container.hasChildNodes()){
        popOut(popout_container.firstChild.id,1,1);
    }
    else if (activeID==""){
        return;
    }
    else if (popout_container.hasChildNodes()){
        popOut(popout_container.firstChild.id,1,1);
        setTimeout(function(){
            popOut(activeID,1,1);
        },1000);
    }
    else{
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