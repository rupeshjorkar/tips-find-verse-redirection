<?php

class TipsFindSettings {
    function __construct() {
        $this->init();
    }

    public function init() {
        add_action('admin_menu', array($this, 'add_tips_find_verse_menu'));
        
        add_action('admin_enqueue_scripts', array($this, 'enqueue_plugin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_color_picker'));

    }
    public function enqueue_plugin_styles($hook_suffix) {
        if ($hook_suffix === 'tips-configuration_page_tips-find-verse-instruction') {
            wp_enqueue_style('tips-find-verse-css', plugin_dir_url(__FILE__) . '../assets/css/tips-find-verse.css');
        }
    }
    public function enqueue_color_picker($hook_suffix) {
        if ($hook_suffix === 'toplevel_page_tips-find-verse') {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('tips-find-verse-script', plugin_dir_url(__FILE__) . '../assets/js/tips-find-verse.js', array('wp-color-picker'), false, true);
        }
    }

    public function add_tips_find_verse_menu() {
        // Add the main menu.
        add_menu_page(
            __('TIPs Configuration', 'tips-find-verse'),    
            __('TIPs Configuration', 'tips-find-verse'),    
            'manage_options',                              
            'tips-find-verse',                             
            array($this, 'tips_configuration_page'),       
            'dashicons-admin-tools',                       
            25                                             
        );
        add_submenu_page(
            'tips-find-verse',                             
            __('Instruction', 'tips-find-verse'),          
            __('Instruction', 'tips-find-verse'),          
            'manage_options',                              
            'tips-find-verse-instruction',                 
            array($this, 'tips_instruction_page')          
        );
    }
    public function tips_configuration_page() {
        $color = get_option('tips_find_verse_color', '#31bbd8'); // Default color
        $button_text = get_option('tips_find_verse_button_text', 'Find verse'); // Default button text
        $place_order = get_option('tips_find_verse_place_order', 'Tips: Find verse'); // Default empty value
    
        ?>
        <div class="wrap">
            <h1><?php _e('TIPs Configuration', 'tips-find-verse'); ?></h1>
            <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
                <div id="message" class="updated notice is-dismissible">
                    <p><?php _e('Settings saved successfully.', 'tips-find-verse'); ?></p>
                </div>
            <?php endif; ?>
            <form method="post" action="options.php">
                <?php settings_fields('tips-find-verse-settings'); ?>
                <?php do_settings_sections('tips-find-verse-settings'); ?>
                <table class="form-table">
                    <!-- Color Picker -->
                    <tr valign="top">
                        <th scope="row"><?php _e('Button background color', 'tips-find-verse'); ?></th>
                        <td>
                            <input type="text" name="tips_find_verse_color" value="<?php echo esc_attr($color); ?>" class="tips-color-picker" />
                        </td>
                    </tr>
                    <!-- Button Text -->
                    <tr valign="top">
                        <th scope="row"><?php _e('Button Text', 'tips-find-verse'); ?></th>
                        <td>
                            <input type="text" name="tips_find_verse_button_text" value="<?php echo esc_attr($button_text); ?>" />
                        </td>
                    </tr>
                    <!-- Place Order -->
                    <tr valign="top">
                        <th scope="row"><?php _e('Place Holder Text', 'tips-find-verse'); ?></th>
                        <td>
                            <input type="text" name="tips_find_verse_place_order" value="<?php echo esc_attr($place_order); ?>" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
   public function tips_instruction_page() {
        ?>
        <div class="wrap tips-instruction-page">
            <h1><?php _e('TIPs: Find Verse Widget Plugin Instruction', 'tips-find-verse'); ?></h1>
    
            <h2><?php _e('How to Install the Plugin?', 'tips-find-verse'); ?></h2>
            <ol>
                <li><?php _e('Download the plugin ZIP file.', 'tips-find-verse'); ?></li>
                <li><?php _e('Log in to your WordPress admin dashboard.', 'tips-find-verse'); ?></li>
                <li><?php _e('Navigate to Plugins > Add New > Upload Plugin.', 'tips-find-verse'); ?></li>
                <li><?php _e('Click on "Choose File" and select the downloaded ZIP file.', 'tips-find-verse'); ?></li>
                <li><?php _e('Click on "Install Now" and then "Activate Plugin" once the installation is complete.', 'tips-find-verse'); ?></li>
            </ol>
    
            <h2><?php _e('How to Change the Configurations?', 'tips-find-verse'); ?></h2>
            <ol>
                <li><?php _e('Go to the "TIPs Configuration" menu in the WordPress admin dashboard.', 'tips-find-verse'); ?></li>
                <li><?php _e('On the configuration page, you can change settings such as Button background color, Button text, and Place Holder Text.', 'tips-find-verse'); ?></li>
                <li><?php _e('Make the desired changes in the input fields.', 'tips-find-verse'); ?></li>
                <li><?php _e('Click on "Save Changes" to update the settings.', 'tips-find-verse'); ?></li>
                <li><?php _e('You will see a success message confirming the settings were saved.', 'tips-find-verse'); ?></li>
            </ol>
    
            <h2><?php _e('How to Use the Plugin?', 'tips-find-verse'); ?></h2>
            <ol>
                <li><?php _e('Use the shortcode <code>[tips_find_verse]</code> to display the search widget.', 'tips-find-verse'); ?></li>
                <li><?php _e('You can place this shortcode in any post, page, or widget area.', 'tips-find-verse'); ?></li>
                <li><?php _e('To add the shortcode to a post or page, simply paste it into the content editor.', 'tips-find-verse'); ?></li>
                <li><?php _e('To add it to a widget area, go to Appearance > Widgets and add a Text widget, then paste the shortcode inside.', 'tips-find-verse'); ?></li>
            </ol>
    
            <h2><?php _e('Support', 'tips-find-verse'); ?></h2>
            <p><?php _e('If you have any questions or need support, please email us at ', 'tips-find-verse'); ?> 
                <a href="mailto:jzetzsche@biblesocieties.org">jzetzsche@biblesocieties.org</a>.
            </p>
    
            <!-- Button to download the PDF -->
            <a href="https://demo-tips.translation.bible/PDF/Tips_Find_Verse_Plugin_Instructions.pdf" class="button" target="_blank">
                <?php _e('Download PDF for More Information', 'tips-find-verse'); ?>
            </a>
        </div>
        <?php
    }
}
// Register the settings.
add_action('admin_init', function() {
    register_setting('tips-find-verse-settings', 'tips_find_verse_color');
    register_setting('tips-find-verse-settings', 'tips_find_verse_button_text');
    register_setting('tips-find-verse-settings', 'tips_find_verse_place_order');
});

new TipsFindSettings();


