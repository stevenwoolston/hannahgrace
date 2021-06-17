<?php
/*
@package Woolston Web Design Developer Plugin
*   Set the array of $this->Taxonomies for this loop to initiate
*   For example
**    if (class_exists('WWD_Custom_Taxonomy')) {
**        $wwd_custom_tax = new WWD_Custom_Taxonomy();
**        $wwd_custom_tax->Taxonomies = array('builder-component');
**        $wwd_custom_tax->init();
**    }
*
*   Based on https://pluginrepublic.com/adding-an-image-upload-field-to-categories/
*/

if (! defined('ABSPATH')) exit;  // if direct access 

class WWD_Custom_Taxonomy {
    public $Taxonomies = array();
    public function __construct() {
        //
    }
    
    /*
    * Initialize the class and start calling our hooks and filters
    * @since 1.0.0
    */
    public function init() {
        foreach($this->Taxonomies as $taxonomy) {
            add_action($taxonomy.'_add_form_fields', array ($this, 'add_category_image'), 10, 2);
            add_action('created_'.$taxonomy, array ($this, 'save_category_image'), 10, 2);
            add_action($taxonomy.'_edit_form_fields', array ($this, 'update_category_image'), 10, 2);
            add_action('edited_'.$taxonomy, array ($this, 'updated_category_image'), 10, 2);
        }
        //    add_action('category_add_form_fields', array ($this, 'add_category_image'), 10, 2);
        //    add_action('created_category', array ($this, 'save_category_image'), 10, 2);
        //    add_action('category_edit_form_fields', array ($this, 'update_category_image'), 10, 2);
        //    add_action('edited_category', array ($this, 'updated_category_image'), 10, 2);

        add_action('admin_enqueue_scripts', array($this, 'load_media'));
        add_action('admin_footer', array ($this, 'add_script'));
    }

    public function load_media() {
        wp_enqueue_media();
    }
    
    /*
    * Add a form field in the new category page
    * @since 1.0.0
    */
    public function add_category_image ($taxonomy) { ?>

        <div class="form-field term-group">
			<label for="category-excerpt"><?php _e('Excerpt', 'WWD'); ?></label>
			<textarea rows="2" id="category-excerpt" name="category-excerpt"></textarea>
		</div>
   
		<div class="form-field term-group">
			<label for="category-menu-order"><?php _e('Order', 'WWD'); ?></label>
			<input type="text" id="category-menu-order" name="category-menu-order" value="0">
		</div>

        <div class="form-field term-group">
            <label for="category-image-id"><?php _e('Featured Image', 'WWD'); ?></label>
            <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
            <div id="category-image-wrapper"></div>
            <p>
                <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'WWD'); ?>" />
                <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'WWD'); ?>" />
            </p>
        </div>
<?php
    }
    
    /*
    * Save the form field
    * @since 1.0.0
    */
    public function save_category_image($term_id, $tt_id) {
		if (isset($_POST['category-excerpt']) && '' !== $_POST['category-excerpt']){
			$category_excerpt = $_POST['category-excerpt'];
			add_term_meta($term_id, 'category-excerpt', $category_excerpt, true);
		}

		if (isset($_POST['category-menu-order']) && '' !== $_POST['category-menu-order']){
			$menu_order = $_POST['category-menu-order'];
			add_term_meta($term_id, 'category-menu-order', $menu_order, true);
		}

        if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']){
            $image = $_POST['category-image-id'];
            add_term_meta($term_id, 'category-image-id', $image, true);
        }
    }
    
    /*
    * Edit the form field
    * @since 1.0.0
    */
    public function update_category_image($term, $taxonomy) { ?>
		<tr class="form-field term-group-wrap">
			<th scope="row">
				<label for="category-excerpt"><?php _e('Excerpt', 'WWD'); ?></label>
			</th>
			<td>
				<?php $category_excerpt = get_term_meta ($term -> term_id, 'category-excerpt', true); ?>
				<textarea rows="2" id="category-excerpt" name="category-excerpt"><?php echo $category_excerpt; ?></textarea>
			</td>
		</tr>

		<tr class="form-field term-group-wrap">
			<th scope="row">
				<label for="category-menu-order"><?php _e('Order', 'WWD'); ?></label>
			</th>
			<td>
				<?php $menu_order = get_term_meta ($term -> term_id, 'category-menu-order', true); ?>
				<input type="text" id="category-menu-order" name="category-menu-order" value="<?php echo ($menu_order == '' ? 0 : $menu_order); ?>">
			</td>
		</tr>

        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="category-image-id"><?php _e('Featured Image', 'WWD'); ?></label>
            </th>
            <td>
                <?php $image_id = get_term_meta ($term->term_id, 'category-image-id', true); ?>
                <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
                <div id="category-image-wrapper">
                    <?php if ($image_id) { ?>
                    <?php echo wp_get_attachment_image ($image_id, 'thumbnail'); ?>
                    <?php } ?>
                </div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'WWD'); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'WWD'); ?>" />
                </p>
            </td>
        </tr>
<?php
    }

    /*
    * Update the form field value
    * @since 1.0.0
    */
    public function updated_category_image ($term_id, $tt_id) {
		if(isset($_POST['category-excerpt']) && '' !== $_POST['category-excerpt']){
			$category_excerpt = $_POST['category-excerpt'];
			update_term_meta ($term_id, 'category-excerpt', $category_excerpt);
		} else {
			update_term_meta ($term_id, 'category-excerpt', '');
		}

		if(isset($_POST['category-menu-order']) && '' !== $_POST['category-menu-order']){
			$menu_order = $_POST['category-menu-order'];
			update_term_meta ($term_id, 'category-menu-order', $menu_order);
		} else {
			update_term_meta ($term_id, 'category-menu-order', '');
        }
                
        if(isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']){
            $image = $_POST['category-image-id'];
            update_term_meta($term_id, 'category-image-id', $image);
        } else {
            update_term_meta($term_id, 'category-image-id', '');
        }
    }

    /*
    * Add script
    * @since 1.0.0
    */
    public function add_script() { ?>
        <script>
            jQuery(document).ready(function($) {
                function ct_media_upload(button_class) {
                    var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                    $('body').on('click', button_class, function(e) {
                        var button_id = '#'+$(this).attr('id');
                        var send_attachment_bkp = wp.media.editor.send.attachment;
                        var button = $(button_id);
                        _custom_media = true;

                        wp.media.editor.send.attachment = function(props, attachment) {
                            if (_custom_media) {
                                $('#category-image-id').val(attachment.id);
                                $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                                $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
                            } else {
                                return _orig_send_attachment.apply(button_id, [props, attachment]);
                            }
                        }

                        wp.media.editor.open(button);
                        return false;
                    });
                }
            
                ct_media_upload('.ct_tax_media_button.button'); 
                $('body').on('click','.ct_tax_media_remove',function() {
                    $('#category-image-id').val('');
                    $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                });
            
                // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
                $(document).ajaxComplete(function(event, xhr, settings) {
                    var queryStringArr = settings.data.split('&');
                    if ($.inArray('action=add-tag', queryStringArr) !== -1) {
                        var xml = xhr.responseXML;
                        $response = $(xml).find('term_id').text();
                        if ($response!="") {
                            // Clear the thumb image
                            $('#category-image-wrapper').html('');
                        }
                    }
                });
            });
        </script>
<?php 
    }
}
