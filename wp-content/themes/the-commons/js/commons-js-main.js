/* DEPLOY 2024-10-09 */
//menu image change
(function($) {
  // When the dropdown opens, seed the placeholder with the first item's thumbnail
  $(document).on('mouseenter', '.menu li.has-children', function() {
    var $ul = $(this).find('ul.has-image-placeholder');
    if ($ul.length) {
      var $firstItem = $ul.find('.has-hover-thumbnail').first();
      if ($firstItem.length) {
        var firstImage = $firstItem.attr('data-image');
        if (firstImage) {
          $ul.find('.image-placeholder').html('<img src="' + firstImage + '" />');
        }
      }
    }
  });

  // When hovering an item, swap to that item's thumbnail
  $(document).on('mouseenter', '.has-hover-thumbnail', function() {
    var image = $(this).attr('data-image');
    if (image) {
      $(this).parent().find('.image-placeholder').html('<img src="' + image + '" />');
    }
  });

  // On item mouseleave, do nothing — leave the last hovered image showing

  // When the mouse leaves the whole dropdown, clear the placeholder
  $(document).on('mouseleave', '.menu li.has-children', function() {
    $(this).find('.image-placeholder').html('');
  });
})(jQuery);

/* mobile menu event listeners, added to top because it wasn't firign lower - guessing there is a bug in your code somewhere... */
var menuItems = document.getElementsByClassName("has-children");
// var toggleActive = function() {
//     this.classList.toggle("is-active");
// };
// for (var i = 0; i < menuItems.length; i++) {
//     menuItems[i].addEventListener('click', toggleActive, false);
// }

for (let i = 0; i < menuItems.length; i++) {
    menuItems[i].addEventListener('click', function() {
      const clickedItem = this;
      
      if (clickedItem.classList.contains('is-active')) {
        // Just close the clicked item
        clickedItem.classList.remove('is-active');
      } else {
        // Check if another item is currently open
        let hasOpenItem = false;
        for (let j = 0; j < menuItems.length; j++) {
          if (j !== i && menuItems[j].classList.contains('is-active')) {
            hasOpenItem = true;
            menuItems[j].classList.remove('is-active');
          }
        }
        
        // If another item was open, wait for it to close before opening the new one
        if (hasOpenItem) {
          setTimeout(() => {
            clickedItem.classList.add('is-active');
          }, 200); // Slightly more than half the transition time
        } else {
          // No other item open, open immediately
          clickedItem.classList.add('is-active');
        }
      }
    });
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
    var flex_desktop_grid = document.getElementById("flex-desktop-grid");

    setPopoutSize(); 
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