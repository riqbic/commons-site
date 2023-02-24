//global variables
var popout_state = 0;
var push_state = 1;

window.addEventListener('popstate', onPopState);
function onPopState(ev) {
   activeID = ev.state;
   popOut(activeID,0,1);
}

window.addEventListener('load',onPageLoad);
function onPageLoad() {
    let url = window.location.search;
    let params = new URLSearchParams(url);
    var activeID = params.get("pop");

    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);
    var active_element = document.getElementById(activeID+"-content");
    var full_content = document.getElementsByClassName(activeID+"-content-full");
    var newsy_container = document.getElementById("newsy-container");

    if (params.getAll("pop").length !== 0){
        //popOut(params.get("pop"),0,0);
        popout_state = 1;
        popout_container.style.display = "block";
        grid_container.style.visibility = "hidden";
        popout_container.appendChild(active_element);
        popout_container.style.width = newsy_container.offsetWidth-20+"px";
        popout_container.style.height = newsy_container.offsetHeight-20+"px";
        popout_container.style.top = newsy_container.offsetTop+10+"px";
        popout_container.style.left = "10px";
        for (var i = 0; i < full_content.length; i ++) {
            full_content[i].style.opacity = 1;
        }
    }
    resize();
}

window.addEventListener('transitionend',transitionToggle);
function transitionToggle(){
    var newsy_container = document.getElementById("newsy-container");
    var popout_container = document.getElementById("popout-container");
    popout_container.classList.remove("transitions");
    newsy_container.classList.remove("transitions");
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


//params (the ID of the grid item being popped out, did the function call come from the page? 0 or 1, should the transition play? 0 or 1)
function popOut(activeID,call_from_page,transition){
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);
    var active_element = document.getElementById(activeID+"-content");
    var full_content = document.getElementsByClassName(activeID+"-content-full");
    var newsy_container = document.getElementById("newsy-container");

    if(transition){
        popout_container.classList.add("transitions");
        newsy_container.classList.add("transitions");
    }

    if(popout_container.hasChildNodes() && popout_state){
        if(call_from_page && push_state){
            history.pushState(activeID,"The Commons","");
            //console.log("push reset");
        }
        popout_state = 0;
        push_state = 0;
        var contentID = popout_container.firstChild.id;
        var full_content = document.getElementsByClassName(contentID+"-full");
        var activeID = contentID.split("-content").join("")
        var active_element = document.getElementById(contentID);
        var grid_container = document.getElementById(activeID);
        for (var i = 0; i < full_content.length; i ++) {
            full_content[i].style.opacity = 0;
        }
        resetPopoutSize(activeID);
        opacityToggle("1");
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
        }
        popout_state = 1;
        resetPopoutSize(activeID);
        popout_container.style.display = "block";
        grid_container.style.visibility = "hidden";
        opacityToggle("0");
        popout_container.appendChild(active_element);
        setTimeout(function(){
            popout_container.style.width = newsy_container.offsetWidth-20+"px";
            popout_container.style.height = newsy_container.offsetHeight-20+"px";
            popout_container.style.top = newsy_container.offsetTop+10+"px";
            popout_container.style.left = "10px";
            for (var i = 0; i < full_content.length; i ++) {
                full_content[i].style.opacity = 1;
            }
        },10);
        window.scrollTo(0, 0);
    }
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