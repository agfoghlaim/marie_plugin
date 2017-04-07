<?php
 function divi_child_moh_guesthouse(){
 	wp_enqueue_script('js', get_stylesheet_directory_uri() . '/js/global.js');
 	wp_enqueue_script('jquery');
 	//http://localhost/wordpress/wp-content/plugins/moh-check-avail/js/global.js
 }



add_action( 'wp_enqueue_scripts', 'divi_child_moh_guesthouse');

// add_action( 'admin_menu', 'moh_guesthouse_create_menu' ) ;
//             function moh_guesthouse_create_menu() {               
//             // create custom top-level men u    
//             	add_menu_page( 'moh guesthouse settings', 
//             					'mohSet' ,        
//             					'this is what plgin does', 
//             					'moh_guesthouse_plugin',
//             					'moh_guesthouse_plugin_create_page',
//             					1
//             				);     
//             } 

//             	function moh_guesthouse_plugin_create_page(){

//             	}
?>