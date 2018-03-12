/*
    Education Park Theme by Yudlee Themes
    https:/yudleethemes.co/
*/
$=jQuery.noConflict();
jQuery(document).ready(function($) {

    // 1. Responsive Helper's Function
    function checkWindowSize() {
        if ( $(window).width() > 767) {
            $('body').addClass('cpm-desktop');
            $('body').removeClass('cpm-mobile');

        }
        else {
            $('body').removeClass('cpm-desktop');
            $('body').addClass('cpm-mobile');
        }
    }
    // 2. Back to top button Function
    function cpScrollTop(){
        // browser window scroll (in pixels) after which the "back to top" link is shown
        var cpTopOffset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //grab the "back to top" link
        $back_to_top = $('.cp-top');
        //hide or show the "back to top" link
        $(window).scroll(function(){
            ( $(this).scrollTop() > cpTopOffset ) ? $back_to_top.addClass('cp-is-visible') : $back_to_top.removeClass('cp-is-visible cp-fade-out');
            if( $(this).scrollTop() > offset_opacity ) {
                $back_to_top.addClass('cp-fade-out');
            }
        });
        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });
    }

    $('.post-format-gallery').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        autoplay: true,
        arrows: true
    });

    // 3. Slick Js Initiated
    function slickCall(){
        jQuery(".slick-slider").slick({
            dots: true,
            arrow: true,
            slidesToScroll: 1,
            slidesToShow: 1,
            autoplay: false,
            autoplaySpeed: 5000,
            lazyLoad: 'ondemand'
        });
    }

    //4. Responsive Iframes
    function noScrollGMap(){
        var videoSelectors = [
            'iframe[src*="google.com/maps"]'
        ];
        var allVideos = videoSelectors.join( ',' );
        $( allVideos ).wrap( '<span class="map-container" />' );
    }

    function responsiveIframe(){
        var videoSelectors = [
        'iframe[src*="player.vimeo.com"]',
        'iframe[src*="youtube.com"]',
        'iframe[src*="youtube-nocookie.com"]',
        'iframe[src*="kickstarter.com"][src*="video.html"]',
        'iframe[src*="screenr.com"]',
        'iframe[src*="blip.tv"]',
        'iframe[src*="dailymotion.com"]',
        'iframe[src*="viddler.com"]',
        'iframe[src*="qik.com"]',
        'iframe[src*="revision3.com"]',
        'iframe[src*="hulu.com"]',
        'iframe[src*="funnyordie.com"]',
        'iframe[src*="flickr.com"]',
        'embed[src*="v.wordpress.com"]'
        // add more selectors here
    ];

    var allVideos = videoSelectors.join( ',' );

    $( allVideos ).wrap( '<span class="media-holder" />' ); // wrap them all!
    }

    // 5. Extend Bootstrap Navigation [Adding the hover effects]
    function extendBootstrapNav() {
        jQuery(".main-navigation .dropdown").hover(
        function() {
            $(this).children('.dropdown-menu').stop( true, true ).fadeIn("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");
        },
        function() {
            $(this).children('.dropdown-menu').stop( true, true ).fadeOut("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");
        });
    }

    // If menu exceeds the wrapper
    function menuExceed(){
        var navheight = jQuery('#navbar-collapse-main').outerHeight();
        if(navheight > 140){
            jQuery('#site-navigation').addClass('menuexceeds');
        }
        else{
            jQuery('#site-navigation').removeClass('menuexceeds');
        }
    }

    // 8. Calling all the Functions
        checkWindowSize();
        cpScrollTop();
        extendBootstrapNav();
        sideBarHeight();
        slickCall();
        menuExceed();

        noScrollGMap();
        responsiveIframe();

    // 9. Resize Function
    $( window ).resize(function() {
        checkWindowSize();
        sideBarHeight();
        footerBarHeight();
        menuExceed();
    });

    // 10. Window Scroll Function
    $(window).scroll(function() {
        sideBarHeight();
        footerBarHeight();
    });

    // No scroll
    jQuery('.map-container iframe').addClass('scrolloff'); // set the pointer events to none on doc ready

    jQuery('.map-container').on('click', function () {
        jQuery('.map-container iframe').removeClass('scrolloff'); // set the pointer events true on click
    });

    jQuery(".map-container iframe").mouseleave(function () {
        jQuery('.map-container iframe').addClass('scrolloff'); // set the pointer events to none when mouse leaves the map area
    });


    jQuery('#themenu').removeClass('hide');
    jQuery("#themenu").mmenu({
        offCanvas: {
           position  : "right",
        },
        extensions: ["effect-slide-menu", "effect-slide-listitems"],
        dragOpen: {
           open: true
        },
        // configuration
        classNames: {
            fixedElements: {
               fixed: "adminbar"
            }
        }
    });

    var api = $("#themenu").data( "mmenu" );
    api.bind( "opening", function( $panel ) {
        jQuery('#hambar').addClass('open');
    });
    api.bind( "opened", function( $panel ) {
        $('.slick-slider').slick('setPosition');
        console.log( "This panel is now opened:");
        jQuery('#hambar').addClass('open');
    });
    api.bind( "closed", function( $panel ) {
        jQuery('#hambar').removeClass('open');
    });

});

// 10. Window load Functions
jQuery(window).load(function() {
    setTimeout(function(){
        sideBarHeight();
        footerBarHeight();
    }, 100);
});

// 7. Set the sidebar border equal to the contentwrap
function sideBarHeight(){
    var contentHeight = jQuery('#content-wrap').height() -  jQuery('.breadcrumbs').height();
    jQuery('head').append('<style>#primary:before{height:'+contentHeight+'px;}</style>');
}
function footerBarHeight(){
    var footcontentHeight = jQuery('.footer-widget').height();
    jQuery('head').append('<style>.footer-widget .foot-bor:before{height:'+footcontentHeight+'px;}</style>');
}

