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
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");
    var features = document.getElementById("features");
    var blog_alt = document.getElementById("blog-alt");
    newsy_container.appendChild(features);
    flex_desktop_grid.appendChild(blog_alt);
  }
  //over 768px
  else{
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");
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
    //pop out the content in the URL parameter
    if (params.getAll("pop").length !== 0){
        popout_state = 1;
        popout_container.style.display = "block";
        grid_container.style.visibility = "hidden";
        popout_container.appendChild(active_element);
        active_element.style.display = "block";

        var scaleX = newsy_container.offsetWidth/popout_container.style.width;
        var scaleY = newsy_container.offsetHeight/popout_container.style.height;
        var translateX = newsy_container.offsetLeft;
        var translateY = newsy_container.offsetTop;
        popout_container.style.transform = "matrix("+scaleX+",0,0,"+scaleY+","+translateX+","+translateY+")"

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
    popout_container.classList.remove("transitions");
    newsy_container.classList.remove("transitions");
}

//Resize the popout container (and a few other things) when the page is resized
window.addEventListener('resize',resize);
function resize(){
    var about_us_flex_item = document.getElementsByClassName("about-us-flex-item");
    var about_us_grid_item = document.getElementById("about-us");
    var popout_container = document.getElementById("popout-container");
    var newsy_container = document.getElementById("newsy-container");
    popout_container.style.left = newsy_container.offsetLeft+10+"px";
    popout_container.style.width = newsy_container.offsetWidth-20+"px";
    popout_container.style.top = newsy_container.offsetTop+10+"px";
    for (var i = 0; i < about_us_flex_item.length; i ++) {
        about_us_flex_item[i].style.width = about_us_grid_item.offsetWidth+"px";
    }
}

function menuHandler(activeID){
    var url = window.location.href.split('?')[0];
    var popout_container = document.getElementById("popout-container");

    console.log(url);
    if (url!=='https://thecommons.boston/'){
        window.location.href='https://thecommons.boston?pop='+activeID;
    }
    else if (activeID==""){
        popOut(popout_container.firstChild.id,1,1);
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

    //turn on transitions if specified in params
    if(transition){
        popout_container.classList.add("transitions");
        newsy_container.classList.add("transitions");
    }

    //if the popout container is populated, and we are not already doing a popout
    //then "un-popout" the active content
    if(popout_container.hasChildNodes() && popout_state){
        
         //Add which div id active
         popout_container.classList.remove("active-"+activeID);

        //push the history stack, as long as the call came from the user, and not from a history push
        if(call_from_page && push_state){
            history.pushState(activeID,"The Commons","https://thecommons.boston");
        }

        popout_state = 0;
        push_state = 0;
        var contentID = popout_container.firstChild.id;
        var activeID = contentID.split("-content").join("")
        var active_element = document.getElementById(contentID);
        var grid_container = document.getElementById(activeID);
        resetPopoutSize(activeID);
        opacityToggle("1");
        
        setTimeout(function(){
            popout_container.style.visibility = "visible";
            grid_container.appendChild(active_element);
            active_element.style.visibility = "visible";
            grid_container.style.visibility = "visible";
            push_state = 1;
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
        resetPopoutSize(activeID);
        popout_container.style.visibility = "visible";
        grid_container.style.visibility = "visible";
        opacityToggle("0.2");
        popout_container.appendChild(active_element);
        active_element.style.visibility = "visible";
        
        //the setTimeout just forces this code to run syncronously
        setTimeout(function(){
            var scaleX = newsy_container.offsetWidth/popout_container.style.width;
            var scaleY = newsy_container.offsetHeight/popout_container.style.height;
            var translateX = newsy_container.offsetLeft;
            var translateY = newsy_container.offsetTop;
            console.log("matrix("+scaleX+",0,0,"+scaleY+","+translateX+","+translateY+")");

            popout_container.style.transform = "matrix("+scaleX+",0,0,"+scaleY+","+translateX+","+translateY+")";
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

    var scaleX = grid_container.offsetWidth/popout_container.style.width;
    var scaleY = grid_container.offsetHeight/popout_container.style.height;
    var translateX = grid_container.offsetLeft;
    var translateY = grid_container.offsetTop;

    console.log("matrix("+scaleX+",0,0,"+scaleY+","+translateX+","+translateY+")");

    popout_container.style.transform = "matrix("+scaleX+",0,0,"+scaleY+","+translateX+","+translateY+")";
}