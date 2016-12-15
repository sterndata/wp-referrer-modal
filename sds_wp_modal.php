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

function sds_is_wp_support() {
        if (preg_match( '/wordpress.org/', $_SERVER['HTTP_REFERER'] ))  {
                return true;
        }
        return false;
}

function sds_enqueue_scripts() {
if ( sds_is_wp_support() ) {
	$the_plugin = plugins_url( '', __FILE__ );
	wp_enqueue_script( 'modal-referrer', $the_plugin. '/modal-referrer.js', array( 'jquery' ) );
	wp_enqueue_style( 'modal-referrer', $the_plugin . '/sds_wp_modal.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'sds_enqueue_scripts' );

function sds_wp_modal_filter( $content ) {
        ob_start();
        ?>
<!-- Modal -->
<div id="sdsModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="sds-modal-content">
<div class="sds-modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Hello, fellow WordPresser!</h4>
</div>
<div class="modal-body">
<p>It seems you've come here from a link on WordPress.org.<br>
                        If you're following up on a support question that we were discussing in a forum, please note:</p>
                        <p><em>What happens in the forums stays in the forums.</em></p>
            <p><strong>Also be aware that if you bring a forum argument here or to any other moderator’s site then you risk getting your forum account blocked.</strong></p>
<p>If, on the other hand, you're here to see who I am and what I'm up to, read on!</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>
<?php
        return $content . ob_get_clean();
}
add_filter( 'the_content', 'sds_wp_modal_filter' );
