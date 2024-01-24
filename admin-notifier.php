<?php
/*
Plugin Name: Admin Email Notification
Description: Sends email to admin when a post is published or edited by an author (only once per post).
Version: 1.0
License: GPL-2.0+
Author: Khizar
*/


// Add a settings page to allow the admin to set their email
function admin_email_settings_page() {
    add_options_page('Admin Email Settings', 'Admin Email', 'manage_options', 'admin-email-settings', 'admin_email_settings');
}
add_action('admin_menu', 'admin_email_settings_page');

// Display the settings page
function admin_email_settings() {
    ?>
    <div class="wrap">
        <h2>Admin Email Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('admin-email-settings-group'); ?>
            <?php do_settings_sections('admin-email-settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Admin Email</th>
                    <td><input type="text" name="admin_email" value="<?php echo esc_attr(get_option('admin_email')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
function admin_email_register_settings() {
    register_setting('admin-email-settings-group', 'admin_email');
}
add_action('admin_init', 'admin_email_register_settings');

function send_admin_email_notification($new_status, $old_status, $post) {
    $admin_email = get_option('admin_email');
    $post_ID = $post->ID;
    $original_author_id = $post->post_author;
    $editor_id = get_current_user_id();
    $editor_name = get_the_author_meta('display_name', $editor_id);
    $post_title = $post->post_title;
    $post_link = get_permalink($post_ID);
    $site_name = get_bloginfo('name'); // Fetch the site name
    error_log("New Status: $new_status, Old Status: $old_status, Post ID: $post_ID");

    $subject = "[$site_name] Post ";
    $action = '';

    // Check if the post has been published before
    $published_key = 'post_published_' . $post_ID;
    $published = get_post_meta($post_ID, $published_key, true);
 
if ($new_status === 'publish' && $old_status === 'publish' && !$published) {
        // New post is being published for the first time
        $action = 'Published';
		 if (!empty($action)) {
				$author_name = ($action === 'Published') ? get_the_author_meta('display_name', $original_author_id) : $editor_name;

				$subject .= $action;

				$timestamp = current_time('mysql'); // Include the timestamp

				ob_start();
				include plugin_dir_path(__FILE__) . 'email-template.php'; // Load the HTML template
				$message = ob_get_clean();

				$headers = array('Content-Type: text/html; charset=UTF-8');

				wp_mail($admin_email, $subject, $message, $headers);
			}
        // Set the flag indicating that the post has been published
        update_post_meta($post_ID, $published_key, true);
    } elseif ($new_status === 'publish' && $old_status === 'publish' && isset($published) && $editor_id !== $original_author_id) {
        // Existing post is edited by a different user
        $action = 'Edited';

		$counter_value = get_option("counter_value", 0);

		 if($counter_value == 1 &&  $action = 'Edited')
		{
				if (!empty($action)) {
				$author_name = ($action === 'Published') ? get_the_author_meta('display_name', $original_author_id) : $editor_name;

				$subject .= $action;

				$timestamp = current_time('mysql'); // Include the timestamp

				ob_start();
				include plugin_dir_path(__FILE__) . 'email-template.php'; // Load the HTML template
				$message = ob_get_clean();

				$headers = array('Content-Type: text/html; charset=UTF-8');

				wp_mail($admin_email, $subject, $message, $headers);
			}
			error_log("v: $counter_value");
				$counter_value = 0;
				 update_option("counter_value", $counter_value);
		}
		else{
				$counter_value = 1;
				 update_option("counter_value", $counter_value);
		}
    

    }

   
}

add_action('transition_post_status', 'send_admin_email_notification', 10, 3);


?>