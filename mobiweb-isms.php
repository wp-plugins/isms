<?php
/**
 * Plugin Name: iSMS
 * Plugin URI:
 * Description: iSMS integration for WordPress
 * Version: 1.0
 * Author: Mobiweb
 * Author URI: support@mobiweb.com.my
 * License: GPL2
 */
/**
 * Copyright 2015  Mobiweb  (email : support@mobiweb.com.my)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 
   require_once(plugin_dir_path(__FILE__) . 'includes/admin-notice-helper/admin-notice-helper.php');
 
   require_once(plugin_dir_path(__FILE__) . 'mobiweb-isms-model.php');
   require_once(plugin_dir_path(__FILE__) . 'mobiweb-isms-alert.php');
   require_once(plugin_dir_path(__FILE__) . 'mobiweb-isms-send.php');
   require_once(plugin_dir_path(__FILE__) . 'mobiweb-isms-settings.php');
 
   class Mobiweb_ISMS {
      protected $alert;
      protected $send;
      protected $settings;
      
      /**
       * Construct the plugin object
       */
      public function __construct() {
         $this->load_dependencies();
         $this->define_admin_hooks();
      }
      
      private function load_dependencies() {
         $this->alert = new Mobiweb_ISMS_Alert();
         $this->send = new Mobiweb_ISMS_Send();
         $this->settings = new Mobiweb_ISMS_Settings();
      }
      
      private function define_admin_hooks() {
         add_action('admin_init', array($this, 'admin_init'));
         add_action('admin_menu', array($this, 'add_menu'));
         add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
      }
      
      /**
       * Activate the plugin
       */
      public static function activate() {
         // Do nothing
      }
      
      /**
       * Deactivate the plugin
       */
      public static function deactivate() {
         // Do nothing
      }
      
      /**
       * hook into WP's admin_init action hook
       */
      public function admin_init() {
         // Set up the settings for this plugin
         $this->settings->init_settings();
         // Possibly do additional admin_init tasks
      }
      
      /**
       * add a menu
       */
      public function add_menu() {
         $this->send->add_menu_send();
         $this->settings->add_menu_settings();
      }
      
      /**
       * Add a widget to the dashboard
       *
       * This function is hooked into the 'wp_dashboard_setup'
       */
      public function add_dashboard_widget() {
         if (current_user_can('manage_options')) {
            wp_add_dashboard_widget(
               'mobiweb_isms_dashboard_widget',
               'iSMS',
               array($this, 'dashboard_widget_callback')
            );
         }
      }
      
      /**
       * Create the function to output the contents of our Dashboard Widget
       */
      public function dashboard_widget_callback() {
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
   }
 
 if (class_exists('Mobiweb_ISMS')) {
   // Installation and uninstallation hooks
   register_activation_hook(__FILE__, array('Mobiweb_ISMS', 'activate'));
   register_deactivation_hook(__FILE__, array('Mobiweb ISMS', 'deactivate'));
   
   // instantiate the plugin class
   $mobiweb_isms = new Mobiweb_ISMS();
   
   // Add a link to the settings page onto the plugin page
   if (isset($mobiweb_isms)) {
      // Add the settings link to the plugin page
      function mobiweb_isms_settings_link($links) {
         $settings_link = '<a href="options-general.php?page=isms_plugin_settings">Settings</a>';
         array_unshift($links, $settings_link);
         return $links;
      }
      
      $plugin = plugin_basename(__FILE__);
      add_filter("plugin_action_links_$plugin", 'mobiweb_isms_settings_link');
   }
 }
 
 ?>