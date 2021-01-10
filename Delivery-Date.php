<?php
/**
 * Plugin Name: Delivery Date
 * Description: Displays the estimated delivery time on the product page.
 * Version: 1.0
 * Author: Adiel Ben Moshe
 * Requires at least: 5.3
 * License: GPLv3 or later License
 * Requires PHP: 7.0
 * WC requires at least: 2.2
 * WC tested up to: 2.3
 * 
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */



if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {





/*    Setting - menu    */
 
add_action( 'admin_menu', 'dd_admin_add_page' );
function dd_admin_add_page() {
	add_submenu_page('woocommerce', 'Delivery Date Page', 'Delivery Date', 'manage_options', 'dd', 'dd_options_page' );
 
}
 
function dd_options_page() {
	?>
		<div class="wrap">
			<h2>Delivery Date</h2>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'dd' ); 
				do_settings_sections( 'dd' ); 
				submit_button(); 
				?>
 			</form>
		</div>
	<?php
	}


	
/*  Setting - section & fields   */


add_action( 'admin_init', 'dd_admin_init' );

function dd_admin_init(){

	// Create section of Page
	$settings_section = 'dd_main';
	$option_group_and_page = 'dd';
	add_settings_section( $settings_section, 'Delivery Date Setting', 'dd_main_section_text_output', $option_group_and_page );


	// Create Settings:

	// 1. Business Days Number
	$option_name = 'dd_business_days';
	register_setting( $option_group_and_page, $option_name, array('default' => 3 ) );
	add_settings_field( $option_name, 'Business Days for Delivery', 'dd_business_days_input_renderer', $option_group_and_page, $settings_section );

	// 2. Active Days: 

	// Sunday
	register_setting( $option_group_and_page, 'dd_active_days_sunday', array('default' => 1) );
	add_settings_field( 'dd_active_days_sunday', 'Sunday', 'dd_active_days_sunday_input_renderer', $option_group_and_page, $settings_section );
 
	// Monday
 	register_setting( $option_group_and_page, 'dd_active_days_monday' );
	add_settings_field( 'dd_active_days_monday', 'Monday', 'dd_active_days_monday_input_renderer', $option_group_and_page, $settings_section );

	// Tuesday
	register_setting( $option_group_and_page, 'dd_active_days_tuesday' );
	add_settings_field( 'dd_active_days_tuesday', 'Tuesday', 'dd_active_days_tuesday_input_renderer', $option_group_and_page, $settings_section );

	// Wednesday  
	register_setting( $option_group_and_page, 'dd_active_days_wednesday' );
	add_settings_field( 'dd_active_days_wednesday', 'Wednesday', 'dd_active_days_wednesday_input_renderer', $option_group_and_page, $settings_section );

	// Thursday 
	register_setting( $option_group_and_page, 'dd_active_days_thursday' );
	add_settings_field( 'dd_active_days_thursday', 'Thursday', 'dd_active_days_thursday_input_renderer', $option_group_and_page, $settings_section );

	// Friday
	register_setting( $option_group_and_page, 'dd_active_days_friday' );
	add_settings_field( 'dd_active_days_friday', 'Friday', 'dd_active_days_friday_input_renderer', $option_group_and_page, $settings_section );

	// Saturday 
	register_setting( $option_group_and_page, 'dd_active_days_saturday' );
	add_settings_field( 'dd_active_days_saturday', 'Saturday', 'dd_active_days_saturday_input_renderer', $option_group_and_page, $settings_section );



	// 3. Text before date

	register_setting( $option_group_and_page, 'dd_message_string' );
	add_settings_field( 'dd_message_string', 'Text before date', 'dd_message_string_input_renderer', $option_group_and_page, $settings_section );
	
}



/*   Callback Functions for Setting   */


// Section
function dd_main_section_text_output() {
	echo "<p>First, select the number of business days for delivery.</p><p>
	And then you will define on which days of the week your business works.</p>";
}

// 1. Business Days Number
function dd_business_days_input_renderer() {
	echo '<input type="number" min="1" id="dd_business_days" value="'.get_option('dd_business_days', '5').'" name="dd_business_days">';
	echo '<p class="description">Number of business days for delivery.</p>';
}



// 2. Active Days: 
	
// Sunday
function dd_active_days_sunday_input_renderer() {
	echo '<input type="checkbox" id="dd_active_days_sunday_input" name="dd_active_days_sunday" value="1"'; 
	checked(1, get_option('dd_active_days_sunday', '1'), true);
	echo ' />';
}
 
