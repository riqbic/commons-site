//global variables
var popout_state = 0;
var push_state = 1;
var history_count = 0;

window.addEventListener('popstate', onPopState);
function onPopState(ev) {
   activeID = ev.state;
   popOut(activeID,0);
   history_count -= 1;
}

window.addEventListener('load',onPageLoad);
function onPageLoad() {
    let url = window.location.search;
    let params = new URLSearchParams(url);
    var popout_container = document.getElementById("popout-container");

    if (params.getAll("pop").length !== 0) {
        popOut(params.get("pop"));
    }
}

window.addEventListener('resize',resize);
function resize(){
    var about_us_flex_item = document.getElementsByClassName("about-us-flex-item");
    var about_us_grid_item = document.getElementById("about-us");
    var popout_container = document.getElementById("popout-container");
    popout_container.style.width = document.getElementById("newsy-container").offsetWidth-20+"px";
    for (var i = 0; i < about_us_flex_item.length; i ++) {
        about_us_flex_item[i].style.width = about_us_grid_item.offsetWidth+"px";
    }
}

function popOut(activeID,call_from_page){
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);
    var active_element = document.getElementById(activeID+"-content");
    var full_content = document.getElementsByClassName(activeID+"-content-full");

    if(popout_container.hasChildNodes() && popout_state){
        if(call_from_page && push_state){
            history.pushState(activeID,"The Commons","http://127.0.0.1:5500/grid-test.html");
            //console.log("push reset");
            history_count += 1;
        }
        popout_state = 0;
        push_state = 0;
        var contentID = popout_container.firstChild.id;
        var activeID = contentID.split("-content").join("")
        var active_element = document.getElementById(contentID);
        var grid_container = document.getElementById(activeID);
        for (var i = 0; i < full_content.length; i ++) {
            full_content[i].style.opacity = 0;
        }
        resetPopoutSize(activeID);
        //opacityToggle("1");
        setTimeout(function(){
            popout_container.style.display = "none";
            grid_container.appendChild(active_element);
            grid_container.style.visibility = "visible";
            push_state = 1;
        },10);
    }

    //if the popout container is empty, and
    else if(!popout_container.hasChildNodes() && !popout_state){
        if(call_from_page){
            history.pushState(activeID,activeID,"?pop="+activeID);
            history_count += 1;
        }
        popout_state = 1;
        resetPopoutSize(activeID);
        popout_container.style.display = "block";
        grid_container.style.visibility = "hidden";
        //opacityToggle("0");
        popout_container.appendChild(active_element);
        setTimeout(function(){
            popout_container.style.width = document.getElementById("newsy-container").offsetWidth-20+"px";
            popout_container.style.height = document.getElementById("newsy-container").offsetHeight-20+"px";
            popout_container.style.top = document.getElementById("newsy-container").offsetTop+10+"px";
            popout_container.style.left = "10px";
            for (var i = 0; i < full_content.length; i ++) {
                full_content[i].style.opacity = 1;
            }
        },10);
        window.scrollTo(0, 0);
    }
    //console.log(history.state);
}

/*toggle the opacity of the grid*/
function opacityToggle(opacity_level){
    var grid = document.getElementById("newsy-container");
    grid.style.opacity = opacity_level;
}

/*sets the popout container to the size of the grid element it is replacing*/
function resetPopoutSize(activeID){
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);

    popout_container.style.width = grid_container.offsetWidth+"px";
    popout_container.style.height = grid_container.offsetHeight+"px";
    popout_container.style.top = grid_container.offsetTop+"px";
    popout_container.style.left = grid_container.offsetLeft+"px";
}