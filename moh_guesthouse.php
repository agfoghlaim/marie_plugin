<?php 
/*
Plugin Name: moh_guesthouse
Plugin URI: localhost
Description: description
Author: Marie
Version: 1.0

*/


if( ! defined( 'ABSPATH')){
  exit;
}

//add moh-guesthouse-custom-post
require (plugin_dir_path(__FILE__) . 'moh-guesthouse-custom-post.php');
require (plugin_dir_path(__FILE__) . 'moh-guesthouse-fields.php');
require (plugin_dir_path(__FILE__) . 'moh-charge.php');
require (plugin_dir_path(__FILE__) . 'stripe-php-4.7.0/init.php');


function moh_admin_enqueue_scripts(){

  wp_enqueue_style( 'moh_enqueue_style', plugins_url('css/moh-style.css', __FILE__ ) );
  wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css' );
  wp_register_script( 'moh_global_js', plugin_dir_url( __FILE__).'/js/global.js',  array('jquery', 'jquery-ui-datepicker'), '1', true );   
  wp_localize_script('moh_global_js', 'myAjax', array(
      'security' => wp_create_nonce('wp_rooms_action'),
      'ajaxurl'  => admin_url('admin-ajax.php')
      ));
  wp_enqueue_script('jquery');
  wp_enqueue_script('moh_global_js');
}
add_action('init', 'moh_admin_enqueue_scripts' );


/*===================for book individual room page================ */

  //get guest info from form and add to db
  function moh_ajax_guest_info(){
    if(! check_ajax_referer('wp_rooms_action', 'security_info')){
      echo "info nonce notok";
    }else{
      echo "info nonce ok";
    }
   // echo $arr;
   // echo $_POST['dep'];
    $arr = $_POST['checkin'];
    $dep = $_POST['checkout'];
    $fn=$_POST['fname'];
    $ln=$_POST['lname'];
    $em=$_POST['email'];
    $ad=$_POST['address'];
    $country=$_POST['country'];
    $phone=$_POST['phone'];
    $postcode=$_POST['postcode'];
    $adults=$_POST['no_adults'];
    $children =$_POST['no_children'];
    $arr_time=$_POST['arr_time'];
    $room_no = $_POST['rm_num'];

     //$rm_no = $_POST['rm_no'];
        global $wpdb,$wp_query;;
$sql = "SELECT actual_rm_no from wp_rooms where rm_id = '$room_no'";
$get_room = $wpdb->get_results($sql);
if($get_room){echo "got room";}else{echo "didn't get room";}
foreach($get_room as $the_room){
          $the_actual_room = $the_room->actual_rm_no;
        }


    global $wpdb;
     $add_guest = $wpdb->insert('wp_guests', array(
    'fname' => $fn,
    'lname' => $ln,
    'email' => $em,
    'address' => $ad,
    'country' => $country,
    'postcode' => $postcode,
    'phone' => $phone,
    'no_adults' => $adults,
    'no_children' => $children,
    'arrival' => $arr_time
    ));
     $guest = $wpdb->insert_id;

     if($add_guest){
      echo $fn . " added, guest id is (secret) " . $guest;
      echo "<p>arr: " . $arr . "</p>";
      echo "<p>dep: ".$dep."</p>";
      echo "<p>guest: ".$guest."</p>";
     }else{
      echo $fn . " not added";
     }
    // $room_no=$wpdb->get_results()
   



     //booking query
     $book_query = $wpdb->insert('wp_bookings', array(
        'guest_id' => $guest,
        'checkin' => $arr,
        'checkout'=> $dep,
        'room_no'=> $the_actual_room

      ));

     

     if($book_query){
      $booking_id = $wpdb->insert_id;
      echo "booking id is: " . $booking_id;
      echo "booked";
     }
     else{
      echo "not booked";
     }
   
    die();

  }
  add_action('wp_ajax_nopriv_moh_ajax_action_guest_info', 'moh_ajax_guest_info');
  add_action('wp_ajax_moh_ajax_action_guest_info', 'moh_ajax_guest_info');
        
