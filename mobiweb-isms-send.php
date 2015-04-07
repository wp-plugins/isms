<?php

class Mobiweb_ISMS_Send {    
    public function __construct() {        
        add_action('init', array($this, 'action_send_isms'));
    }
    
    public function add_menu_send() {
        add_plugins_page(
            'Mobiweb iSMS Send',
            'iSMS',
            'administrator',
            'isms_send',
            array($this, 'isms_send_callback')
        );
    }
    
    /**
     * Menu Callback
     */
    public function isms_send_callback() {
        $balance = Mobiweb_ISMS_Model::get_balance();
        ?>
        <div class="wrap">
            <h2><?php _e('Send Message', 'mobiweb-isms')?></h2>
            
            <form method="post" action="">
                <input type="hidden" name="page" value="isms_send"/>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label><?php _e('iSMS Balance', 'mobiweb-isms') ?></label>
                            <a href="http://isms.com.my/buy_reload.php">(Reload Credit)</a>
                        </th>
                        <td><label><?php echo $balance ?></label></td>
                    </tr>
                    <!--<tr valign="top">
                        <th scope="row"><label for="send_to_type"><?php _e('Send To', 'mobiweb-isms') ?></label></th>
                        <td>
                            <select name="send_to_type" id="send_to_type">
                                <option value="phone_number"><?php _e('Phone Number', 'mobiweb-isms')?></option>
                                <option value="subscribers"><?php _e('Subscribers', 'mobiweb-isms')?></option>
                            </select>
                        </td>
                    </tr>-->
                    <tr valign="top">
                        <th scope="row"><label for="send_destination"><?php _e('To', 'mobiweb-isms')?></label></th>
                        <td>
                            <input type="tel" name="send_destination" id="send_destination" /><p class="description">
                            <?php _e('Enter destination phone number here', 'mobiweb-isms') ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="send_message_type"><?php _e('Message Type', 'mobiweb-isms')?></label></th>
                        <td>
                            <fieldset>
                                <input type="radio" name="send_message_type" id="send_message_type_normal" value="1" <?php checked(1, get_option('setting_message_type')) ?> /><label for="send_message_type_normal"><?php _e('Normal (Eg. English, B. Melayu, etc)')?></label><br />
                                <input type="radio" name="send_message_type" id="send_message_type_unicode" value="2" <?php checked(2, get_option('setting_message_type')) ?> /><label for="send_message_type_unicode"><?php _e('Unicode (Eg. Chinese, Japanese, etc)')?></label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="send_message"><?php _e('Message', 'mobiweb-isms')?></label></th>
                        <td>
                            <textarea name="send_message" id="send_message" rows="5" cols="50"></textarea>
                            <p class="description"><?php _e('Type your SMS message here', 'mobiweb-isms') ?></p>
                        </td>
                    </tr>
                </table>
                <input type="submit" value="Send" class="button-primary"/>
                <input type="hidden" name="mobiweb-isms-send-submit" value="1" />
            </form>
        </div>
        <?php
    }
        
    public function action_send_isms() {
        if (isset($_POST['mobiweb-isms-send-submit']) && '1' == $_POST['mobiweb-isms-send-submit']) {
            //$send_to_type = $_POST['send_to_type'];
            //switch ($send_to_type) {
            //    case 'phone_number':
                    $this->send_phone_number();
            //        break;
            //    case 'subscribers':
            //        $this->send_subscribers();
            //        break;
            //}
        }
    }
    
    private function send_phone_number() {
        $destination = $_POST['send_destination'];
        $message_type = $_POST['send_message_type'];
        $message = sanitize_text_field($_POST['send_message']);
        
        $result = Mobiweb_ISMS_Model::send_isms($destination, $message, $message_type);
        if ($result[code] == '2000') {
            add_notice(__('SMS sent', 'mobiweb-isms'));
        } else {
            add_notice("iSMS Error : " . $result['message']);
        }        
    }
    
    private function send_subscribers(){
        echo "get subscribers";
        $subscribers = get_users('blog_id=1&orderby=nicename&role=subscriber');
        // Array of WP_User objects.
        foreach ($subscribers as $user) {
            echo '<span>' . esc_html($user->user_email) . '</span>';
        }
    }
}