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
    popout_container.classList.add("mobile-popout");
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
    popout_container.classList.remove("mobile-popout");
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
    var popout_spacer = document.getElementById("popout-spacer");
    //pop out the content in the URL parameter
    if (params.getAll("pop").length !== 0){
        popout_state = 1;
        popout_container.style.display = "block";
        grid_container.style.visibility = "hidden";
        popout_container.appendChild(active_element);
        active_element.style.display = "block";
        setPopoutSize();
        setTimeout(function(){
            popout_spacer.style.height = popout_container.offsetHeight-newsy_container.offsetHeight+20+"px";
        },10);

        //replace history state to match pop variable
        history.replaceState(activeID,activeID,"?pop="+activeID);

        if (params.getAll("post_id").length !== 0){
            history.replaceState(activeID,activeID,"?pop="+activeID+"&post_id="+postID);
        }

        //Add which div id active
        popout_container.classList.add("active-"+activeID);
    }
    //don't remember why this is here but it's important (?)
    resize();
}

//turn off transitions after a transition has finished
window.addEventListener('transitionend',transitionToggle);
function transitionToggle(){
    var newsy_container = document.getElementById("newsy-container");
    var popout_container = document.getElementById("popout-container");
    var popout_spacer = document.getElementById("popout-spacer");
    popout_container.classList.remove("transitions");
    newsy_container.classList.remove("transitions");
    popout_spacer.style.height = popout_container.offsetHeight-newsy_container.offsetHeight+20+"px";
}

//Resize the popout container (and a few other things) when the page is resized
window.addEventListener('resize',resize);
function resize(){
    var about_us_flex_item = document.getElementsByClassName("about-us-flex-item");
    var about_us_grid_item = document.getElementById("about-us");
    var popout_container = document.getElementById("popout-container");
    var newsy_container = document.getElementById("newsy-container");
    var popout_spacer = document.getElementById("popout-spacer");
    setPopoutSize();
    setTimeout(function(){
        popout_spacer.style.height = popout_container.offsetHeight-newsy_container.offsetHeight+20+"px";
    },10);
    for (var i = 0; i < about_us_flex_item.length; i ++) {
        about_us_flex_item[i].style.width = about_us_grid_item.offsetWidth+"px";
    }
}

function menuHandler(activeID){
    var url = window.location.href.split('?')[0];
    var popout_container = document.getElementById("popout-container");

    console.log(url);
    if (url!=='https://thecommons.boston/' && activeID!==''){
        window.location.href='https://thecommons.boston?pop='+activeID;
    }
    else if (url!=='https://thecommons.boston/' && activeID===''){
        window.location.href='https://thecommons.boston/';
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
    var popout_spacer = document.getElementById("popout-spacer");

    //if the popout container is populated, and we are not already doing a popout
    //then "un-popout" the active content
    if(popout_container.hasChildNodes() && popout_state){

         //Add which div id active
         popout_container.classList.remove("active-"+activeID);

        //push the history stack, as long as the call came from the user, and not from a history push
        if(call_from_page){
            history.pushState(activeID,"The Commons","https://thecommons.boston");
        }

        popout_state = 0;
        var contentID = popout_container.firstChild.id;
        var activeID = contentID.split("-content").join("")
        var active_element = document.getElementById(contentID);
        var grid_container = document.getElementById(activeID);
        opacityToggle("1");

        setTimeout(function(){
            popout_container.style.display = "none";
            grid_container.appendChild(active_element);
            active_element.style.display = "none";
            newsy_container.style.display = "flex";
            popout_spacer.style.height = 0+"px";
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
        opacityToggle("0.3");
        popout_container.appendChild(active_element);
        active_element.style.display = "block";

        //setting the popout size, and removing the grid if we are on mobile.
        if(popout_container.classList.contains("mobile-popout")){
            newsy_container.style.display = "none";
            setPopoutSize(1);
        }
        else{
            setPopoutSize(0);
        }

        //the setTimeout just forces this code to run syncronously
        setTimeout(function(){
            popout_spacer.style.height = popout_container.offsetHeight-newsy_container.offsetHeight+20+"px";
        },10);
        window.scrollTo(0, 0);
    }
}

//toggle the opacity of the grid
function opacityToggle(opacity_level){
    var grid = document.getElementById("newsy-container");
    grid.style.opacity = opacity_level;
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

function setPopoutSize(mobile){
    var popout_container = document.getElementById("popout-container");
    var newsy_container = document.getElementById("newsy-container");
    if(mobile){
        popout_container.style.position = "static";
    }
    else{
        popout_container.style.display = "absolute";
        popout_container.style.width = newsy_container.offsetWidth-100+"px";
        popout_container.style.height = "70vh";
        popout_container.style.top = newsy_container.offsetTop+30+"px";
        popout_container.style.left = newsy_container.offsetLeft+50+"px";
    }
}