//get arrival, departure date,room no from localStorage
  add_action('wp_ajax_nopriv_moh_ajax_action_get_details', 'moh_ajax_get_details');
  add_action('wp_ajax_moh_ajax_action_get_details', 'moh_ajax_get_details');

  //for bookroom, get room no id from localStorage via global.js ajax
  function moh_ajax_get_details(){
    if(! check_ajax_referer('wp_rooms_action', 'security_rm')){
        echo "nonce notok";
    }else{
        echo "nonce ok";
    }

//echo "<h1>".$the_actual_room."</h1>";
   
    echo "<p>booking rm_id " . $rm_no . " " . $the_actual_room . " from ";
    echo $_POST['arr'] . " until ";
    echo $_POST['dep'] . "</p>";
    die();
    }

/*===================for check availabity and  select room================ */

//ajax for availabity query if statements set for testing only
add_action('wp_ajax_nopriv_moh_ajax_action', 'moh_ajax');
add_action('wp_ajax_moh_ajax_action', 'moh_ajax');

function moh_ajax(){
  if(! check_ajax_referer('wp_rooms_action', 'security')){
  echo "not aj referer";
  }else{
  echo "ajax referer ok";
  }
  if (isset($_POST['arrive'])){
    $arrive = $_POST['arrive'];
    $depart = $_POST['depart'];
  }

  global $wpdb, $wp_query;
  $bookings = $wpdb->prefix . 'bookings'; 
  $rooms = $wpdb->prefix.'rooms';
  $the_rooms = $wpdb->get_results( $wpdb->prepare(
    "SELECT distinct actual_rm_no, rm_type, amt_per_night, rm_id, rm_desc
     FROM $bookings, $rooms
      where $bookings.room_no = $rooms.actual_rm_no 
       and room_no not in(
                      select room_no from $bookings 
                      where checkin < %s
                      AND checkout > %s)", $depart, $arrive));
   
  $no_rooms = count($the_rooms);
  if($no_rooms > 0){
        echo "<p>" . $no_rooms . " rooms available for your chosen dates. </p>";

        foreach($the_rooms as $the_room){
          $rm_id = $the_room->rm_id;
          
          $test_pic = get_the_post_thumbnail($rm_id,'thumbnail');
          echo "<h3>" . $the_room->rm_type . "</h3>";
          echo "<div class='post-thumbnail'>" . $test_pic . "</div>";
          echo "<p>Room No: " . $the_room->actual_rm_no . "(room thumbnails can be changed by going to the 'Room' post for room " .$the_room->actual_rm_no . " ).</p>";
          echo "<h5>" .$the_room->amt_per_night. " per night.</h5>";
          echo "<p>" .$the_room->rm_desc. "<p/>";
          //echo "<button class='get-the-room' id='book-".$rm_id . "'>Book This " . $the_room->rm_type . "</button>";
         // echo "<a href='book-room-".$the_room->actual_rm_no . "'>Book This " . $the_room->rm_type . "</a>";
          ?>
          <button  class="get-the-room" id="what" value="<?php echo $rm_id; ?>" >Select This Room</button>
          <form action="book-room-101">
            <input id="show-booking-button" type="submit" style="display:none;" value="Book Now" />
          </form>
         <!--  <button  class="moh-show-form" id="moh-show-form" >Test Ajax Button</button> -->
          
          <div id="moh-booking-div" style="display:none"></div>
          
          
          <?php



        }
  }else {
    echo "<p>Sorry, no rooms available on your selected dates.</p>";
  }
die();

}

/*===================end for check availabity and  select room================ */













 
/*===================for general and admin ================ */  






//create menu item
            function moh_guesthouse_create_menu() {               
            // create custom top-level men u    
                add_menu_page(
                'MOH Guesthouse Settings',
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
       <input type="hidden" name="action" value="moh_ajax_action" />

 <?php //wp_nonce_field( 'moh_ajax_action', 'moh_check_avail_nonce' ); 
 wp_nonce_field( 'moh_ajax', 'moh_avail_nonce');
 ?>
		</div>
		<?php

	}

}

//initialise widget
add_action('widgets_init', function(){
	register_widget('moh_guesthouse');
});



?>

