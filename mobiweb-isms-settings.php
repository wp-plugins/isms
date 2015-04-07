<?php
   
class Mobiweb_ISMS_Settings {
    public function add_menu_settings() {
        add_options_page(
            'Mobiweb iSMS Settings',
            'iSMS',
            'administrator',
            'isms_plugin_settings',
            array($this, 'isms_plugin_settings_callback')
         );
        add_submenu_page(
            'isms_plugin_settings',
            __('iSMS Account', 'mobiweb-isms'),
            __('iSMS Account', 'mobiweb-isms'),
            'administrator',
            'isms_plugin_account_settings'
        );
        add_submenu_page(
            'isms_plugin_settings',
            __('Publish Post Alert', 'mobiweb-isms'),
            __('Publish Post Alert', 'mobiweb-isms'),
            'administrator',
            'isms_plugin_alert_post_settings'
        );
        add_submenu_page(
            'isms_plugin_settings',
            __('New User Alert', 'mobiweb-isms'),
            __('New User Alert', 'mobiweb-isms'),
            'administrator',
            'isms_plugin_alert_new_user_settings'
        );
        add_submenu_page(
            'isms_plugin_settings',
            __('New Comment Alert', 'mobiweb-isms'),
            __('New Comment Alert', 'mobiweb-isms'),
            'administrator',
            'isms_plugin_alert_new_comment_settings'
        );
        add_submenu_page(
            'isms_plugin_settings',
            __('Login Alert', 'mobiweb-isms'),
            __('Login Alert', 'mobiweb-isms'),
            'administrator',
            'isms_plugin_alert_login_settings'
        );
    }
    
    public function init_settings() {
        $this->init_account_settings();
        $this->init_alert_post_settings();
        $this->init_alert_new_user_settings();
        $this->init_alert_new_comment_settings();
        $this->init_alert_login_settings();
    }
    
    /**
    * Initialize Account Settings
    */
    protected function init_account_settings() {
        add_settings_section(
           'isms_account_section',
           __('iSMS Account', 'mobiweb-isms'),
           array($this, 'isms_account_section_callback'),
           'isms_plugin_account_settings'
        );
        add_settings_field(
           'setting_username',
           __('Username', 'mobiweb-isms'),
           array($this, 'isms_username_callback'),
           'isms_plugin_account_settings',
           'isms_account_section'
        );
        add_settings_field(
           'setting_password',
           __('Password', 'mobiweb-isms'),
           array($this, 'isms_password_callback'),
           'isms_plugin_account_settings',
           'isms_account_section'
        );
        add_settings_field(
           'setting_message_type',
           __('Message Type', 'mobiweb-isms'),
           array($this, 'isms_message_type_callback'),
           'isms_plugin_account_settings',
           'isms_account_section'
        );
        add_settings_field(
           'setting_admin_phone_number',
           __('Admin Phone Number', 'mobiweb-isms'),
           array($this, 'isms_admin_phone_number_callback'),
           'isms_plugin_account_settings',
           'isms_account_section'
        );

        // register the settings for this plugin
        register_setting('isms_plugin_account_settings', 'setting_username');
        register_setting('isms_plugin_account_settings', 'setting_password');
        register_setting('isms_plugin_account_settings', 'setting_message_type');
        register_setting('isms_plugin_account_settings', 'setting_admin_phone_number');
        
        // Set default values
        if (get_option('setting_message_type') == null) {
            update_option('setting_message_type', '1');
        }
    }
    
