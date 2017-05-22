
jQuery(function() {
	
	/* RETURN BROWSER DIMENSIONS */
	function getBrowserDimensions (reqDimension) {
	  switch(reqDimension)
	  {
	  case 'height':
		return window.innerHeight || document.documentElement.clientHeight;
		break;
	  case 'width':
		return window.innerWidth || document.documentElement.clientWidth;
		break;
	  default:
	  }	
	}
	
	/* UPDATE DIMENSIONS */
	function updateDimensions (){
		browserHeight = getBrowserDimensions('height');
		browserWidth = getBrowserDimensions('width');
	}
	
	/* SCROLLS TO TOP OF PAGE */
	function scrollToTop(){
		// jQuery("html, body").animate({ scrollTop: 0 }, homeSectionsSlideSpeed);
		TweenMax.to( window, homeSectionsSlideSpeed, {scrollTo:{y: 0}, ease:Power4.easeInOut});
	}
	
	
	
	// MENU TOGGLE
	var menuTimeout;
	jQuery(document).on('click','.dropdown-toggle', function(event){
		event.preventDefault();
		jQuery('#main-navigation').toggleClass('active');
	});

	
	jQuery(document).on('mouseenter','.dropdown-toggle',function(event){
		if ( getBrowserDimensions('width') > 767 ) {
			jQuery('#main-navigation').toggleClass('active');	
		}
	})
	jQuery(document).on('mouseleave','.dropdown-toggle, #main-navigation',function(event){
		if ( getBrowserDimensions('width') > 767 ) {
			setMenuTimeout();
		}
	})
	jQuery(document).on('mouseenter','#main-navigation',function(event){
		if ( getBrowserDimensions('width') > 767 ) {
			clearTimeout(menuTimeout);
		}
	})
	function setMenuTimeout(){
		menuTimeout = setTimeout( function(){
			jQuery('#main-navigation').toggleClass('active');
		}, 250 );

	}


	// HOME HEADER AD TOGGLE
	jQuery(document).on('click','.home-ad-toggle', function(event){
		event.preventDefault();
		var adHeight = jQuery('#expandable-ad').height();
		 jQuery('.header-home-ad-content').toggleClass('active');
		if ( jQuery('.expandable-area').height() > 0 ){
			jQuery('.expandable-area').height(0);
			jQuery('.header-home-ad-content .responsive-video-wrapper iframe').attr('src','');

		} else {
			jQuery('.expandable-area').height(adHeight);
			if ( jQuery('.header-home-ad-content .responsive-video-wrapper').length > 0  ) {
				var videoId = jQuery('.header-home-ad-content .responsive-video-wrapper').attr('data-id');
				var videoType = jQuery('.header-home-ad-content .responsive-video-wrapper').attr('data-type');

				if ( videoType =='youtube') {
					var iframeSrc = '//www.youtube.com/embed/'+videoId+'?autoplay=1&amp;autohide=1&amp;controls=2&amp;modestbranding=1&amp;showinfo=0';
				}
				if ( videoType =='vimeo') {
					var iframeSrc = 'http://player.vimeo.com/video/'+videoId+'?autoplay=1&autohide=1&amp;controls=2&amp;modestbranding=1&amp;showinfo=0';
				}
				jQuery('.header-home-ad-content .responsive-video-wrapper iframe').attr('src',iframeSrc);

			}
		}
	});	


	// PUSH MENU TOGGLE
	jQuery(document).on('click','.pushmenu-toggle', function(event){
		event.preventDefault();
		jQuery('body').toggleClass('pushed');
	});


	// TAG FILTER CLICK
	jQuery(document).on('click','.tag-list a', function(event){
		event.preventDefault();
		jQuery(this).toggleClass('active');

		parseActiveTags();
		
	});
 
	function parseActiveTags (){

		var activeTags = '';
		var activeTagCount = jQuery('.tag-list a.active').length;
		var activeTagIndex = 1;
		var catUrl = jQuery('.filters_wrapper').attr('data-category-url');

		// get all active tags
		jQuery('.tag-list a.active').each( function(){
			activeTags += jQuery(this).attr('data-tag');
			if( activeTagIndex < activeTagCount && activeTagIndex !== activeTagCount){
				activeTags += ','
			}
			activeTagIndex ++;
		});

		// append tag parameters to category url and navigate there
		document.location.href = catUrl+'?tag='+activeTags;

	}

	

	// SLIDERS: init if its being displayed and not initialized
	function manageSliders(){
		// console.log('manage sliders here!');
		// MAIN SLIDER: 
		if( jQuery('#main-slider').length >0 && jQuery('#main-slider').css('display') != 'none' && !jQuery('#main-slider').hasClass('init')  ){
			// console.log('main init');

			jQuery('.bxslider.single-slider').bxSlider({
				mode: 'fade',
				adaptiveHeight: true
			});

			jQuery('.bxslider.featured-posts-slider').bxSlider({
				mode: 'horizontal',
				adaptiveHeight: true,
				 onSliderLoad: function(){
			        $("#featured").css("visibility", "visible");
			      }
			});

			jQuery('#main-slider').addClass('init');
		}
		// MOBILE SLIDER
		if( jQuery('#swipe-slider').length >0 && jQuery('#swipe-slider').css('display')  != 'none' && !jQuery('#swipe-slider').hasClass('init')  ){
			console.log('swipe init');
		    Slider = jQuery('#swipe-slider').Swipe({  
		        auto: 8000,  
		        continuous: false,
		        disableScroll: true 
		    }).data('Swipe');

		    jQuery('#swipe-slider').addClass('init');
		}
	}


	/* LAUNCHES FACEBOOK POST POPUP */	
	jQuery(document).on('click','.post-to-facebook', function(e){
		e.preventDefault();

		// create parameters object, populate it link data
		var uiParameters = {};
		uiParameters.method ='feed';
		uiParameters.name = jQuery(this).attr('data-linkname');
		uiParameters.link = jQuery(this).attr('data-linkurl');
		if( jQuery(this).attr('data-picture') != '' ){
			uiParameters.picture = jQuery(this).attr('data-picture');
		}
		uiParameters.description = jQuery(this).attr('data-description');
		uiParameters.message ='';
		// launch facebook dialog
		FB.ui( uiParameters );
	});


	/* LAUNCHES TWITTER POST POPUP */
	jQuery(document).on('click','.tweet', function(e){
		e.preventDefault();
		var url = 'https://twitter.com/share?url'+jQuery(this).attr('data-url')+'&text='+jQuery(this).attr('data-text');
		newwindow=window.open(url,'name','height=420,width=548');
		if (window.focus) {newwindow.focus()}
		return false;
	});


	// WELCOME OVERLAY
	function welcomeOverlay () {

		if( jQuery('body.home').length > 0 ) {
			// assign cookie to variable
			var welcomeCookie = readCookie('welcomeCookie');
			
			// if no cookie found:
			if( !welcomeCookie ){
				// create cookie
				createCookie('welcomeCookie','set',7);
				// launch overlay
				jQuery('#welcome-overlay').addClass('visible');
				setTimeout( function(){
					jQuery('#welcome-overlay').addClass('active');
				}, 250);			
			}
		}
	}

	jQuery(document).on('click','.overlay-close', function(e){
		e.preventDefault();
		jQuery('.overlay').removeClass('active');
		setTimeout( function(){
			jQuery('.overlay').removeClass('visible');
		}, 750);
	});


	// COOKIE CODE
	function createCookie(name,value,days) {
	    if (days) {
	        var date = new Date();
	        date.setTime(date.getTime()+(days*24*60*60*1000));
	        var expires = "; expires="+date.toGMTString();
	    }
	    else var expires = "";
	    document.cookie = name+"="+value+expires+"; path=/";
	}
	function readCookie(name) {
	    var nameEQ = name + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0;i < ca.length;i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1,c.length);
	        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	    }
	    return null;
	}
	function eraseCookie(name) {
	    createCookie(name,"",-1);
	}

	// LANDING BG
	function landingBG() {
		if( jQuery('.landing-body').length > 0 ){

			// get window dimensions
			var windowWidth = getBrowserDimensions('width');
			var windowHeight = getBrowserDimensions('height');

			// get image data
			var landingBGWidth = jQuery('.landing-body').attr('data-width');
			var landingBGHeight = jQuery('.landing-body').attr('data-height');
			var landingBGProportion =  landingBGWidth / landingBGHeight;

			if( windowHeight > windowWidth ){
				// vertical aspect
				console.log('V');

				jQuery('.landing-body').css("background-size",""+(windowHeight * landingBGProportion)+"px "+windowHeight+"px");

			} else {
				// horizontal aspect
				console.log('H');

				finalWidth = windowWidth;
				finalHeight = windowWidth / landingBGProportion;

				if ( finalHeight < windowHeight ) {
						// console.log('will correct height');
						finalHeight = windowHeight;
						finalWidth = finalHeight * landingBGProportion;
					}
					jQuery('.landing-body').css("background-size",""+finalWidth+"px "+finalHeight+"px");
			}
		}
	}

	/* Search Form */
	jQuery(document).on('focus','.search-form', function(e){
		jQuery('#social-links').addClass('shift');
	});
	jQuery(document).on('blur','.search-form', function(e){
		jQuery('#social-links').removeClass('shift');
	});



	// Add classes for fixed elements to body
	function setBodyTopPadding(){
		// get header height
		var headerHeight = jQuery('header').height();
		// jQuery('body').css('padding-top', headerHeight+'px');

		if( scrollTopPosition > 50 ){
			jQuery('body').addClass('compact');
		} else {
			jQuery('body').removeClass('compact');
		}
	}


	/* ON INIT */
	manageSliders();
	welcomeOverlay();
	landingBG();
	jQuery(".fancybox").fancybox({
		padding: 0,
		fitToView: true
	});

	/* ON SCROLL */
	jQuery(window).scroll(function(){
		scrollTopPosition = jQuery(this).scrollTop();
		setBodyTopPadding();

	});	

	
	/* ON RESIZE */
	jQuery(window).bind('resize', function () {
		manageSliders();
		landingBG();
	});	
	




	// DISPLAY BROWSER DIMENSIONS TOP RIGHT. DELETE WHEN LIVE
	var displayViewportSize = false;
	if (displayViewportSize > 0){
	var MEASUREMENTS_ID = 'measurements'; // abstracted-out for convenience in renaming
	jQuery("body").append('<div id="'+MEASUREMENTS_ID+'"></div>');
	jQuery("#"+MEASUREMENTS_ID).css({
	    'position': 'fixed',
	    'top': '0',
	    'right': '0',
	    'background-color': 'rgba(0,0,0,.75)',
	    'color': 'white',
	    'padding': '4px',
	    'font-size': '11px',
	    'font-family': 'arial',
	    'opacity': '1',
	    'z-index': '1000'
	});
	getDimensions = function(){
	    // return jQuery(window).width() + ' (' + jQuery(document).width() + ') x ' + jQuery(window).height() + ' (' + jQuery(document).height() + ')';
	    return jQuery(window).width() + 'px x ' + jQuery(window).height() + 'px';
	}
	jQuery("#"+MEASUREMENTS_ID).text(getDimensions());
	jQuery(window).on("resize", function(){
	    jQuery("#"+MEASUREMENTS_ID).text(getDimensions());
	});
	}
	// END: DISPLAY BROWSER DIMENSIONS TOP RIGHT

	

	
});



      window.fbAsyncInit = function() {
        FB.init({
          appId      : '704521669613696',
          xfbml      : true,
          version    : 'v2.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));