<?php

class Mobiweb_ISMS_Model {
    // iSMS API
    protected static $api_balance = 'https://www.isms.com.my/isms_balance.php';
    protected static $api_send = 'https://www.isms.com.my/isms_send.php';
    
    public static function get_balance() {
        $username = get_option('setting_username');
        $password = get_option('setting_password');
        
        $link = self::$api_balance.'?';
        $link .= "un=".urlencode($username);
        $link .= "&pwd=".urlencode($password);
        
        $response = wp_remote_get($link);
        $result = $response[body];
        $balance = (float)$result;
                
        if ($balance < 0) return substr($result, 8);
        else return $result;
    }
    
    public static function send_isms($destination, $message, $messageType, $senderID = '') {
        $username = get_option('setting_username');
        $password = get_option('setting_password');
        
        $link = self::$api_send.'?';
        $link .= "un=".urlencode($username);
        $link .= "&pwd=".urlencode($password);
        $link .= "&dstno=".urlencode($destination);
        $link .= "&msg=".urlencode($message);
        $link .= "&type=".urlencode($messageType);
        $link .= "&sendid=".urlencode($senderID);
        
        $response = wp_remote_get($link);
        try {
            $result = $response[body];
                    
            $resultValue = (float)$result;
            if ($resultValue < 0) {
                return array(
                    'code'=>$resultValue,
                    'message'=>substr($result, 8)
                );
            } else {
                return array(
                    'code'=>'2000',
                    'message'=>$result
                );
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            return array(
                'code'=>'-9999',
                'message'=>$message
            );
        }
    }
}