    /**
     * Initialize Admin Publish Post Settings
     */
    protected function init_alert_post_settings() {
        add_settings_section(
           'post_alert_section',
           __('Publish Post Alert', 'mobiweb-isms'),
           array($this, 'post_alert_section_callback'),
           'isms_plugin_alert_post_settings'
        );
        add_settings_field(
           'setting_post_enabled',
           __('Enabled', 'mobiweb-isms'),
           array($this, 'post_alert_enabled_callback'),
           'isms_plugin_alert_post_settings',
           'post_alert_section'
        );
        add_settings_field(
           'setting_post_parameters',
           __('Parameters', 'mobiweb-isms'),
           array($this, 'post_alert_parameters_callback'),
           'isms_plugin_alert_post_settings',
           'post_alert_section'
        );
        add_settings_field(
           'setting_post_sms_limit',
           __('SMS Limit', 'mobiweb-isms'),
           array($this, 'post_alert_sms_limit_callback'),
           'isms_plugin_alert_post_settings',
           'post_alert_section'
        );
        
        // register settings
        register_setting('isms_plugin_alert_post_settings', 'setting_post_enabled');
        register_setting('isms_plugin_alert_post_settings', 'setting_post_parameters');
        register_setting('isms_plugin_alert_post_settings', 'setting_post_sms_limit');
        
        // Set default values
        if (get_option('setting_post_enabled') == null) {
            update_option('setting_post_enabled', '1');
        }
        if (get_option('setting_post_parameters') == null) {
            $setting_post_parameters = array(
                'name'=>"1",
                'email'=>"1",
                'title'=>"1",
                'content'=>"1",
            );
            update_option('setting_post_parameters', $setting_post_parameters);
        }
        if (get_option('setting_post_sms_limit') == null) {
            update_option('setting_post_sms_limit', 1);
        }
    }
    
    /**
     * Initialize Admin New User Alert Settings
     */
    protected function init_alert_new_user_settings() {
        add_settings_section(
            'new_user_alert_section',
            __('New User Alert', 'mobiweb-isms'),
            array($this, 'new_user_alert_section_callback'),
            'isms_plugin_alert_new_user_settings'
        );
        add_settings_field(
            'setting_new_user_enabled',
            __('Enabled', 'mobiweb-isms'),
            array($this, 'new_user_alert_enabled_callback'),
            'isms_plugin_alert_new_user_settings',
            'new_user_alert_section'
        );
        add_settings_field(
            'setting_new_user_parameters',
            __('Parameters', 'mobiweb-isms'),
            array($this, 'new_user_alert_parameters_callback'),
            'isms_plugin_alert_new_user_settings',
            'new_user_alert_section'
        );
        
        // register settings
        register_setting('isms_plugin_alert_new_user_settings', 'setting_new_user_enabled');
        register_setting('isms_plugin_alert_new_user_settings', 'setting_new_user_parameters');
        
        // Set default values
        if (get_option('setting_new_user_enabled') == null) {
            update_option('setting_new_user_enabled', '1');
        }
        if (get_option('setting_new_user_parameters') == null) {
            $setting_new_user_parameters = array(
                "username"=>"1",
                "email"=>"1",
                "full_name"=>"1",
                "website"=>"1",
                "role"=>"1"
            );
            update_option('setting_new_user_parameters', $setting_new_user_parameters);
        }
    }
    
    /**
     * Initialize Admin New Comment Alert Settings
     */
    protected function init_alert_new_comment_settings() {
        add_settings_section(
            'new_comment_alert_section',
            __('New Comment Alert', 'mobiweb-isms'),
            array($this, 'new_comment_alert_section_callback'),
            'isms_plugin_alert_new_comment_settings'
        );
        add_settings_field(
            'setting_new_comment_enabled',
            __('Enabled', 'mobiweb-isms'),
            array($this, 'new_comment_alert_enabled_callback'),
            'isms_plugin_alert_new_comment_settings',
            'new_comment_alert_section'
        );
        add_settings_field(
            'setting_new_comment_parameters',
            __('Parameters', 'mobiweb-isms'),
            array($this, 'new_comment_alert_parameters_callback'),
            'isms_plugin_alert_new_comment_settings',
            'new_comment_alert_section'
        );
        add_settings_field(
            'setting_new_comment_sms_limit',
            __('SMS Limit', 'mobiweb-isms'),
            array($this, 'new_comment_alert_sms_limit_callback'),
            'isms_plugin_alert_new_comment_settings',
            'new_comment_alert_section'
        );
        
        // register settings
        register_setting('isms_plugin_alert_new_comment_settings', 'setting_new_comment_enabled');
        register_setting('isms_plugin_alert_new_comment_settings', 'setting_new_comment_parameters');
        register_setting('isms_plugin_alert_new_comment_settings', 'setting_new_comment_sms_limit');
        
        // Set default values
        if (get_option('setting_new_comment_enabled') == null) {
            update_option('setting_new_comment_enabled', '1');
        }
        if (get_option('setting_new_comment_parameters') == null) {
            $setting_new_comment_parameters = array(
                "name"=>"1",
                "email"=>"1",
                "website"=>"1",
                "date"=>"1",
                "content"=>"1"
            );
            update_option('setting_new_comment_parameters', $setting_new_comment_parameters);
        }
        if (get_option('setting_new_comment_sms_limit') == null) {
            update_option('setting_new_comment_sms_limit', 1);
        }
    }
    
