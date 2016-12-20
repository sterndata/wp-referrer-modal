<?php
/**
 * Plugin Name: WP Referrer Modal
 * Plugin URI:	https://github.com/sterndata/wp-referrer-modal
 * Description: warn about follow homes from wordpress.org
 * Version: 2016.12.15
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
<div id="sdsModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="sds-modal-content">
<div class="sds-modal-header">
<h4 class="modal-title">Hello, fellow WordPresser!</h4>
</div>
<div class="modal-body">
<p>It seems you've come here from a link on WordPress.org.<br>
If you're following up on a support question that we were discussing in a forum, please note:</p>
<p><em>What happens in the forums stays in the forums.</em></p>
<p><strong>Also be aware that bringing a forum argument here or to any other moderator’s site  is a violation of <a href="https://codex.wordpress.org/Forum_Welcome#The_Bad_Stuff" target=_blank> forum rules</a>.</strong>
</p>
<p>If, on the other hand, you're here to see who I am and what I'm up to, read on!</p>
</div>
</div>

</div>
</div>
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
