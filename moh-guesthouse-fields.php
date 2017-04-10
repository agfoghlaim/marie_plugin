<?php
//create custom meta box


function moh_guesthouse_custom_metabox(){

	add_meta_box(
		'moh_meta',
		'Room Type',
		'moh_meta_callback',
		'room',
		'normal',
		'high'

		);

	//add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

}
add_action('add_meta_boxes', 'moh_guesthouse_custom_metabox');

function moh_meta_callback($post){
	//wp_nonce_field( basename( __FILE__ ), 'moh_rooms_nonce');
	wp_nonce_field( 'moh_meta_save', 'moh_rooms_nonce');
	//get_post_meta($id, $key, true or false for return a string or an array);

	$moh_stored_meta = get_post_meta( $post->ID, '_room_id', true );
	$moh_stored_meta_room_type = get_post_meta( $post->ID, '_room_type', true );
	$moh_stored_meta_room_rate = get_post_meta( $post->ID, '_room_rate', true );
	$moh_stored_meta_room_description = get_post_meta($post->ID, '_room_description',true);
	echo "<h1> post id is: " .  $post->ID . "</h1>";
	?>

	<div id="moh-meta">

		<div class="meta-row">
			<div class="meta-th">
				<label for="room-id" class="moh-row-title">Room ID</label>
				<small>*This should always match the Post ID (see above).</small>	
			</div>
			<div class="meta-td">
				<input type="text" name="room-id" id="room-id" value="<?php
					echo esc_attr( $moh_stored_meta );
			 ?>">
			</div>
		</div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="room-type" class="moh-row-title">Room Type</label>	
			</div>
			<div class="meta-td">
				<input type="text" name="room-type" id="room-type" value="<?php echo esc_attr( $moh_stored_meta_room_type ); ?>">
			</div>
		</div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="room-rate" class="moh-row-title">Room Rate</label>	
				<small>enter room rate in cents €100 = 10000</small>
			</div>
			<div class="meta-td">
				<input type="text" name="room-rate" id="room-rate" value="<?php echo esc_attr( $moh_stored_meta_room_rate ); ?>">
			</div>
		</div>
	</div>
	<div class="meta">
		<div class="meta-th">
			<span>Room Description</span>
		</div>
	</div>
	<div class="meta-editor"></div>
	<?php
	$content = $moh_stored_meta_room_description;
	$editor_id = 'room-description';
	$settings = array(
		'textarea_rows'=>5,
		);
	wp_editor($content, $editor_id, $settings);
}

function moh_meta_save($post_id){

	if(! isset($_POST['moh_rooms_nonce'])){
		return;
	}
	if(! wp_verify_nonce( $_POST['moh_rooms_nonce'], 'moh_meta_save' )){
		return;
	}
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}

	if(!current_user_can('edit_post', $post_id)){
		return;
	}

	if(!isset($_POST['room-id'])){
		return;
	}
	if(!isset($_POST['room-type'])){
		return;
	}
	if(!isset($_POST['room-rate'])){
		return;
	}
	if(!isset($_POST['room-description'])){
		return;
	}
	$rm_id_data = sanitize_text_field($_POST['room-id'] );
	$rm_type_data = sanitize_text_field($_POST['room-type']);
	$rm_rate_data = sanitize_text_field($_POST['room-rate']);
	$rm_description_data = sanitize_text_field($_POST['room-description']);

	update_post_meta($post_id, '_room_id', $rm_id_data);
	update_post_meta($post_id, '_room_type', $rm_type_data);
	update_post_meta($post_id, '_room_rate', $rm_rate_data);
	update_post_meta($post_id, '_room_description', $rm_description_data);
	//update wp_rooms table with same info
	global $wpdb;
	global $post;
	$tablename = $wpdb->prefix . 'rooms';
	//chech wp_rooms
	// $check_rooms="SELECT * FROM '$tablename'
	// WHERE rm_id='$rm_id_data'";
	// $num_rows = $wpdb->query($check_rooms); 
	// if($num_rows >0){
	// 	//update mysql
	// 	$update_query = "UPDATE '$tablename'
	// 	SET rm_type='$rm_type_data'
	// 	WHERE rm_id='$rm_id_data";
	// 	$wpdb->query($update_query); 
	// }else{
	 //  Insert a record works
		// $newdata = array( 'rm_id' =>  $rm_id_data,
  //                 		  'rm_type' => $rm_type_data); 
		// $wpdb->insert($tablename , $newdata );

//}
	//update wp_rooms table
	//this setup doesn't allow wp admin users to enter data directly into wp_rooms table
	//changes to the room meta data update in wp_rooms here
	//should be set up so that room_id cannot be changed
	//_rm_id in the meta table
	$thedata = array(
				'rm_type'=>$rm_type_data,
				);
	$where 	= array(
				'rm_id'=>$post->ID,
				);

	$wpdb->update( $tablename, $thedata, $where);       
	// $check_rooms = $wpdb->get_results( 
	// 	"SELECT rm_id, rm_type, amt_per_night 
	// 	FROM 'wp_rooms'
	// 	WHERE rm_id = '15'");

	// foreach($check_rooms as $check_room){
	// 	echo "<h1>" .  $check_room->rm_id . "</h1>";
	// }
	//$roomrow = $wpdb->get_row( "SELECT * FROM $wpdb->wp_rooms WHERE rm_id = $rm_id_data", ARRAY_A );
	//var_dump($roomrow[1]);
	  
	//  //  Insert a record 
	// $newdata = array( 'rm_id' =>  $rm_id_data,
 //                  	'rm_type' => $rm_type_data); 
	// $wpdb->insert($tablename , $newdata );  
	
	//$query = $wpdb->prepare("INSERT INTO ")
	// $is_autosave = wp_is_post_autosave ($post_id);
	// $is_revision = wp_is_post_revision($post_id);
	// $is_valid_nouce = ( isset($_POST['moh_rooms_nonce']) && wp_verify_nonce($_POST['moh_rooms_nonce'], basename(__FILE__) )) ? 'true' : 'false';

	// if($is_autosave || $is_revision || !$is_valid_nonce){
	// 	return;
	// }

	// if( isset($_POST['_room_id'])){
	// 	update_post_meta($post_id, '_room_id', sanitize_text_field($_POST['_room_id']));
	// }
	

}	
add_action('save_post', 'moh_meta_save' );

 ?>