// Monday 
function dd_active_days_monday_input_renderer() {
	echo '<input type="checkbox" id="dd_active_days_monday_input" name="dd_active_days_monday" value="1"';
	checked(1, get_option('dd_active_days_monday', '1'), true);
	echo ' />';
}
 
// Tuesday 
function dd_active_days_tuesday_input_renderer() {
	echo '<input type="checkbox" id="dd_active_days_tuesday_input" name="dd_active_days_tuesday" value="1"'; 
	checked(1, get_option('dd_active_days_tuesday', '1'), true);
	echo ' />';
}

// Wednesday 
function dd_active_days_wednesday_input_renderer() {
	echo '<input type="checkbox" id="dd_active_days_wednesday_input" name="dd_active_days_wednesday" value="1"'; 
	checked(1, get_option('dd_active_days_wednesday', '1'), true);
	echo ' />';
}
 
// Thursday  
function dd_active_days_thursday_input_renderer() {
	echo '<input type="checkbox" id="dd_active_days_thursday_input" name="dd_active_days_thursday" value="1"';
	checked(1, get_option('dd_active_days_thursday', '1'), true);
	echo ' />';
}
 
// Friday  
function dd_active_days_friday_input_renderer() {
	echo '<input type="checkbox" id="dd_active_days_friday_input" name="dd_active_days_friday" value="1"'; 
	checked(1, get_option('dd_active_days_friday', '0'), true);
	echo ' />';
}

// Saturday 
function dd_active_days_saturday_input_renderer() {
	echo '<input type="checkbox" id="dd_active_days_saturday_input" name="dd_active_days_saturday" value="1"'; 
	checked(1, get_option('dd_active_days_saturday', '0'), true);
	echo ' />';
}

// Saturday 
function dd_message_string_input_renderer() {
	echo '<input type="text" id="dd_message_string_input" name="dd_message_string" value="'.get_option('dd_message_string').'">'; 
}



 /*          Get Active Days as Array         */ 


function dd_fiter_days($item_values) {
if ($item_values == 1)
{
return true;
}
return false;
}

$dd_active_days = array(0 => get_option('dd_active_days_sunday', '1'), 				/*  sunday = 0, monday = 1, etc  */ 
						1 => get_option('dd_active_days_monday', '1'), 
                        2 => get_option('dd_active_days_tuesday', '1'), 
                        3 => get_option('dd_active_days_wednesday', '1'),
 						4 => get_option('dd_active_days_thursday', '1'),
                        5 => get_option('dd_active_days_friday', '0'), 
                        6 => get_option('dd_active_days_saturday', '0')
                        );

 
$dd_active_days = array_filter($dd_active_days,"dd_fiter_days");

$dd_active_days = array_keys($dd_active_days);



 /*          Delivery Date          */ 

function adiel_delivery_date() {

	global $dd_active_days;

	$business_days = get_option('dd_business_days', '5');

	$today =  wp_date('w'); 

	$hour = wp_date('H');       

	$past_business_days = 0;
/*
	if ( in_array($today, $dd_active_days) && $hour < 14 ) {
		$past_business_days++;
	}
*/
	$days_to_add = 1;

	while ($past_business_days < $business_days ) {

		$strtotime_string = '+'.$days_to_add." day";

		$ship_date = wp_date('w', strtotime($strtotime_string));

		if ( in_array($ship_date, $dd_active_days) ) {
			$past_business_days++;
		}

		$days_to_add ++;

	}

	$ship_date =  wp_date('l j/m', strtotime($strtotime_string));        

	echo "<br><div class='woocommerce-message' style='clear:both'>";

	$message_string = get_option('dd_message_string', 'Estimated Delivery Date:');
	 
	echo $message_string." "; 
 
	echo $ship_date;
	 
	echo "</div>";

}

add_action( 'woocommerce_before_add_to_cart_button', 'adiel_delivery_date');
 


 

 

// Link to settings page from plugins screen
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

function add_action_links ( $links ) {
	$mylinks = '<a href="admin.php?page=dd">Settings</a>';
	array_push($links, $mylinks );
	return $links;
}

 

 

} // end check woocommerce





 // plugin uninstallation
register_uninstall_hook( __FILE__, 'dd_function_uninstall' );

function dd_function_uninstall() {

	delete_option( 'dd_business_days' );

	delete_option( 'dd_active_days_sunday' );
	delete_option( 'dd_active_days_monday' );
	delete_option( 'dd_active_days_tuesday' );
	delete_option( 'dd_active_days_wednesday' );
	delete_option( 'dd_active_days_thursday' );
	delete_option( 'dd_active_days_friday' );
	delete_option( 'dd_active_days_saturday' );
	
	delete_option( 'dd_message_string' );

}