    /**
     * Initialize Admin Login Alert Settings
     */
    protected function init_alert_login_settings() {
        add_settings_section(
            'login_alert_section',
            __('Login Alert', 'mobiweb-isms'),
            array($this, 'login_alert_section_callback'),
            'isms_plugin_alert_login_settings'
        );
        add_settings_field(
            'setting_login_enabled',
            __('Enabled', 'mobiweb-isms'),
            array($this, 'login_alert_enabled_callback'),
            'isms_plugin_alert_login_settings',
            'login_alert_section'
        );
        
        // register settings
        register_setting('isms_plugin_alert_login_settings', 'setting_login_enabled');
        
        // Set default values
        if (get_option('setting_login_enabled') == null) {
            update_option('setting_login_enabled', '1');
        }
    }
    
    /**
     * Menu Callback
     */
    public function isms_callback() {
        ?>
        <div class="wrap">
            <h2><?php _e('iSMS', 'mobiweb-isms')?></h2>
        </div>
        <?php
    }
    
    public function isms_plugin_settings_callback() {
        ?>
        <div class="wrap">
            <h2><?php _e('Settings', 'mobiweb-isms')?></h2>
            
            <?php
                $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'isms_account';
            ?>
            
            <h2 class="nav-tab-wrapper">
                <a href="?page=isms_plugin_settings&tab=isms_account" class="nav-tab <?php echo $active_tab == 'isms_account' ? 'nav-tab-active' : '' ?>"><?php _e('iSMS Account', 'mobiweb-isms') ?></a>
                <a href="?page=isms_plugin_settings&tab=publish_post_alert" class="nav-tab <?php echo $active_tab == 'publish_post_alert' ? 'nav-tab-active' : '' ?>"><?php _e('Publish Post Alert', 'mobiweb-isms') ?></a>
                <a href="?page=isms_plugin_settings&tab=new_user_alert" class="nav-tab <?php echo $active_tab == 'new_user_alert' ? 'nav-tab-active' : '' ?>"><?php _e('New User Alert', 'mobiweb-isms') ?></a>
                <a href="?page=isms_plugin_settings&tab=new_comment_alert" class="nav-tab <?php echo $active_tab == 'new_comment_alert' ? 'nav-tab-active' : '' ?>"><?php _e('New Comment Alert', 'mobiweb-isms') ?></a>
                <a href="?page=isms_plugin_settings&tab=login_alert" class="nav-tab <?php echo $active_tab == 'login_alert' ? 'nav-tab-active' : '' ?>"><?php _e('Login Alert', 'mobiweb-isms') ?></a>
            </h2>
            
            <form method="post" action="options.php">
                <?php
                    switch ($active_tab) {
                        case 'isms_account':
                            settings_fields('isms_plugin_account_settings');
                            do_settings_sections('isms_plugin_account_settings');
                            break;
                        case 'publish_post_alert':
                            settings_fields('isms_plugin_alert_post_settings');
                            do_settings_sections('isms_plugin_alert_post_settings');
                            break;
                        case 'new_user_alert':
                            settings_fields('isms_plugin_alert_new_user_settings');
                            do_settings_sections('isms_plugin_alert_new_user_settings');
                            break;
                        case 'new_comment_alert':
                            settings_fields('isms_plugin_alert_new_comment_settings');
                            do_settings_sections('isms_plugin_alert_new_comment_settings');
                            break;
                        case 'login_alert':
                            settings_fields('isms_plugin_alert_login_settings');
                            do_settings_sections('isms_plugin_alert_login_settings');
                            break;
                    }
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }
    
