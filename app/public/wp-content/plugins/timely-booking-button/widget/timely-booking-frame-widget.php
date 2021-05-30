<?php
class Timely_Booking_Frame_Widget extends WP_Widget
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
            'tbw-widget-new',
            __('Timely Booking Frame New', 'Timely'),
            array(
                'description' => __('Add a booking frame for your Timely account', 'Timely'),
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

        if ($options['tbb_account'] != "") {
            if (is_array($args)) {
                extract($args);
            }

            if (isset($before_widget)) {
                echo $before_widget;
            } ?>
            <iframe src="//<?php echo $options['tbb_account']; ?>.gettimely.com/book/embed" scrolling="no" id="timelyWidget" style="<?php echo ($options['tbb_responsive_pill'] ? "margin: 0 auto; display: block; width: 100%; max-" : "") ?>width: <?php echo $options['tbb_width_pill']; ?>px; height: <?php echo $options['tbb_height_pill']; ?>px; border: 1px solid #4f606b;"></iframe>
            <?php
            if (isset($after_widget)) {
                echo $after_widget;
            }
        }
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
function load_timely_booking_frame_widget()
{
    register_widget('Timely_Booking_Frame_Widget');
}
add_action('widgets_init', 'load_timely_booking_frame_widget');
