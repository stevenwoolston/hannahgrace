<?php
class Timely_Plugin_Admin
    {
        public function __construct() {

          add_action('admin_menu', array($this, 'admin_menu'));
          add_action('admin_init', array($this, 'settings_init'));
          add_action( 'admin_notices', array($this, 'check_account') );

          add_filter("plugin_action_links_timely-booking-button/timely-booking-button.php", array($this, 'add_settings_link'));
        }

        public function add_settings_link($links) {
          $settings_url = admin_url('options-general.php?page=timely-booking-buttons');
          $settings_link = '<a href="'.$settings_url.'">Settings</a>';
          array_push($links, $settings_link);
          return $links;
        }

        public function check_account() {
          $options = get_option('tbb_options');
          if ($options['tbb_account']) {
            $isvalid = false;

            $url = "https://app.gettimely.com/Register/GetSubdomainAvailability/" . $options['tbb_account'];
            $response = wp_remote_get($url);
            if ( !is_wp_error( $response ) ) {
              $body = wp_remote_retrieve_body( $response );
              $isvalid = !($body == 'true');
            }

            if (!$isvalid) {
              add_settings_error('tbb_messages', 'acctInvalid', __('The Account name you added was not one in our systems. Please check your Account name again.', 'Timely'), 'error');
            }
          }
        }

        public function settings_init() {
          // Register a new setting for "Timely" page.
          register_setting( 'Timely', 'tbb_options', array($this, 'validate_settings') );

          // Register a new section in the "Timely" page.
          add_settings_section( 'tbb_account_section', '', null, 'Timely' );

          add_settings_section( 'tbb_account_button', 'Button Style', null, 'Timely' );

          add_settings_section( 'tbb_account_widget', 'Widget Style', null, 'Timely' );


          // Register a new field in the "tbb_account_section" section, inside the "Timely" page.
          add_settings_field(
              'tbb_account', // As of WP 4.6 this value is used only internally.
              __( 'Account name', 'Timely' ),
              array( $this, 'tbb_account_cb'),
              'Timely',
              'tbb_account_section',
              array(
                'label_for'         => 'tbb_account',
                'class'             => 'tbb_row',
              )
          );

          // Register a new field in the "tbb_account_button" section, inside the "Timely" page.
          add_settings_field(
              'tbb_field_pill', // As of WP 4.6 this value is used only internally.
              __( 'Button colour', 'Timely' ),
              array( $this, 'tbb_button_color_cb'),
              'Timely',
              'tbb_account_button',
              array(
                'label_for'         => 'tbb_field_pill',
                'class'             => 'tbb_row',
              )
          );

          add_settings_field(
              'tbb_field_width', // As of WP 4.6 this value is used only internally.
              __( 'Max Width', 'Timely' ),
              array( $this, 'tbb_width_cb'),
              'Timely',
              'tbb_account_widget',
              array(
                'label_for'         => 'tbb_width_pill',
                'class'             => 'tbb_row',
              )
          );

          add_settings_field(
              'tbb_field_height', // As of WP 4.6 this value is used only internally.
              __( 'Height', 'Timely' ),
              array( $this, 'tbb_height_cb'),
              'Timely',
              'tbb_account_widget',
              array(
                'label_for'         => 'tbb_height_pill',
                'class'             => 'tbb_row',
              )
          );

          add_settings_field(
              'tbb_field_responsive', // As of WP 4.6 this value is used only internally.
              __( 'Responsive', 'Timely' ),
              array( $this, 'tbb_responsive_cb'),
              'Timely',
              'tbb_account_widget',
              array(
                'label_for'         => 'tbb_responsive_pill',
                'class'             => 'tbb_row',
              )
          );
        }

        function validate_settings( $input) {
          $output = array();

          foreach($input as $key => $value) {
            if (isset($input[$key])) {
              $output[$key] = strip_tags(stripslashes($input[$key]));
            }
          }

          return apply_filters('validate_settings', $output, $input);
        }

        function tbb_responsive_cb ( $args ) {
              // Get the value of the setting we've registered with register_setting()
            $options = get_option( 'tbb_options' );
            $errors = get_settings_errors('tbb_messages');
            $acctInvalid = false;
            foreach((array)$errors as $error) {
              if ($error['code'] == 'acctInvalid') {
                $acctInvalid = true;
              }
            }
            ?>
            <input type="checkbox"
             id="<?php echo esc_attr( $args['label_for'] ); ?>"
             name="tbb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
             <?php checked($options[$args['label_for']], 'on', true) ?> />
            <p class="description">
              <?php _e( 'Stretch to 100% width', 'Timely' ); ?>
            </p>
            <?php if ( !empty($options['tbb_account']) && !$acctInvalid ) : ?>
              <hr />

              <p clas="description">
                <strong>Preview</strong>
                <div>
                  <iframe src="//<?php echo $options['tbb_account']; ?>.gettimely.com/book/embed" scrolling="no" id="timelyWidget" style="<?php ($options['tbb_responsive_pill'] == 'on' ? "margin: 0 auto; display: block; width: 100%; max-" : "") ?>width: <?php echo $options['tbb_width_pill']; ?>px; height: <?php echo $options['tbb_height_pill']; ?>px; border: 1px solid #4f606b;"></iframe>
                </div>
              </p>
            <?php endif;

        }

        function tbb_height_cb ( $args ) {
            // Get the value of the setting we've registered with register_setting()
            $options = get_option( 'tbb_options' );
            ?>
            <input type="text"
             id="<?php echo esc_attr( $args['label_for'] ); ?>"
             name="tbb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
             value="<?php echo $options[$args['label_for']] ?>" />
            <?php
        }

        function tbb_width_cb ( $args ) {
            // Get the value of the setting we've registered with register_setting()
            $options = get_option( 'tbb_options' );
            ?>
            <input type="text"
             id="<?php echo esc_attr( $args['label_for'] ); ?>"
             name="tbb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
             value="<?php echo $options[$args['label_for']] ?>" />
            <?php
        }

        function tbb_account_cb ( $args ) {
            // Get the value of the setting we've registered with register_setting()
            $options = get_option( 'tbb_options' );
            ?>
            <input type="text"
             id="<?php echo esc_attr( $args['label_for'] ); ?>"
             name="tbb_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
             value="<?php echo $options[$args['label_for']] ?>" />

            <p class="description">
              <?php _e( 'This is the name of your mini website or private address that you chose when setting up your Timely account. If you are not sure what this should be click <a target="_blank" rel="noopener noreferrer href="https://app.gettimely.com/Settings/BusinessBookings">here</a> to login to your Timely account and check the value.', 'Timely' ); ?>
            </p>
            <?php
        }

        function tbb_button_color_cb( $args ) {
            // Get the value of the setting we've registered with register_setting()
            $options = get_option( 'tbb_options' );
            ?>
            <select
                id="<?php echo esc_attr( $args['label_for'] ); ?>"
                name="tbb_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
                <option value="light" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'light', false ) ) : ( '' ); ?>>
                    <?php esc_html_e( 'Light', 'Timely' ); ?>
                </option>
                <option value="dark" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'dark', false ) ) : ( '' ); ?>>
                    <?php esc_html_e( 'Dark', 'Timely' ); ?>
                </option>
            </select>
            <p class="description">
            <?php if (!empty($options[ $args['label_for'] ])) : ?>
              <img src="http://book.gettimely.com/images/book-buttons//button_<?php echo $options[ $args['label_for'] ] ?>@2x.png" />
            </p>
            <?php
            endif;
        }

        public static function admin_menu() {
          add_options_page(
            'Timely Booking Widget Options',
            'Timely',
            'manage_options',
            'timely-booking-buttons',
            'timely_admin_setting_page'
          );
        }


    }
    function timely_admin_setting_page() {
      // check user capabilities
      if ( ! current_user_can( 'manage_options' ) ) {
          return;
      }

      // show error/update messages
      // settings_errors( 'tbb_messages' );
      ?>
      <div class="wrap">
          <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
          <form action="options.php" method="post">
              <?php
              // output security fields for the registered setting "wporg"
              settings_fields( 'Timely' );
              // output setting sections and their fields
              // (sections are registered for "wporg", each field is registered to a specific section)
              do_settings_sections( 'Timely' );
              // output save settings button
              submit_button( 'Save Settings' );
              ?>
          </form>
      </div>
      <?php
    }
  new Timely_Plugin_Admin();