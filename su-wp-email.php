<?php
/*
Plugin Name: Su WP Email
Description: Just a plugin which will change default wordpress@domain.com to anything you wish.
Version: 1.0.0
Author: Suson Waiba
Author URI: http://www.susonwaiba.com
License: GPL2

== Copyright ==
Copyright 2017 Suson Waiba (www.susonwaiba.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/



add_action('admin_menu', 'su_wp_email_setup');

function su_wp_email_setup()
{
    add_submenu_page('options-general.php', 'Su WP Email', 'Su WP Email', 'administrator', 'su-wp-email', 'su_wp_email_bootstrap');
    add_action('admin_init', 'register_su_wp_email_settings');
}

function register_su_wp_email_settings()
{
    register_setting('su-wp-email', 'su_wp_email_name');
    register_setting('su-wp-email', 'su_wp_email_address');
}

function su_wp_email_bootstrap()
{

    if(isset($_GET['test-email'])) {
        $test_email = htmlspecialchars($_GET['test-email']);
        $headers = array('Content-Type: text/html; charset=UTF-8');
        // wp_mail( $test_email, 'Just a test email from Wordpress', "Hi there,\nThis is just a test email send from Su WP Email Plugin.", $headers );
        ?>
        <div class="wrap">
            <h1>Su WP Email</h1>
            <div class="card" style="max-width: 100%;">
                <h4>Test Email has been send to "<strong><?php echo $test_email; ?></strong>"</h4>
                <a class="button button-primary" href="<?php echo admin_url('admin.php?page=su-wp-email'); ?>">Back to settings</a>
            </div>
        </div>
        <?php
        die();
    };
    ?>
    <div class="wrap">
        <h1>Su WP Email</h1>

        <div class="card" style="max-width: 100%;">
            <h2>Enter Email that you want to change to:</h2>
            <?php
            if ( isset( $_GET['settings-updated'] ) ) {
                add_settings_error( 'su-wp-email-settings-messages', 'su-wp-email-settings-message', __( 'Settings Saved', 'su-wp-email-settings' ), 'updated' );
            }
            settings_errors( 'su-order-settings-messages' );
            ?>
            <form method="post" action="options.php">
                <?php settings_fields( 'su-wp-email' ); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="su-wp-email-name">Name</label>
                            </th>
                            <td>
                                <input name="su_wp_email_name" type="text" id="su-wp-email-name" class="regular-text" value="<?php echo esc_attr( get_option('su_wp_email_name') ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="su-wp-email-address">Email</label>
                            </th>
                            <td>
                                <input name="su_wp_email_address" type="email" id="su-wp-email-address" class="regular-text" value="<?php echo esc_attr( get_option('su_wp_email_address') ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td><?php submit_button(); ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php settings_fields( 'su-wp-email' ); ?>

            </form>
        </div>

        <div class="card" style="max-width: 100%;">
            <form method="GET" action="<?php echo admin_url('options-general.php'); ?>">
                <input type="hidden" name="page" value="su-wp-email">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="test-email">Test Email</label>
                            </th>
                            <td>
                                <input name="test-email" type="email" id="test-email" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td><input class="button button-primary" type="submit" name="submit" value="Send Test Email"></td>
                        </tr>
                    </tbody>
                </table>

            </form>
        </div>

    </div>
    <p>- Just a plugin which will change default wordpress@domain.com to anything you wish.<br>- by: Suson Waiba</p>
    <?php
}


if (!empty(esc_attr( get_option('su_wp_email_address'))) && !empty(esc_attr( get_option('su_wp_email_name'))))
{
    add_filter('wp_mail_from', 'new_mail_from');
    add_filter('wp_mail_from_name', 'new_mail_from_name');
    
    function new_mail_from($old) {
        return esc_attr( get_option('su_wp_email_address'));
    }
    function new_mail_from_name($old) {
        return esc_attr( get_option('su_wp_email_name'));
    }
}