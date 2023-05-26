<?php
/*
Plugin Name: Easy Bookings
Plugin URI: https://github.com/MuhammadUsman0304/wp-bookings
Description: ​A simple and fast plugin to add booking functionalities in your WordPress website, with fully customizable UI, add a floating icon at the bottom of your website, and you can add forms, links etc
Version: 1.0
Author: Muhammad Usman
Author URI: https://www.linkedin.com/in/muhammad-usman-b3439218b/
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


defined('ABSPATH') || die('you are not smart enough');
// Enqueue necessary CSS and JavaScript files
function dd_devdose_wp_chat_enqueue_scripts()
{
    wp_enqueue_style('dd-wp-chat-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('dd-wp-chat-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'dd_devdose_wp_chat_enqueue_scripts');

// Output the HTML for the icon
function dd_devdoes_wp_chat_output()
{
    // Retrieve user settings from the database
    $fontsize = get_option('dd_wp_chat_fontsize');
    $width = get_option('dd_wp_chat_width');
    $height = get_option('dd_wp_chat_height');
    $background_color = get_option('dd_wp_chat_background_color');
    $font_color = get_option('dd_wp_chat_font_color');
    $button_color = get_option('dd_wp_chat_button_color');
    $user_background_color = get_option('dd_wp_chat_user_background_color');
    $button1_label = get_option('dd_wp_chat_button1_label');
    $button1_link = get_option('dd_wp_chat_button1_link');
    $button2_label = get_option('dd_wp_chat_button2_label');
    $button2_link = get_option('dd_wp_chat_button2_link');
    $button3_label = get_option('dd_wp_chat_button3_label');
    $button3_link = get_option('dd_wp_chat_button3_link');

    // Output the HTML for the icon
    echo '<div class="dd-wp-chat-icon">';
    echo '<img src="' . get_option('dd_wp_chat_icon_url') . '" />';
    echo '</div>';

    // Output the HTML for the popup container
    echo '<div class="dd-wp-chat-popup" style="background-color:' . $background_color . '; width:' . $width . '; height:' . $height . '; font-size:' . $fontsize . '; color:' . $font_color . ';">';

    echo '<div class="card">';
    echo '<div class="card-header">';
    echo '<h4 style="color: ' . $font_color . '">How We Can Help You?</h4>';
    echo '<p style="color: ' . $font_color . '">choose from the following options</p>';
    echo '</div>'; // card header close
    // Output the HTML for the buttons
    echo '<div class="dd-wp-chat-buttons">';
    echo '<a href="' . $button1_link . '" id="button1"  class="dd-wp-chat-button" style="background-color:' . $button_color . ';color:' . $font_color . ';">' . $button1_label . '</a>';
    echo '<a href="' . $button2_link . '" id="button2" class="dd-wp-chat-button" style="background-color:' . $button_color . ';color:' . $font_color . ';">' . $button2_label . '</a>';
    echo '<a href="' . $button3_link . '" id="button3" class="dd-wp-chat-button" style="background-color:' . $button_color . ';color:' . $font_color . ';">' . $button3_label . '</a>';
    echo '</div>';
    echo "</div>"; //close card
    // Close the popup container
    echo '</div>';
}

add_action('wp_footer', 'dd_devdoes_wp_chat_output');

register_activation_hook(__FILE__, function () {
    // Register the settings for the plugin
    function dd_devdoes_wp_chat_register_settings()
    {
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_fontsize');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_width');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_height');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_background_color');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_font_color');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_textfield_height');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_textfield_background');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button_color');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_user_background_color');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_icon_type');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_icon_url');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button1_label');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button1_link');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button2_label');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button2_link');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button3_label');
        register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button3_link');



        // Set default icon URL if it's not set
        $default_icon_url = plugin_dir_url(__FILE__) . 'robot.png';
        if (!get_option('dd_wp_chat_icon_url')) {
            update_option('dd_wp_chat_icon_url', $default_icon_url);
        }

        if (isset($_FILES['dd_wp_chat_custom_icon']) && $_FILES['dd_wp_chat_custom_icon']['error'] == 0) {
            if ($_FILES['dd_wp_chat_custom_icon']['error'] == 0) {
                $upload = wp_upload_bits(
                    $_FILES['dd_wp_chat_custom_icon']['name'],
                    null,
                    file_get_contents($_FILES['dd_wp_chat_custom_icon']['tmp_name'])
                );
                if (isset($upload['error']) && $upload['error'] != '') {
                    add_settings_error('dd_wp_chat_settings_group', 'dd_wp_chat_custom_icon', __('Error uploading custom icon: ') . $upload['error'], 'error');
                } else {
                    update_option('dd_wp_chat_custom_icon_url', $upload['url']);
                }
            } else {
                add_settings_error('dd_wp_chat_settings_group', 'dd_wp_chat_custom_icon', __('Error uploading custom icon: ') . $_FILES['dd_wp_chat_custom_icon']['error'], 'error');
            }
        }
    }

    add_action('admin_init', 'dd_devdoes_wp_chat_register_settings');
});

// Add the plugin's settings page to the admin menu
function dd_devdoes_wp_chat_add_admin_menu()
{
    add_options_page('Easy Booking Settings', 'Easy Bookings', 'manage_options', 'dd_wp_chat_settings', 'dd_devdoes_wp_chat_settings_page');
}
add_action('admin_menu', 'dd_devdoes_wp_chat_add_admin_menu');


// Display the plugin's settings page in the admin area
function dd_devdoes_wp_chat_settings_page()
{
?>
    <div class="wrap">
        <h1>Easy Bookings Settings</h1>
        <form method="post" enctype="multipart/form-data" action="options.php">
            <?php settings_fields('dd_wp_chat_settings_group'); ?>
            <?php do_settings_sections('dd_wp_chat_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Font Size:</th>
                    <td><input type="text" name="dd_wp_chat_fontsize" value="<?php echo esc_attr(get_option('dd_wp_chat_fontsize')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Box Width:</th>
                    <td><input type="text" name="dd_wp_chat_width" value="<?php echo esc_attr(get_option('dd_wp_chat_width')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Box Height:</th>
                    <td><input type="text" name="dd_wp_chat_height" value="<?php echo esc_attr(get_option('dd_wp_chat_height')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Background Color:</th>
                    <td><input type="color" name="dd_wp_chat_background_color" value="<?php echo esc_attr(get_option('dd_wp_chat_background_color')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Font Color:</th>
                    <td><input type="color" name="dd_wp_chat_font_color" value="<?php echo esc_attr(get_option('dd_wp_chat_font_color')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Text Field Height:</th>
                    <td><input type="text" name="dd_wp_chat_textfield_height" value="<?php echo esc_attr(get_option('dd_wp_chat_textfield_height')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Text Field Background:</th>
                    <td><input type="color" name="dd_wp_chat_textfield_background" value="<?php echo esc_attr(get_option('dd_wp_chat_textfield_background')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Button Color:</th>
                    <td><input type="color" name="dd_wp_chat_button_color" value="<?php echo esc_attr(get_option('dd_wp_chat_button_color')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">User Background Color:</th>
                    <td><input type="color" name="dd_wp_chat_user_background_color" value="<?php echo esc_attr(get_option('dd_wp_chat_user_background_color')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Icon:</th>
                    <td>
                        <label>
                            <input type="radio" name="dd_wp_chat_icon_type" value="default" <?php checked('default', get_option('dd_wp_chat_icon_type')); ?> checked>
                            Use Default Icon
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="dd_wp_chat_icon_type" value="custom" <?php checked('custom', get_option('dd_wp_chat_icon_type')); ?>>
                            Use Custom Icon
                        </label>
                        <br>
                        <?php if (get_option('dd_wp_chat_icon_type') == 'custom') { ?>
                            <img src="<?php echo esc_attr(get_option('dd_wp_chat_icon_custom')); ?>" width="50" height="50">
                        <?php } ?>
                        <input type="file" name="dd_wp_chat_icon_custom" accept="image/*">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button 1 label', 'dd-wp-chat'); ?></th>
                    <td><input type="text" name="dd_wp_chat_button1_label" value="<?php echo esc_attr(get_option('dd_wp_chat_button1_label')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button 1 link', 'dd-wp-chat'); ?></th>
                    <td><input type="text" name="mdd_wp_chat_button1_link" value="<?php echo esc_attr(get_option('dd_wp_chat_button1_link')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button 2 label', 'dd-wp-chat'); ?></th>
                    <td><input type="text" name="dd_wp_chat_button2_label" value="<?php echo esc_attr(get_option('dd_wp_chat_button1_label')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button 2 link', 'dd-wp-chat'); ?></th>
                    <td><input type="text" name="dd_wp_chat_button2_link" value="<?php echo esc_attr(get_option('dd_wp_chat_button2_link')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button 3 label', 'dd-wp-chat'); ?></th>
                    <td><input type="text" name="dd_wp_chat_button3_label" value="<?php echo esc_attr(get_option('dd_wp_chat_button3_label')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Button 3 link', 'dd-wp-chat'); ?></th>
                    <td><input type="text" name="dd_wp_chat_button3_link" value="<?php echo esc_attr(get_option('dd_wp_chat_button3_link')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>

<?php
}

// Save the plugin's settings
function dd_devdoes_wp_chat_save_settings()
{
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_fontsize');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_width');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_height');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_background_color');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_font_color');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_textfield_height');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_textfield_background');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button_color');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_user_background_color');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_icon_type');
    if (isset($_FILES['dd_wp_chat_icon_custom'])) {
        $allowed_ext = array('png', 'jpg', 'jpeg', 'gif');
        $upload_dir = wp_upload_dir();
        $file_name = $_FILES['dd_wp_chat_icon_custom']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_size = $_FILES['dd_wp_chat_icon_custom']['size'];
        $file_tmp = $_FILES['dd_wp_chat_icon_custom']['tmp_name'];
        $file_dest = $upload_dir['basedir'] . '/dd-wp-chat-icon.' . $file_ext;
        if (in_array($file_ext, $allowed_ext)) {
            if ($file_size < 1000000) {
                move_uploaded_file($file_tmp, $file_dest);
                update_option('dd_wp_chat_icon_custom', $upload_dir['baseurl'] . '/dd-wp-chat-icon.' . $file_ext);
            }
        }
    }
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button1_label');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button1_link');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button2_label');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button2_link');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button3_label');
    register_setting('dd_wp_chat_settings_group', 'dd_wp_chat_button3_link');
}

add_action('admin_menu', 'dd_devdoes_wp_chat_add_admin_menu');
add_action('admin_init', 'dd_devdoes_wp_chat_save_settings');

register_deactivation_hook(__FILE__, function () {
});
