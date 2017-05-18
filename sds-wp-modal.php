<?php
/**
 * Plugin Name: WP Referrer Modal
 * Plugin URI:	https://github.com/sterndata/wp-referrer-modal
 * Description: warn about follow homes from wordpress.org
 * Version: 0.7
 * Author: Stern Data Solutions
 * Author URI: http://www.sterndata.com
 * License: Gnu Public License V2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
/************************************
Copyright (C) 2014-2016 Steven D. Stern dba Stern Data Solutions
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA	02110-1301, USA.
*******************************/


function sds_enqueue_scripts() {
	$the_plugin = plugins_url( '', __FILE__ );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-dialog ' );
	wp_enqueue_script( 'modal-referrer', $the_plugin . '/modal-referrer.js', array( 'jquery', 'jquery-ui-dialog' ) );
	wp_enqueue_style( 'jquery-ui' , 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
	wp_enqueue_style( 'modal-referrer', $the_plugin . '/sds-wp-modal.css', array( 'jquery-ui' ) );
}
add_action( 'wp_enqueue_scripts', 'sds_enqueue_scripts' );

function sds_wp_modal_filter() {
	ob_start();
	?>
<!-- Modal -->
<?php include_once( plugin_dir_path( __FILE__ ) . '/modal-message.php' ); ?>
<?php
		echo ob_get_clean();
}
add_filter( 'wp_footer', 'sds_wp_modal_filter' );


/*
 * autoptimize
*/

add_filter('autoptimize_filter_css_exclude','sds_ao_override_cssexclude',10,1);
function sds_ao_override_cssexclude($exclude) {
	return $exclude.",sds-wp-modal.css";
}
