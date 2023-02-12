//global variables
var popout_state = 0;
var push_state = 0;

// decide what state to push based on the same logic as popOut(), this exists so we can call popOut without also pushing a state
function pushStateHandler(activeID){
    var popout_container = document.getElementById("popout-container");
    var active_element = document.getElementById(activeID+"-content");
    if(popout_state===1){
        console.log("push popout");
        history.pushState(activeID,activeID,activeID);
    }
    else if(popout_state===0){
        console.log("push reset");
        history.pushState(activeID,"The Commons","http://127.0.0.1:5500/grid-test.html");
    }
}

window.addEventListener('popstate', onPopState);
function onPopState(ev) {
   activeID = ev.state;
   console.log('activeID:'+activeID);
   popOut(activeID,0);
}

function popOut(activeID,call_from_page){
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);
    var active_element = document.getElementById(activeID+"-content");

    if(popout_container.contains(active_element)  && popout_state===1){
        if(call_from_page){
            history.pushState(activeID,"The Commons","http://127.0.0.1:5500/grid-test.html");
            console.log("push reset");
        }
        popout_state = 0; b
        var contentID = popout_container.firstChild.id;
        var activeID = contentID.split("-content").join("")
        var active_element = document.getElementById(contentID);
        var grid_container = document.getElementById(activeID);
        resetPopoutSize(contentID.split("-content").join(""));
        opacityToggle("1");
        setTimeout(function(){
            popout_container.style.display = "none";
            grid_container.appendChild(active_element);
            grid_container.style.visibility = "visible";
        },1000);
    }
    else{
        if(!popout_container.hasChildNodes() && popout_state===0){
            if(call_from_page){
                history.pushState(activeID,activeID,activeID);
                console.log("push popout");
            }
            popout_state = 1;
            resetPopoutSize(activeID);
            popout_container.style.display = "block";
            grid_container.style.visibility = "hidden";
            opacityToggle("0");
            popout_container.appendChild(active_element);
            setTimeout(function(){
                popout_container.style.width = document.getElementById("newsy-container").offsetWidth-20+"px";;
                popout_container.style.height = document.getElementById("newsy-container").offsetHeight-20+"px";
                popout_container.style.top = document.getElementById("newsy-container").offsetTop+10+"px";
                popout_container.style.left = "10px";
            },50);
            window.scrollTo(0, 0);
        }
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