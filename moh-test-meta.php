<?php
add_action('add_meta_box', 'moh_create');

function moh_create(){
	add_meta_box('moh-meta', 'moh custom meta', 'moh_callback','room', 'normal', 'high');

}

function moh_callback($post){
	$moh_room_type = get_post_meta($post->ID);

	echo "please fil in info0";

?>
	<p>room type<input type="text" name ="moh_room_type" value="
		<?php echo $moh_room_type ; ?>"></p>

<?php

add_action('same_post', 'moh_save_meta' );

function moh_save_meta( $post_id){
	if(isset($_POST['moh_room_type'])){
		update_post_meta($post_id, 'moh_room_type');
	}
}
}
?>