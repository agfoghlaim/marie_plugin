// <?php

// define( 'SHORTINIT', true );

// require( '../../../../wp-load.php' );

// //require( '../../../../wp-blog-header.php' );

// if (isset($_POST['arrive'])){
	
	
// 	$arrive = $_POST['arrive'];
// 	$depart = $_POST['depart'];
 
// }

// global $wpdb, $wp_query;
// $tablename = $wpdb->prefix . 'bookings'; 
// $the_rooms = $wpdb->get_results( $wpdb->prepare(
// 	"SELECT distinct room_no, rm_type, amt_per_night, rm_id
//  	 FROM wp_bookings, wp_rooms
//     where wp_bookings.room_no = wp_rooms.actual_rm_no 
//      and room_no not in(
//                     select room_no from wp_bookings 
//                     where checkin < %s
//                     AND checkout > %s)", $depart, $arrive)); 
// //foreach($the_rooms as $the_room){
// 		echo "<h1>this is the query" . $the_room->room_no . "<h1>";
// 		echo "<h1>this is the query" . $the_room->rm_id . "<h1>";
// 		$loop = new WP_Query($args);
// 		$args = array( 'post_type' => 'room', 'posts_per_page' => 10 );
// 		//$loop = new wp_query( $args );
// 		while ( $loop->have_posts() ) : $loop->the_post();
//   		the_title();
//   		echo '<div class="entry-content">';
//   		the_content();
//   		echo '</div>';
// 		endwhile;
// 		// global $post;
// 		// $what = $the_room->rm_id;
// 		// get_post($what);
				
// 		// 	//$queried_post = new WP_Query;
// 		// $args = array(
// 		// 	'post_type'=>'post',
// 		// 	);
// 		// $avail_rooms = new WP_Query($args);
// 		// //$queried_post=get_post($the_room->rm_id);
// 		// 	 echo "<pre>this";
// 		// 	// //echo $queried_post->post_title;
// 		// 	 var_dump($avail_rooms);
// 		// 	// //echo $queried_post->post_content;

// 		// 	 echo "</pre>";

	
// //}

// ?>