<?php
define( 'SHORTINIT', true );

require( '../../../../wp-load.php' );

if (isset($_POST['arrive'])){
	
	
	$arrive = $_POST['arrive'];
	$depart = $_POST['depart'];
 
}

global $wpdb;
//$testit = new WP_Query($testing);
$testing = $wpdb->get_results("SELECT * FROM wp_bookings");
//$test_insert = wpdb->
print_r($testing);
echo $testing;

$tablename = $wpdb->prefix . 'bookings';       
 //  Insert a recor d 
$newdata = array( 'checkin' =>  $arrive,
                  'checkout' => $depart); 

$workin = $wpdb->insert($tablename , $newdata );  
if($workin){
  echo "<p>ok</p>";
}else{
  echo "<h1>not</h1>";
}


// $query = "SELECT DISTINCT rm_no, description, amount 
//                  from bookings, room_type, rooms
//                 where bookings.rm_no = rooms.rm_id 
//                 and rooms.rm_type = room_type.rm_type_id
//                 and rm_no not in(
//                     select rm_no from bookings 
//                     where booking_date < '$depart'
//                     AND checkout > '$arrive')";


?>