<?php
/*
 * Plugin Name: Gravity Forms IR Mobile add-on
 * Plugin URI: https://github.com/mahdi-seifi/Gravity-Forms-IR-Mobile-add-on
 * Description: فرمت شماره موبایل ایران برای فیلد موبایل گرویتی فرم و جلوگیری کردن از ورود کاراکتر حروف در فیلد تلفن
 * Author: Mohammad Mahdi Seifi
 * Version: 1.1.0
 * Author URI:  https://safedesign.company/
*/

defined('ABSPATH') || exit('NO ACCESS');

// define constants for gfim
define('gfim_DIR',trailingslashit(plugin_dir_path(__FILE__)));
define('gfim_URL',trailingslashit(plugin_dir_url(__FILE__)));


// write activation && deactivation hook'callback
function gfim_activate(){}
function gfim_deactivate(){}
register_activation_hook(__FILE__,'gfim_activate');
register_deactivation_hook(__FILE__,'gfim_deactivate');


/***** Add Iran Phone Format in Gravity Form ************/
add_filter('gform_phone_formats', 'ir_phone_format');
function ir_phone_format($phone_formats)
{
    $phone_formats['ir'] = array(
        'label' => 'IR',
        'mask' => false,
        'regex' => '/^(\+98|0|098|)?9\d{9}$/',
        'instruction' => 'لطفا شماره همراه را در فرمت صحیح وارد کنید ',
    );

    return $phone_formats;
}

function add_gf_IR_mobile_script_footer(){
    ?>
    <script>
        jQuery(document).ready(function () {

            if (jQuery('.ginput_container_phone input').length ) {

                var myinput=jQuery('.ginput_container_phone input');
                // for max 11
                myinput.attr('maxlength',11);

                //for
                myinput.keyup(function(e)
                {
                    if (/\D/g.test(this.value))
                    {
                        // Filter non-digits from input value.
                        this.value = this.value.replace(/\D/g, '');
                    }
                });
            }

        });
    </script>
    <?php
}

function gf_IR_mobile_script_initialize(){
    add_action('wp_footer', 'add_gf_IR_mobile_script_footer');
}

add_action( 'gform_enqueue_scripts', 'gf_IR_mobile_script_initialize', 10, 2 );