/* mobile menu event listeners, added to top because it wasn't firign lower - guessing there is a bug in your code somewhere... */
var menuItems = document.getElementsByClassName("has-children");
var toggleActive = function() {
    this.classList.toggle("is-active");
};
for (var i = 0; i < menuItems.length; i++) {
    menuItems[i].addEventListener('click', toggleActive, false);
}

//global variables
var popout_state = 0;
var push_state = 1;

//Pop state handler
window.addEventListener('popstate', onPopState);
function onPopState(ev) {
   activeID = ev.state;
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

//On page load, resize
window.addEventListener('load',onPageLoad);
function onPageLoad() {
    resize();
}

//Resize the popout container (and a few other things) when the page is resized
window.addEventListener('resize',resize);
function resize(){
    var about_us_grid_item = document.getElementById("about-us-preview");
    var get_involved_grid_item = document.getElementById("get-involved-preview");
    var sidebar_blog = document.getElementById("unpaid-videos-preview");
    var articles = document.getElementById("articles-preview");
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");

    setPopoutSize(); 

    articles.style.maxHeight = about_us_grid_item.offsetHeight+get_involved_grid_item.offsetHeight+20+"px";
    sidebar_blog.style.maxHeight = flex_desktop_grid.offsetHeight+"px";
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
