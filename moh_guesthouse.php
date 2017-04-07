<?php 
/*
Plugin Name: moh_guesthouse
Plugin URI: localhost
Description: description
Author: Marie
Version: 1.0

*/

//exit if directly accessed not by wp
if( ! defined( 'ABSPATH')){
  exit;
}

//add moh-guesthouse-custom-post
require (plugin_dir_path(__FILE__) . 'moh-guesthouse-custom-post.php');
require (plugin_dir_path(__FILE__) . 'moh-guesthouse-fields.php');




//enqueue scripts
//add_action( 'wp_enqueue_scripts', 'divi_child_moh_guesthouse');




//create menu item
            function moh_guesthouse_create_menu() {               
            // create custom top-level men u    
                add_menu_page('MOH Guesthouse Settings',
                'MOH GUESTHOUSE',
                'manage_options',
                'moh_guesthouse/moh_guesthouse-admin.php',
                '',
                '',
                4);     
            } 

           

add_action( 'admin_menu', 'moh_guesthouse_create_menu' ) ;


//add tables to db
register_activation_hook( __FILE__, 'moh_install' );
//register_activation_hook( __FILE__, 'moh_install_data' );

function moh_install () {
   global $wpdb;

   $charset_collate = $wpdb->get_charset_collate();

  $table_name = $wpdb->prefix . 'bookings';

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
  booking_id mediumint(9) NOT NULL AUTO_INCREMENT,
  guest_id mediumint(9) NOT NULL,
  checkin datetime DEFAULT '0000-00-00' NOT NULL,
  checkout datetime DEFAULT '0000-00-00' NOT NULL,
  room_no mediumint(9),
  no_nights mediumint(9),
  room_type_requested varchar(55) DEFAULT '' NOT NULL,
  no_adults mediumint(9),
  no_children mediumint(9),
  PRIMARY KEY  (booking_id),
  KEY guest_id (guest_id),
  KEY room_no (room_no)
) $charset_collate;

CREATE TABLE wp_guests (
  guest_id mediumint(9) NOT NULL AUTO_INCREMENT,
  fname varchar(55) NOT NULL,
  lname varchar(55) NOT NULL,
  email varchar(55) NOT NULL,
  address varchar(255) NOT NULL,
  country varchar(55),
  postcode varchar(55),
  phone varchar(55),
  no_adults mediumint(9),
  no_children mediumint(9),
  arrival varchar(9),
  PRIMARY KEY  (guest_id)
) $charset_collate;

CREATE TABLE wp_rooms (
  rm_id mediumint(9) NOT NULL,
  rm_type varchar(55) NOT NULL,
  rm_type_id mediumint(9) NOT NULL,
  amt_per_night varchar(55),
  max_occup mediumint(9),
  PRIMARY KEY  (rm_id),
  KEY rm_type_id (rm_type_id)
) $charset_collate;

CREATE TABLE wp_room_type (
  room_type_id mediumint(9) NOT NULL,
  description varchar(55) NOT NULL,
  post_id_wp mediumint(9),
  PRIMARY KEY  (room_type_id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}




//widgetize


class moh_guesthouse extends WP_Widget{
	function __construct(){
		parent::__construct(false, $name = __('MOH Guesthouse'));

	}

	function form(){

	}

	function update(){

	}
//output widget info
	function widget($args, $instance){
		?>
		<div class="widget check-avail">
			<h4>Marie Book Now</h4>
			<?php include 'moh-index.php';?>
			<!--start
				Name: <input type="text" id="name" name="name">
				Arrive: <input type="date" id="arrive" name="arrive">
				depart: <input type="date" id="depart" name="depart">
				<input type="submit" id="name-submit" value="Grab">
				<div id="name-data">data</div>	
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
				<script type="text/javascript" src="js/global.js"></script>
			end-->
		</div>
		<?php

	}

}

//initialise widget
add_action('widgets_init', function(){
	register_widget('moh_guesthouse');
});



?>

