function aboutUsPop(){
    var element = document.getElementById("about-us");
    var features = document.getElementById("features");
    var blog = document.getElementById("blog");
    var get_involved = document.getElementById("get-involved");
    
    if(element.classList.contains("about-us-full")){
        element.classList.remove("about-us-full");
        opacityToggle("about-us","1");
        setTimeout(displayToggle(),500,"about-us","block");
    }
    
    else{
        element.classList.add("about-us-full");
        opacityToggle("about-us","0");
        setTimeout(displayToggle(),500,"about-us","none");
    }
}

function displayToggle(active_id,display_mode){
    var element = document.getElementById("about-us");
    var features = document.getElementById("features");
    var blog = document.getElementById("blog");
    var get_involved = document.getElementById("get-involved");

    if(active_id==="about-us"){
        console.log(display_mode);
        features.style.display = display_mode;
        blog.style.display = display_mode; 
        get_involved.style.display = display_mode;
    }
}

function opacityToggle(active_id,opacity_level){
    var element = document.getElementById("about-us");
    var features = document.getElementById("features");
    var blog = document.getElementById("blog");
    var get_involved = document.getElementById("get-involved");

    if(active_id==="about-us"){
        console.log(opacity_level);
        features.style.opacity = opacity_level;
        blog.style.opacity = opacity_level; 
        get_involved.style.opacity = opacity_level;
    }
}