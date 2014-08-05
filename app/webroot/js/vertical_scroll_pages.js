

function scrollVertical(pages){
	var current = 0;
	var complete = true;
	var winHeight = $(window).height();

	$(".fullheight").height(winHeight);

	$(window).scroll(function() {
		var scroll = $(window).scrollTop();
		if(scroll < 0) return;
		if(scroll > (pages.length-1)*winHeight) return;
		
		if(scroll > (current*winHeight) && complete){
			disable_scroll();
			if(current < pages.length){
				current += 1;
			}
			complete = false;
			$('html, body').animate({
				scrollTop: $("#"+current).offset().top
			}, 1000, function(){
				 setTimeout(function(){
				 	enable_scroll();
				 	complete = true;
				 }, 500);
			});
		}
		else if(scroll < (current*winHeight) && complete){
			disable_scroll();
			if(current > 0){
				current -= 1;
			}
			complete = false;
			$('html, body').animate({
				scrollTop: $("#"+current).offset().top
				}, 1000, function(){
					setTimeout(function(){
				 	enable_scroll();
				 	complete = true;
				 }, 500);
			});
		}
	});
	
	$(window).resize(function(){
		winHeight = $(window).height();
		$(".fullheight").height(winHeight);
		window.scrollTo(0,current*winHeight);
	});
}

// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = [37, 38, 39, 40];

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
	  e.preventDefault();
  e.returnValue = false;  
}

function keydown(e) {
	for (var i = keys.length; i--;) {
		if (e.keyCode === keys[i]) {
			preventDefault(e);
			return;
		}
	}
}

function wheel(e) {
  preventDefault(e);
}

function disable_scroll() {
  if (window.addEventListener) {
	  window.addEventListener('DOMMouseScroll', wheel, false);
  }
  window.onmousewheel = document.onmousewheel = wheel;
  document.onkeydown = keydown;
}

function enable_scroll() {
	if (window.removeEventListener) {
		window.removeEventListener('DOMMouseScroll', wheel, false);
	}
	window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
}