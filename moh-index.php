<!DOCTYPE html>
<html>
	<head>
		<title>ajaxing</title>
	</head>
	<body><?//php echo esc_url( admin_url('admin-post.php') );?>
		<form action="" method="post">
		<?php wp_nonce_field( basename(__FILE__), 'moh_check_availabity')?>
		<input type="hidden" value="moh_avail_default" name="action">
		<label>Arrive:</label> 
		<input class="d" type="date" id="arrive" name="arrive">
		<label>Depart:</label> 
		<input class="datepicker" type="date" id="depart" name="depart">
		<label>Nights:</label> 
		<input type="number" min="1" max="14" id="num-nights" name="num-nights">
		<input type="submit" id="date-submit" name="avail-submit" value="Check Dates">
		<input type="text" id="xyz" style="display:none" name="<?php echo apply_filters( 'honey', 'date-submitted'); ?>" value="">
		<input type="submit" id="test-submit"  value="Test Check Dates">
		</form>
		<div id="date-data"></div>
		<p id="arr-err"></p>
		<p id="dep-err"></p>
		<p id="nights-err"></p>	
		<p id="show-nights"></p>
		
		<!--<script type="text/javascript" src="http://localhost/designassociates/marie_plugin/wp-content/plugins/moh_guesthouse/js/global.js"></script>-->
		<div id="show-rooms-info"></div>
        <div id="moh-booking-div" ></div>
        <div class="room-booking-button"></div>

	
	</body>

</html>
<?php

//Below checks availabity in case javaScript disabled. This needs more work
// if($_SERVER['HTTP_REFERER'] =='http://localhost/designassociates/marie_plugin/'){
// 	echo "the referer";

	if(!empty($_POST['date-submitted'])){
		    echo 'Server Says: honey fail' ;
		      echo "<h1>Marie o hara</h1>";
		  }
		   if (isset($_POST['arrive']) && isset($_POST['depart'])){
		    $arrive = sanitize_text_field($_POST['arrive']);
		    $depart = sanitize_text_field($_POST['depart']);

			      if(!moh_check_date_format($arrive) || !moh_check_date_format($depart)){
			        echo "Please enter arrival and departure dates in the format yyyy-mm-dd";
			        die();
			      }
//this validation needs work
			    $sixMonths = new dateTime('+6 months');
			    $twoWeeks = new dateTime('+2 weeks');
			    $now = date('Y-m-d');
			    $checkArr = date_create_from_format ( 'Y-m-d' , $arrive);
			    $checkDep = date_create_from_format ( 'Y-m-d' , $depart);
			    
			    if(strlen($arrive) !==10 || strlen($depart) !==10){
			      //wp_send_json_error('Server Says: Incorrect date format' );
			      echo 'Server Says: Incorrect date format';
			      die();
			    }
			    if($arrive < $now){
			      echo"Check your Arrival is in the future.</br>";
			      die();
			      //wp_send_json_error('Server Says: Oops, check Arrival Date is in the future.' );
			    }
			    if($arrive !== date_format($checkArr, 'Y-m-d') || $depart !== date_format($checkDep, 'Y-m-d')){
			    	die();
			        //wp_send_json_error('Server Says: Oops, check all dates are in the format yyyy-mm-dd.' );
			    }
			    if($arrive>$depart){
			      echo "Check your arrival date is before departure</br>";
			      die();
			     // wp_send_json_error('Server Says: Oops, check Arrival Date is before Departure Date.' );
			    }
			    if($arrive > $sixMonths){
			      echo "Sorry, we only accept bookings up to 6 months in advance</br>";
			      die();
			      //wp_send_json_error('Server Says: Sorry, we only accept bookings up to 6 months in advance.' );
			    }
			    if($depart-$arrive>date_format($twoWeeks,'Y-m-d')){
			     echo "Sorry, we only accept bookings of up to two weeks in duration.";
			     die();
			       //wp_send_json_error('Server Says: Sorry, we only accept bookings of up to two weeks in duration.' );
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
		      
		         
		        foreach($the_rooms as $the_room){
		        $rm_id = $the_room->rm_id;
		          $room_pic = get_the_post_thumbnail($rm_id,'thumbnail');
		          
		            echo "<h3>" . $the_room->rm_type . "</h3>";
		            echo"<p>".$the_room->actual_rm_no."</p>";
		            echo"<p>".$the_room->rm_desc."<p>";
		            echo"<h5>".$the_room->amt_per_night."</h5>";
		            //"room_id"=>$the_room->rm_id,
		            echo $room_pic; //sending the whole image tag
		            echo"<button class='get-the-room'  id='add-".$the_room->rm_id . "' value='".$the_room->rm_id . "'>select room</button>";
		            echo "<button class='remove-the-room' id='remove-".$the_room->rm_id . "' style='display:none;'  value='".$the_room->rm_id . "'>remove room</button>";
		            echo "<form action=''><input class='show-booking-button' type='submit' style='display:none;' value='Book Now' /></form>";
		            
		           
		          

		        }
		        //wp_send_json($testResponse);
		  }else {
		    echo "<p>Sorry, no rooms available on your selected dates.</p>";
		  }
		die();
			   

	}
//}

?>