    public function isms_account_section_callback() {
        $balance = Mobiweb_ISMS_Model::get_balance();
        ?>
        <table class="form-table">
            <tr valign="top"> 
                <th scope="row">
                   <label><?php _e('Balance', 'mobiweb-isms') ?></label>
                   <a href="http://isms.com.my/buy_reload.php">(Reload Credit)</a>
                </th>
                <td><label><?php echo $balance ?></label></td>
            </tr>
        </table>
        <?php
    }
    
    
    public function isms_username_callback() {
        ?>
        <input type="text" name="setting_username" id="setting_username" value="<?php echo get_option('setting_username'); ?>" />
        <p class="description"><a href="http://isms.com.my/register.php">Register</a> your account at isms.com.my</p>
        <?php
    }
    
    public function isms_password_callback() {
        ?>
        <input type="password" name="setting_password" id="setting_password" value="<?php echo get_option('setting_password'); ?>" />
        <?php
    }
    
    public function isms_message_type_callback() {
        ?>
        <fieldset>
           <input type="radio" name="setting_message_type" id="setting_message_type_normal" value="1" <?php checked(1, get_option('setting_message_type')) ?> /><label for="setting_message_type_normal"><?php _e('Normal', 'mobiweb-isms')?></label><p class="description"><?php _e('(Eg. English, B. Melayu, etc)', 'mobiweb-isms') ?></p><br />
           <input type="radio" name="setting_message_type" id="setting_message_type_unicode" value="2" <?php checked(2, get_option('setting_message_type')) ?> /><label for="setting_message_type_unicode"><?php _e('Unicode', 'mobiweb-isms')?></label><p class="description"><?php _e('(Eg. Chinese, Japanese, etc)', 'mobiweb-isms') ?></p>
        </fieldset>
        <?php
    }
    
    public function isms_admin_phone_number_callback() {
        ?>
        <input type="tel" name="setting_admin_phone_number" id="setting_admin_phone_number" value="<?php echo get_option('setting_admin_phone_number'); ?>" />
        <p class="description"><?php _e('Country Code + Phone Number (e.g. 60123456789 for Malaysia)', 'mobiweb-isms')?></p>
        <?php
    }
    
    public function post_alert_section_callback() {
        // Do nothing
    }
    
    public function post_alert_enabled_callback() {
        ?>
        <fieldset>
           <input type="radio" name="setting_post_enabled" id="setting_post_enabled_no" value="0" <?php checked(0, get_option('setting_post_enabled')) ?> /><label for="setting_post_enabled_no"><?php _e('No', 'mobiweb-isms') ?></label><br />
           <input type="radio" name="setting_post_enabled" id="setting_post_enabled_yes" value="1" <?php checked(1, get_option('setting_post_enabled')) ?> /><label for="setting_post_enabled_yes"><?php _e('Yes', 'mobiweb-isms') ?></label>
        </fieldset>
        <?php
    }
    
