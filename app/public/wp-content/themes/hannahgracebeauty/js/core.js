$(function () {
	$("#booking-datepicker").datepicker({
        language: 'en-AU',
    }).on('changeDate', getBookings);

    // $.fn.datepicker.dates['en-AU'] = {
    //     days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    //     daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    //     daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
    //     months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    //     monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    //     today: "Today",
    //     clear: "Clear",
    //     format: "yyyy-M-dd",
    //     titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    //     weekStart: 0
    // };

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