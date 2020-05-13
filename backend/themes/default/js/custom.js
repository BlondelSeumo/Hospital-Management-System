
$(document).ready(function(){    
 jQuery.fn.liScroll = function(settings) {
  settings = jQuery.extend({
    travelocity: 0.02
    }, settings);   
    return this.each(function(){
        var $strip = jQuery(this);
        $strip.addClass("newsticker")
        var stripHeight = 1;
        $strip.find("li").each(function(i){
          stripHeight += jQuery(this, i).outerHeight(true); // thanks to Michael Haszprunar and Fabien Volpi
        });
        var $mask = $strip.wrap("<div class='mask'></div>");
        var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");               
        var containerHeight = $strip.parent().parent().height();  //a.k.a. 'mask' width   
        $strip.height(stripHeight);     
        var totalTravel = stripHeight;
        var defTiming = totalTravel/settings.travelocity; // thanks to Scott Waye   
        function scrollnews(spazio, tempo){
        $strip.animate({top: '-='+ spazio}, tempo, "linear", function(){$strip.css("top", containerHeight); scrollnews(totalTravel, defTiming);});
        }
        scrollnews(totalTravel, defTiming);       
        $strip.hover(function(){
        jQuery(this).stop();
        },
        function(){
        var offset = jQuery(this).offset();
        var residualSpace = offset.top + stripHeight;
        var residualTime = residualSpace/settings.travelocity;
        scrollnews(residualSpace, residualTime);
        });     
    }); 
};

$(function(){
    $("ul#ticker01").liScroll();
});
 });

 $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"]):not([data-gallery="example-gallery"])', function(event) {
                    event.preventDefault();
                    return $(this).fancyLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        },
            onNavigate: function(direction, itemIndex) {
                            if (window.console) {
                                return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                            }
            }
                    });
                });

                // disable wrapping
                $(document).on('click', '[data-toggle="lightbox"][data-gallery="example-gallery"]', function(event) {
                    event.preventDefault();
                    return $(this).fancyLightbox({
                        wrapping: false
                    });
                });

                //Programmatically call
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).fancyLightbox();
                });
                $('#open-youtube').click(function (e) {
                    e.preventDefault();
                    $(this).fancyLightbox();
                });

       
            });