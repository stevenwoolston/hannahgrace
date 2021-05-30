jQuery(function ($) {

    $(".single_add_to_cart_button.button.alt").on("click", function(e) {
        var $bookingTime = $("input[name=booking-time]").val();
        if ($bookingTime == '00:00') {
            alert('You must select a booking first');
            return false;
        }
        return true;
    });

    function getBookings() {
        var selectedDate = $("#booking-datepicker").val();
        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            dataType: "json", // add data type
            data: { action: 'get_ajax_posts', bookingDate: selectedDate },
            success: function( response ) {
                $.each( response, function( key, value ) {
                    console.log( key, value ); // that's the posts data.
                } );
            }
        });
    }

});