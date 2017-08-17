<?php
/**
 * Plugin Name: WP Referrer Modal
 * Plugin URI:	https://github.com/sterndata/wp-referrer-modal
 * Description: warn about follow homes from wordpress.org
 * Version: 1.0
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

/*
* output all the necessary scripts and css
*/

function sds_wp_referrer_modal_enqueue_scripts() {
	$the_plugin = plugins_url( '', __FILE__ );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-dialog ' );
	wp_enqueue_script( 'modal-referrer', $the_plugin . '/modal-referrer.js', array( 'jquery', 'jquery-ui-dialog' ) );
	wp_enqueue_style( 'jquery-ui' , 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
	wp_enqueue_style( 'modal-referrer', $the_plugin . '/sds-wp-modal.css', array( 'jquery-ui' ) );
}
add_action( 'wp_enqueue_scripts', 'sds_wp_referrer_modal_enqueue_scripts' );

/*
 * display the messsages
 *
 * if there' not already set, update the options to use the default modal-message
 */

function sds_wp_referrer_modal_filter() {
	ob_start();
	$title = get_option( 'sds_wp_referrer_modal_title' );
	$body = get_option( 'sds_wp_referrer_modal_body' );
	if ( ! $title ) {
		$title = 'Hello, fellow WordPresser';
		update_option( 'sds_wp_referrer_modal_title', $title );
	}
	if ( ! $body ) {
		$body = '<p>It seems you came here from a link on WordPress.org.<br>If you are following up on a support question that we were discussing in a forum, please note:</p><p><em>What happens in the forums stays in the forums.</em></p><p><strong>Also be aware that bringing a forum argument here or to any other moderator site is a violation of <a href="https://codex.wordpress.org/Forum_Welcome#The_Bad_Stuff" target=_blank> forum rules</a>.</strong>
		</p><p>If, on the other hand, you are here to see who I am and what I am up to, read on!</p>';

		update_option( 'sds_wp_referrer_modal_body', $body );
	}

?>
<div id="sdsModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="sds-modal-content">
<div class="sds-modal-header">
<h4 class="modal-title"><?php echo stripslashes( $title ); ?></h4>
</div>
<div class="modal-body">
<?php echo stripslashes( $body ); ?>
</div>
</div>

</div>
</div>

<?php
		echo ob_get_clean();
}
add_filter( 'wp_footer', 'sds_wp_referrer_modal_filter' );

/*
 * autoptimize
*/

add_filter( 'autoptimize_filter_css_exclude','sds_wp_referrer_modal_ao_override_cssexclude',10,1 );
function sds_wp_referrer_modal_ao_override_cssexclude( $exclude ) {
	return $exclude . ',sds-wp-modal.css';
}

/*
 *  Settings Dialog
 */

function sds_wp_referrer_modal_register_settings() {
	add_option( 'sds_wp_referrer_modal_title', 'Title for the modal' );
	add_option( 'sds_wp_referrer_modal_body',  'Body for the modal' );
	register_setting( 'sds_wp_referrer_modal_options_group', 'sds_wp_referrer_modal_title', 'sds_wp_referrer_modal_sanitize' );
	register_setting( 'sds_wp_referrer_modal_options_group', 'sds_wp_referrer_modal_body', 'sds_wp_referrer_modal_sanitize' );
}
 add_action( 'admin_init', 'sds_wp_referrer_modal_register_settings' );

function sds_wp_referrer_modal_register_options_page() {
	add_options_page( 'WP Referrer Modal Settings', 'WP Referrer Modal', 'manage_options', 'sds_wp_referrer_modal', 'sds_wp_referrer_modal_options_page' );
}
add_action( 'admin_menu', 'sds_wp_referrer_modal_register_options_page' );

function sds_wp_referrer_modal_sanitize( $option ) {
	$allowed_protocols = array(
		'http',
		'https',
		'mailto',
	);
	$allowed_html = array(
			'a' => array(
					'class' => array(),
					'href'  => array(),
					'rel'   => array(),
					'title' => array(),
				),

				'b' => array(),
				'em' => array(),
				'h1' => array(),
				'h2' => array(),
				'h3' => array(),
				'h4' => array(),
				'h5' => array(),
				'h6' => array(),
				'i' => array(),
				'li' => array(),
				'ol' => array(),
				'p' => array(
					'class' => array(),
				),
				'strong' => array(),
				'ul' => array(),
			);
	return wp_kses( $option, $allowed_html, $allowed_protocols );
}

function sds_wp_referrer_modal_add_settings_link( $links ) {
	$settings_link = '<a href="options-general.php?page=sds_wp_referrer_modal">' . __( 'Settings' ) . '</a>';
	array_push( $links, $settings_link );
	  return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'sds_wp_referrer_modal_add_settings_link' );

function sds_wp_referrer_modal_options_page() {
?>
  <div>
  <h2 style="margin-top:1em;">WP Referrer Modal</h2>
  <form method="post" action="options.php">
	<?php settings_fields( 'sds_wp_referrer_modal_options_group' ); ?>
  <h3>Set Title and Body for the modal</h3>
  <table>
  <tr valign="top">
  <th scope="row"><label for="sds_wp_referrer_modal_title">Title</label></th>
  <td><input type="text" id="sds_wp_referrer-modal_title" name="sds_wp_referrer_modal_title" value="<?php echo get_option( 'sds_wp_referrer_modal_title' ); ?>" /></td>
  </tr>
	<tr valign="top">
	<th scope="row"><label for="sds_wp_referrer-modal_body">Body</label></th>
	<td><textarea rows="10" cols="80"  id="sds_wp_referrer-modal_body" name="sds_wp_referrer_modal_body"><?php echo get_option( 'sds_wp_referrer_modal_body' ); ?></textarea></td>
	</tr>
  </table>
	<?php  submit_button(); ?>
  </form>
  </div>
<?php
}
