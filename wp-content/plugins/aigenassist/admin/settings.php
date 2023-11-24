```php
<?php
/**
 * AIGENASSIST Settings Page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function aigenassist_settings_init() {
    // Register a new setting for "aigenassist" page
    register_setting('aigenassist', 'aigenassist_options');

    // Register a new section in the "aigenassist" page
    add_settings_section(
        'aigenassist_section',
        __('AIGENASSIST Settings', 'aigenassist'),
        'aigenassist_section_callback',
        'aigenassist'
    );

    // Register new fields in the "aigenassist_section" section, inside the "aigenassist" page
    add_settings_field(
        'aigenassist_field_openai_key', 
        __('OpenAI Key', 'aigenassist'), 
        'aigenassist_field_openai_key_cb',
        'aigenassist', 
        'aigenassist_section'
    );
}

function aigenassist_section_callback($args) {
    echo '<p id="'.esc_attr($args['id']).'">'.__('Enter your OpenAI key to enable AI functionalities.', 'aigenassist').'</p>';
}

function aigenassist_field_openai_key_cb($args) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('aigenassist_options');
    // Output the field
    ?>
    <input id="<?php echo esc_attr($args['label_for']); ?>" type="text" name="aigenassist_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo esc_attr($options[$args['label_for']]); ?>">
    <?php
}

add_action('admin_init', 'aigenassist_settings_init');

function aigenassist_options_page() {
    // Add top level menu page
    add_menu_page(
        'AIGENASSIST',
        'AIGENASSIST Settings',
        'manage_options',
        'aigenassist',
        'aigenassist_options_page_html'
    );
}

function aigenassist_options_page_html() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Output the settings form
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post" id="settings-form">
            <?php
            // Output security fields
            settings_fields('aigenassist');
            // Output setting sections and their fields
            do_settings_sections('aigenassist');
            // Output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_menu', 'aigenassist_options_page');
```