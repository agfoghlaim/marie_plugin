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
	//global $post;
	$moh_stored_meta = get_post_meta( $post->ID, '_room_id', true );
	echo "<h1>" .  $post->ID . "</h1>";
	?>

	<div id="moh-meta">

		<div class="meta-row">
			<div class="meta-th">
				<label for="room-id" class="moh-row-title">Room ID</label>	
			</div>
			<div class="meta-td">
				<input type="text" name="room-id" id="room-id" value="<?php
					echo esc_attr( $moh_stored_meta );
			 ?>">
			</div>
		</div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="room-rate" class="moh-row-title">Room Rate</label>	
			</div>
			<div class="meta-td">
				<input type="text" name="room-rate" id="room-rate" value="">
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
	$content = '';
	$editor_id = 'roomdescription';
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
	$rm_id_data = sanitize_text_field($_POST['room-id'] );

	update_post_meta($post_id, '_room_id', $rm_id_data);
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