    public function post_alert_parameters_callback() {
        $option = get_option('setting_post_parameters');
        ?>
        <fieldset>
           <input type="checkbox" name="setting_post_parameters[name]" id="setting_post_parameters[name]" value="1" <?php checked(1, $option['name']) ?> /><label for="setting_post_parameters[name]"><?php _e('Name', 'mobiweb-isms') ?></label><br />
           <input type="checkbox" name="setting_post_parameters[email]" id="setting_post_parameters[email]" value="1" <?php checked(1, $option['email']) ?> /><label for="setting_post_parameters[email]"><?php _e('Email', 'mobiweb-isms') ?></label><br />
           <input type="checkbox" name="setting_post_parameters[title]" id="setting_post_parameters[title]" value="1" <?php checked(1, $option['title']) ?>/><label for="setting_post_parameters[title]"><?php _e('Title', 'mobiweb-isms') ?></label><br />
           <input type="checkbox" name="setting_post_parameters[content]" id="setting_post_parameters[content]" value="1" <?php checked(1, $option['content']) ?>/><label for="setting_post_parameters[content]"><?php _e('Content', 'mobiweb-isms') ?></label>
        </fieldset>
        <?php
    }
    
    public function post_alert_sms_limit_callback() {
        ?>
        <select id="setting_post_sms_limit" name="setting_post_sms_limit">
           <option value="1" <?php selected(get_option('setting_post_sms_limit'), '1')?>><?php _e('1', 'mobiweb-isms')?></option>
           <option value="2" <?php selected(get_option('setting_post_sms_limit'), '2')?>><?php _e('2', 'mobiweb-isms')?></option>
           <option value="3" <?php selected(get_option('setting_post_sms_limit'), '3')?>><?php _e('3', 'mobiweb-isms')?></option>
           <option value="4" <?php selected(get_option('setting_post_sms_limit'), '4')?>><?php _e('4', 'mobiweb-isms')?></option>
           <option value="5" <?php selected(get_option('setting_post_sms_limit'), '5')?>><?php _e('5', 'mobiweb-isms')?></option>
           <option value="6" <?php selected(get_option('setting_post_sms_limit'), '6')?>><?php _e('6', 'mobiweb-isms')?></option>
        </select>
        <?php
    }
    
    public function new_user_alert_section_callback() {
        // Do nothing
    }
    
    public function new_user_alert_enabled_callback() {
        ?>
        <fieldset>
            <input type="radio" name="setting_new_user_enabled" id="setting_new_user_enabled_no" value="0" <?php checked(0, get_option('setting_new_user_enabled')) ?> /><label for="setting_new_user_enabled_no"><?php _e('No', 'mobiweb-isms') ?></label><br />
            <input type="radio" name="setting_new_user_enabled" id="setting_new_user_enabled_yes" value="1" <?php checked(1, get_option('setting_new_user_enabled')) ?> /><label for="setting_new_user_enabled_yes"><?php _e('Yes', 'mobiweb-isms') ?></label>
        </fieldset>
        <?php
    }
    
