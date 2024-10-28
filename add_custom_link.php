<?php
/*
Plugin Name: Add custom link to wordpress admin bar
Plugin URI: http://sumitbansal.com
Description: Since WordPress Version 3.1 - you know - there is the admin bar. This plugin add the custom link to the wordpress admin bar" plugin by <a href="http://sumitbansal.com/" target="_blank">Sumit Bansal</a>
Author: Sumit Bansal
Version: 1.0
Author URI: http://sumitbansal.com/
License: GPL or later
*/

if ( is_admin() ){
	add_action('admin_menu', 'add_custom_link');
	function add_custom_link() {
		add_menu_page('Add Custom Link', 'Add Custom Link', 'administrator', 'add-custom-link', 'add_new_custom_link');
		add_submenu_page( 'add-custom-link', 'Manage Custom Link', 'Manage Custom Link', 'administrator', 'manage-custom-link', 'manage_custom_link' );
	}
		
	function add_custom_link_install() {
		global $wpdb;
		$table_name = $wpdb->prefix . "add_custom_link";
		$sql = "CREATE TABLE `$table_name` (
			  `custom_link_id` int(11) NOT NULL auto_increment,
			  `id` varchar(200) NOT NULL,
			  `title` varchar(200) NOT NULL,
			  `parent_id` int(11) NOT NULL,
			  `href` varchar(500) NOT NULL,
			  PRIMARY KEY  (`custom_link_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1" ;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		update_option( "add_custom_link_db_version", '1.0' );
	}
	register_activation_hook( __FILE__, 'add_custom_link_install' );
	
	function add_custom_link_uninstall() {
		global $wpdb;
		$table_name = $wpdb->prefix . "add_custom_link";
		$sql = "DROP TABLE IF EXISTS $table_name" ;
		$wpdb->query("$sql");
		delete_option( "add_custom_link_db_version" );
	}
	register_deactivation_hook( __FILE__, 'add_custom_link_uninstall' );
	
	function manage_custom_link(){
		if(isset($_GET['edit'])):
		include('edit-custom-link.php');
		else:
		include('manage-custom-link.php');
		endif;
	}
	
	function add_new_custom_link(){
		include('add-new-custom-link.php');
	}
	
	function edit_custom_link(){
		include('add-new-custom-link.php');
	}
}



function add_custom_link_admin_bar_menu() {
	global $wp_admin_bar, $wpdb;
	$table_name = $wpdb->prefix . "add_custom_link";
	$query = "SELECT * FROM `$table_name` as bacc LEFT JOIN `$table_name` as baccl ON bacc.parent_id =baccl.custom_link_id";
	$results1 = mysql_query($query);
	while($results = mysql_fetch_row($results1)){
		//$parent = (strip_tags($result->parent)==0) ? '' : strip_tags($result->parent);
		$wp_admin_bar->add_menu( array('id' => strip_tags($results[1]), 'title' => __(strip_tags($results[2])), 'parent' => strip_tags($results[6]), 'href' => strip_tags($results[4])));
	}
};

/** Add my function to the wordpress admin_menu_bar **/
add_action( 'admin_bar_menu', 'add_custom_link_admin_bar_menu', 12 );

/****  by Sumit Bansal || http://sumitbansal.com ****/

?>
