<div class="wrap wwd-plugin-options">
    <h1>Woolston Web Design Theme Settings</h1>
    <?php settings_errors(); ?>

    <form action="options.php" method="post">
    <?php settings_fields('wwd-plugin-options'); ?>

        <h2 class="wwd-nav-tab-wrapper">
            <a href="#tab-1" class="nav-tab nav-tab-active">Manage Settings</a>
            <a href="#tab-2" class="nav-tab">SEO</a>
            <a href="#tab-4" class="nav-tab">Social Media</a>
            <a href="#tab-theme" class="nav-tab">Theme Options</a>
            <a href="#tab-3" class="nav-tab">About</a>
        </h2>
    
        <div id="tab-1" class="tab-pane active">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="wwd-plugin[use_custom_header]">Use Custom Header:</label>
                    </th>
                    <td>
                        <select name="wwd-plugin[use_custom_header]">
                            <option value="0" <?php echo ($options['use_custom_header'] == 0 ? "selected" : ""); ?>>No</option>
                            <option value="1" <?php echo ($options['use_custom_header'] == 1 ? "selected" : ""); ?>>Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwd-plugin[use_custom_background]">Use Custom Background:</label>
                    </th>
                    <td>
                        <select name="wwd-plugin[use_custom_background]">
                            <option value="0" <?php echo ($options['use_custom_background'] == 0 ? "selected" : ""); ?>>No</option>
                            <option value="1" <?php echo ($options['use_custom_background'] == 1 ? "selected" : ""); ?>>Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwd-plugin[bootstrap_carousel]">Use Custom Carousel:</label>
                    </th>
                    <td>
                        <select name="wwd-plugin[bootstrap_carousel]">
                            <option value="0" <?php echo ($options['bootstrap_carousel'] == 0 ? "selected" : ""); ?>>No</option>
                            <option value="1" <?php echo ($options['bootstrap_carousel'] == 1 ? "selected" : ""); ?>>Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwd-plugin[google_map_embed]">Google Maps Embed Code:</label>
                    </th>
                    <td>
                        <textarea id="google_map_embed" rows="5" style="width: 100%;" 
                            name="wwd-plugin[google_map_embed]"><?php echo $options['google_map_embed']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwd-plugin[carousel_speed]">Carousel Slide Timer (secs):</label>
                    </th>
                    <td>
                        <input type="text" id="google_analytics_tracking_code" size="10" 
                            name="wwd-plugin[carousel_speed]" 
                            value="<?php echo $options['carousel_speed']; ?>" />
                    </td>
                </tr>
            </table>
        </div>

        <div id="tab-2" class="tab-pane">

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="meta_description">Meta Description <small>(155 chars)</small>:</label>
                    </th>
                    <td>
                        <input type="text" size="155" name="wwd-plugin[seo][meta_description]" maxlength="155" 
                            style="width: 100%;"
                            value="<?php echo $options['seo']['meta_description']; ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="meta_description">Google Analytics Tracking Code:</label>
                    </th>
                    <td>
                        <input type="text" id="google_analytics_tracking_code" size="50" 
                            name="wwd-plugin[seo][google_analytics_tracking_code]" 
                            value="<?php echo $options['seo']['google_analytics_tracking_code']; ?>" />
                    </td>
                </tr>
            </table>
        </div>

        <div id="tab-3" class="tab-pane">
            <h2>About</h2>
            Steven Woolston<br />
            Woolston Web Design<br />
            Contact: 0407 077 508<br />
            Email: <a href="mailto:design@woolston.comm.au">design@woolston.comm.au</a>
        </div>

        <div id="tab-theme" class="tab-pane">
            <h2>Theme Options</h2>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label>Post Formats</label>
                    </th>
                    <td>
<?php
    $formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat');
    $output = '';
    foreach($formats as $format) {
        $checked = (@$options['theme_options']['post_formats'][$format] == 1 ? 'checked' : '');
?>
        <label><input type="checkbox" <?php echo $checked; ?> name="wwd-plugin[theme_options][post_formats][<?php echo $format; ?>]" 
            value="1"><?php echo $format; ?></label>
        <br />
<?php    
    }    
?>
                    </td>
                </tr>
            </table>
        </div>

        <div id="tab-4" class="tab-pane">

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="custom_carousel">Facebook URL:</label>
                    </th>
                    <td>
                        <input type="text" id="facebook_url" size="50" name="wwd-plugin[social_media][facebook_url]" 
                        value="<?php echo $options['social_media']['facebook_url']; ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="twitter_url">Twitter URL:</label>
                    </th>
                    <td>
                        <input type="text" id="twitter_url" size="50" name="wwd-plugin[social_media][twitter_url]" 
                        value="<?php echo $options['social_media']['twitter_url']; ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="linkedin_url">Linkedin URL:</label>
                    </th>
                    <td>
                        <input type="text" id="linkedin_url" size="50" name="wwd-plugin[social_media][linkedin_url]" 
                        value="<?php echo $options['social_media']['linkedin_url']; ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="instagram_url">Instagram URL:</label>
                    </th>
                    <td>
                        <input type="text" id="pinterest_url" size="50" name="wwd-plugin[social_media][pinterest_url]" 
                        value="<?php echo $options['social_media']['pinterest_url']; ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pinterest_url">Pinterest URL:</label>
                    </th>
                    <td>
                        <input type="text" id="pinterest_url" size="50" name="wwd-plugin[social_media][pinterest_url]" 
                        value="<?php echo $options['social_media']['pinterest_url']; ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="youtube_url">Youtube URL:</label>
                    </th>
                    <td>
                        <input type="text" id="youtube_url" size="50" name="wwd-plugin[social_media][youtube_url]" 
                        value="<?php echo $options['social_media']['youtube_url']; ?>" />
                    </td>
                </tr>
            </table>
        </div>

        <?php submit_button();  ?>
    </form>    

</div>