    public function new_user_alert_parameters_callback() {
        $option = get_option('setting_new_user_parameters');
        ?>
        <fieldset>
            <input type="checkbox" name="setting_new_user_parameters[username]" id="setting_new_user_parameters[username]" value="1" <?php checked(1, $option['username']) ?> /><label for="setting_new_user_parameters[username]"><?php _e('Username', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_user_parameters[email]" id="setting_new_user_parameters[email]" value="1" <?php checked(1, $option['email']) ?> /><label for="setting_new_user_parameters[email]"><?php _e('Email', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_user_parameters[full_name]" id="setting_new_user_parameters[full_name]" value="1" <?php checked(1, $option['full_name']) ?> /><label for="setting_new_user_parameters[full_name]"><?php _e('Full Name', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_user_parameters[website]" id="setting_new_user_parameters[website]" value="1" <?php checked(1, $option['website']) ?> /><label for="setting_new_user_parameters[website]"><?php _e('Website', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_user_parameters[role]" id="setting_new_user_parameters[role]" value="1" <?php checked(1, $option['role']) ?> /><label for="setting_new_user_parameters[role]"><?php _e('Role', 'mobiweb-isms') ?></label>
        </fieldset>
        <?php
    }
    
    public function new_comment_alert_section_callback() {
        // Do nothing
    }
    
    public function new_comment_alert_enabled_callback() {
        ?>
        <fieldset>
            <input type="radio" name="setting_new_comment_enabled" id="setting_new_comment_enabled_no" value="0" <?php checked(0, get_option('setting_new_comment_enabled')) ?> /><label for="setting_new_comment_enabled_no"><?php _e('No', 'mobiweb-isms') ?></label><br />
            <input type="radio" name="setting_new_comment_enabled" id="setting_new_comment_enabled_yes" value="1" <?php checked(1, get_option('setting_new_comment_enabled')) ?> /><label for="setting_new_comment_enabled_yes"><?php _e('Yes', 'mobiweb-isms') ?></label>
        </fieldset>
        <?php
    }
    
    public function new_comment_alert_parameters_callback() {
        $option = get_option('setting_new_comment_parameters');
        ?>
        <fieldset>
            <input type="checkbox" name="setting_new_comment_parameters[name]" id="setting_new_comment_parameters[name]" value="1" <?php checked(1, $option['name']) ?> /><label for="setting_new_comment_parameters[name]"><?php _e('Name', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_comment_parameters[email]" id="setting_new_comment_parameters[email]" value="1" <?php checked(1, $option['email']) ?> /><label for="setting_new_comment_parameters[email]"><?php _e('Email', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_comment_parameters[website]" id="setting_new_comment_parameters[website]" value="1" <?php checked(1, $option['website']) ?> /><label for="setting_new_comment_parameters[website]"><?php _e('Website', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_comment_parameters[date]" id="setting_new_comment_parameters[date]" value="1" <?php checked(1, $option['date']) ?> /><label for="setting_new_comment_parameters[date]"><?php _e('Date', 'mobiweb-isms') ?></label><br />
            <input type="checkbox" name="setting_new_comment_parameters[content]" id="setting_new_comment_parameters[content]" value="1" <?php checked(1, $option['content']) ?> /><label for="setting_new_comment_parameters[content]"><?php _e('Content', 'mobiweb-isms') ?></label>
        </fieldset>
        <?php
    }
    
    public function new_comment_alert_sms_limit_callback() {
        ?>
        <select id="setting_new_comment_sms_limit" name="setting_new_comment_sms_limit">
           <option value="1" <?php selected(get_option('setting_new_comment_sms_limit'), '1')?>><?php _e('1', 'mobiweb-isms')?></option>
           <option value="2" <?php selected(get_option('setting_new_comment_sms_limit'), '2')?>><?php _e('2', 'mobiweb-isms')?></option>
           <option value="3" <?php selected(get_option('setting_new_comment_sms_limit'), '3')?>><?php _e('3', 'mobiweb-isms')?></option>
           <option value="4" <?php selected(get_option('setting_new_comment_sms_limit'), '4')?>><?php _e('4', 'mobiweb-isms')?></option>
           <option value="5" <?php selected(get_option('setting_new_comment_sms_limit'), '5')?>><?php _e('5', 'mobiweb-isms')?></option>
           <option value="6" <?php selected(get_option('setting_new_comment_sms_limit'), '6')?>><?php _e('6', 'mobiweb-isms')?></option>
        </select>
        <?php
    }
    
    public function login_alert_section_callback() {
        // Do nothing
    }
    
    public function login_alert_enabled_callback() {
        ?>
        <fieldset>
            <input type="radio" name="setting_login_enabled" id="setting_login_enabled_no" value="0" <?php checked(0, get_option('setting_login_enabled')) ?> /><label for="setting_login_enabled_no"><?php _e('No', 'mobiweb-isms') ?></label><br />
            <input type="radio" name="setting_login_enabled" id="setting_login_enabled_yes" value="1" <?php checked(1, get_option('setting_login_enabled')) ?> /><label for="setting_login_enabled_yes"><?php _e('Yes', 'mobiweb-isms') ?></label>
        </fieldset>
        <?php
    }
}