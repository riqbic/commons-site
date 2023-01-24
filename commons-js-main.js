function aboutUsPop(){
    var element = document.getElementById("about-us");
    if(element.classList.incudes("about-us-full")){
        element.classList.remove("about-us-full");
    }
    else{
    element.classList.add("about-us-full");
    }
}