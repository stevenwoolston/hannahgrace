<?php
class Timely_Booking_Button_Widget extends WP_Widget
{


    // __construct() function
    //
    // Sets up the widget in the WP Admin area so
    // that it has it's own unique identifier and
    // a title and description.
    //
    // The first parameter passed to parent::__construct()
    // is a string representing the id of this widget
    //
    // The second parameter is a description, localized
    // with the __() method.
    //
    // The third parameter is an array of options, setting
    // the description in the admin area, localized with
    // the __() method.
    function __construct()
    {
        parent::__construct(
            'tbb-widget-new',
            __('Timely Booking Button New', 'Timely'),
            array(
                'description' => __('Add a booking button for your Timely account', 'Timely'),
            )
        );
    }


    // widget() function
    //
    // this is what will be shown on the actual
    // wordpress site. This is where the magic
    // happens.
    //
    // First, set some variables to whatever data
    // is available through the $instance (initially
    // set through the form() function.)
    //
    // Next, echo out any 'before_widget' data that
    // may be set (configurable in a theme)
    //
    // Next, check for a title, if there is one set
    // then echo it out, surrounded by any 'before_title'
    // and 'after_title' data that may be set (configurable in a theme)
    //
    // Then, echo out any other data the widget uses. In
    // this example it's just the $my_widget_content data.
    //
    // Finally, echo out any 'after_widget' data which may
    // be set (configurable in a theme)
    public function widget($args, $instance)
    {
        $options = get_option('tbb_options');
        echo $args['before_widget']; ?>

        <div style='padding: 20px 0;'>
            <script id="timelyScript" src="//book.gettimely.com/widget/book-button-v1.5.js"></script>
            <script>
                var timelyButton = new timelyButton("<?php echo $options['tbb_account']; ?>"
                    <?php echo ($options['tbb_field_pill'] == 'dark' ? ', { style : "dark" }' : ''); ?>);
            </script>
        </div>

        <?php
        echo $args['after_widget'];
    }


    // form() function
    //
    // This builds the form in the WP Admin area
    // so that content editors can update the
    // widget data.
    //
    // Here, we first check if any of the data has
    // already been set. If not, we set it to
    // some default value(s). After that we assign
    // it to a variable (which will be used in form.php)
    //
    // Next, we include the form used to enter the data.
    // See form.php for details on that.
    public function form($instance)
    { ?>
        <p>There is no content for this widget</p>
<?php
    }


    // update() function
    //
    // This function is responsible for updating
    // and instance of a widget when a content
    // editor clicks save.
    //
    // The $intance variable is first cleared,
    // then each bit of data stored is updated
    // with it's new value.
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        // $instance['title'] = strip_tags($new_instance['title']);
        // $instance['my_widget_content'] = strip_tags($new_instance['my_widget_content']);
        return $instance;
    }
} // Class My_Widget ends here


// Register and load the widget
function load_timely_booking_button_widget()
{
    register_widget('Timely_Booking_Button_Widget');
}
add_action('widgets_init', 'load_timely_booking_button_widget');
