<?php

class Mobiweb_ISMS_Alert {
    public function __construct() {
        add_action('publish_post', array($this, 'alert_publish_post'), 10, 2);
        add_action('user_register', array($this, 'alert_user_register'));
        add_action('wp_insert_comment', array($this, 'alert_insert_comment'), 10, 2);
        add_action('wp_login', array($this, 'alert_login'), 10, 2);
    }
    
    public function alert_publish_post($ID, $post) {
        if (get_option('setting_post_enabled') == "0") {
            return;
        }
        
        $author = $post->post_author;
        $name = sanitize_user(get_the_author_meta('display_name', $author));
        $email = sanitize_email(get_the_author_meta('user_email', $author));
        $title = sanitize_text_field($post->post_title);
        $content = sanitize_text_field($post->post_content);
        
        $message_rows = array();
        $parameters = get_option('setting_post_parameters');
        
        foreach ($parameters as $key => $value) {
            switch ($key) {
                case 'name':
                    $name_row = sprintf('%s:%s', __('Name', 'mobiweb-isms'), $name);
                    array_push($message_rows, $name_row);
                    break;
                case 'email':
                    $email_row = sprintf('%s:%s', __('Email', 'mobiweb-isms'), $email);
                    array_push($message_rows, $email_row);
                    break;
                case 'title':
                    $title_row = sprintf('%s:%s', __('Title', 'mobiweb-isms'), $title);
                    array_push($message_rows, $title_row);
                    break;
                case 'content':
                    $content_row = sprintf('%s:%s', __('Content', 'mobiweb-isms'), $content);
                    array_push($message_rows, $content_row);
                    break;
            }
        }
        
        $message = sprintf('%s%s%s', __('Post Published', 'mobiweb-isms'), PHP_EOL, implode(PHP_EOL, $message_rows));
        
        $sms_limit = get_option('setting_post_sms_limit');
        $message = $this->trim_message($message, $sms_limit);
        
        $this->send_isms($message);
    }
    
    public function alert_user_register($user_id) {
        if (get_option('setting_new_user_enabled') == "0") {
            return;
        }
        
        $username = sanitize_user($_POST['user_login']);
        $email = sanitize_email($_POST['email']);
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $full_name = sprintf("%s %s", $first_name, $last_name);
        $website = sanitize_text_field($_POST['url']);
        $role = $_POST['role'];
        
        $message_rows = array();
        $parameters = get_option('setting_new_user_parameters');
        
        foreach ($parameters as $key => $value) {
            switch ($key) {
                case 'username':
                    $username_row = sprintf('%s:%s', __('Username', 'mobiweb-isms'), $username);
                    array_push($message_rows, $username_row);
                    break;
                case 'email':
                    $email_row = sprintf('%s:%s', __('Email', 'mobiweb-isms'), $email);
                    array_push($message_rows, $email_row);
                    break;
                case 'full_name':
                    $full_name_row = sprintf('%s:%s', __('Full Name', 'mobiweb-isms'), $full_name);
                    array_push($message_rows, $full_name_row);
                    break;
                case 'website':
                    $website_row = sprintf('%s:%s', __('Website', 'mobiweb-isms'), $website);
                    array_push($message_rows, $website_row);
                    break;
                case 'role':
                    $role_row = sprintf('%s:%s', __('Role', 'mobiweb-isms'), $role);
                    array_push($message_rows, $role_row);
                    break;
            }
        }
        
        $message = sprintf('%s%s%s', __('New user created', 'mobiweb-isms'), PHP_EOL, implode(PHP_EOL, $message_rows));
        
        $this->send_isms($message);
    }
    
    public function alert_insert_comment($comment_id, $comment_object) {
        if (get_option('setting_new_comment_enabled') == "0") {
            return;
        }
        
        $name = sanitize_text_field($comment_object->comment_author);
        $email = sanitize_email($comment_object->comment_author_email);
        $website = sanitize_text_field($comment_object->comment_author_url);
        $date = $comment_object->comment_date;
        $content = sanitize_text_field($comment_object->comment_content);
        
        $message_rows = array();
        $parameters = get_option('setting_new_comment_parameters');
        
        foreach ($parameters as $key => $value) {
            switch ($key) {
                case 'name':
                    $name_row = sprintf('%s:%s', __('Name', 'mobiweb-isms'), $name);
                    array_push($message_rows, $name_row);
                    break;
                case 'email':
                    $email_row = sprintf('%s:%s', __('Email', 'mobiweb-isms'), $email);
                    array_push($message_rows, $email_row);
                    break;
                case 'website':
                    $website_row = sprintf('%s:%s', __('Website', 'mobiweb-isms'), $website);
                    array_push($message_rows, $website_row);
                    break;
                case 'date':
                    $date_row = sprintf('%s:%s', __('Date', 'mobiweb-isms'), $date);
                    array_push($message_rows, $date_row);
                    break;
                case 'content':
                    $content_row = sprintf('%s:%s', __('Content', 'mobiweb-isms'), $content);
                    array_push($message_rows, $content_row);
                    break;
            }
        }
        
        $message = sprintf('%s%s%s', __('New comment added', 'mobiweb-isms'), PHP_EOL, implode(PHP_EOL, $message_rows));
        
        $sms_limit = get_option('setting_new_comment_sms_limit');
        $message = $this->trim_message($message, $sms_limit);
        
        $this->send_isms($message);
    }
    
    public function alert_login($user_login, $user) {
        if (get_option('setting_login_enabled') == "0") {
            return;
        }
        $name = $user->data->user_login;
        
        $message = sprintf('%s %s', $name, __('has logged in'));
        
        $this->send_isms($message);
    }
    
    private function trim_message($message, $sms_limit) {
        if ($sms_limit == 1) {
            $message_length = 153;
        } else {
            $message_length = 152;
        }
        $message = substr($message, 0, $message_length * $sms_limit);
        if (mb_strlen($message) > 900) {
            $message = substr($message, 0, 900);
        }
        return $message;
    }
    
    private function send_isms($message) {
        $result = Mobiweb_ISMS_Model::send_isms(get_option('setting_admin_phone_number'), $message, get_option('setting_message_type'));
        if ($result['code'] != '2000') {
            add_notice("iSMS Error : " . $result['message']);
        }
    }
}