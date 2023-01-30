function popOut(activeID){
    var popout_container = document.getElementById("popout-container");
    var grid_container = document.getElementById(activeID);
    var active_element = document.getElementById(activeID+"-content");

    if(popout_container.contains(active_element)){
        popout_container.style.width = grid_container.offsetWidth+"px";
        popout_container.style.height = grid_container.offsetHeight+"px";
        popout_container.style.top = grid_container.offsetTop+"px";
        popout_container.style.left = grid_container.offsetLeft+"px";
        opacityToggle("1");
        setTimeout(function(){
            popout_container.style.display = "none";
            grid_container.appendChild(active_element);
            grid_container.style.visibility = "visible";
        },1000);
    }

    else{
        if(popout_container.hasChildNodes()){
            console.log("check");
        }
        else{
            popout_container.style.width = grid_container.offsetWidth+"px";
            popout_container.style.height = grid_container.offsetHeight+"px";
            popout_container.style.top = grid_container.offsetTop+"px";
            popout_container.style.left = grid_container.offsetLeft+"px";
            popout_container.style.display = "block";
            grid_container.style.visibility = "hidden";
            opacityToggle("0");
            popout_container.appendChild(active_element);
            setTimeout(function(){
                popout_container.style.width = "100%";
                popout_container.style.height = document.getElementById("newsy-container").offsetHeight-20+"px";
                popout_container.style.top = "15vh";
                popout_container.style.left = "0px";
            },50);
            window.scrollTo(0, 0);
        }
    }
}

function opacityToggle(opacity_level){
    var grid = document.getElementById("newsy-container");
    grid.style.opacity = opacity_level;
}
