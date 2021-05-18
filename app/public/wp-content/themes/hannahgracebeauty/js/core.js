
$(function () {
    
    var $details = $("#menu-primary"),
        logoTippingPoint = 30;

    $(window).on("scroll", function() {
        setScrollPosition();
    });    

    function setScrollPosition() {
        if ($(document).scrollTop() > logoTippingPoint) {
            $details.addClass("docked");
        } else {
            $details.removeClass("docked");
        }
    }

    setScrollPosition();

    $("#md_accordion").on('show.bs.collapse', function(e) {
        $(e.target).closest(".card").addClass("open");
    });

    $("#md_accordion").on('hide.bs.collapse', function(e) {
        $(e.target).closest(".card").removeClass("open");
    });

    $(".las.la-search").popover({
        placement: 'bottom',
        sanitize: false,
        container: 'body',
        content: function() {
            return $("#popover-search-form-container").html();
        },
        html: true
    }).on('shown.bs.popover', function() {
        $("#s").focus();
    });

});


var scroll = window.requestAnimationFrame ||
             // IE Fallback
             function(callback){ window.setTimeout(callback, 1000/60)};

function loopScissors() {
    var scissors = $(".md-floating-scissors");
    if (isElementInViewport(scissors)) {
        scissors.addClass('is-visible');
    } else {
        scissors.removeClass('is-visible');
    }
    scroll(loopScissors);
}
// loopScissors();

// Helper function from: http://stackoverflow.com/a/7557433/274826
function isElementInViewport(el) {
    // special bonus for those using jQuery
    if (typeof jQuery === "function" && el instanceof jQuery) {
      el = el[0];
    }
    var rect = el.getBoundingClientRect();
    return (
      (rect.top <= 0
        && rect.bottom >= 0)
      ||
      (rect.bottom >= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.top <= (window.innerHeight || document.documentElement.clientHeight))
      ||
      (rect.top >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight))
    );
  }