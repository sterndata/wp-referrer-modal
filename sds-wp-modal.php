<?php // phpcs:ignore
/**
 * Plugin Name: WP Referrer Modal
 * Plugin URI: https://github.com/sterndata/wp-referrer-modal
 * Description: warn about follow homes from wordpress.org
 * Version: 3.2
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

class SDS_WP_MODAL {

	/**
	 * SDS_WP_MODAL constructor.
	 *
	 * @uses SDS_WP_MODAL::init()
	 *
	 * @return void
	 */

	public function __construct() {
		$this->init();
	}

	/**
	 * Plugin initialization.
	 *
	 * @uses add_filter()
	 * @uses add_action()
	 *
	 * @return void
	 */

	public function init() {

		add_filter( 'wp_footer', array( $this, 'the_modal' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );

	}

	/**
	 * Output all the necessary scripts and css.
	 *
	 * @uses wp_enqueue_script()
	 *
	 * @return void
	 */

	public function enqueue_scripts() {

		wp_enqueue_script( 'modal-referrer', plugins_url( 'modal-referrer.js', __FILE__ ), array(), false, true );

	}

	/**
	 * Outputs the modal in the front-end.
	 *
	 * @uses
	 *
	 * @return string $output HTML of the modal.
	 */

	public function the_modal() {

		$title = get_option( 'sds_wp_referrer_modal_title' );
		$body  = get_option( 'sds_wp_referrer_modal_body' );
		$url   = plugins_url( 'sds-wp-modal.css', __FILE__ );

		if ( empty( $title ) ) {

			$title = 'Hello, fellow WordPresser';

			update_option( 'sds_wp_referrer_modal_title', $title );

		}

		if ( empty( $body ) ) {

			$body = '<p>It seems you came here from a link on WordPress.org.<br>If you are following up on a support question that we were discussing in a forum, please note:</p><p><em>What happens in the forums stays in the forums.</em></p><p><strong>Also be aware that bringing a forum argument here or to any other moderator site is a violation of <a href="https://codex.wordpress.org/Forum_Welcome#The_Bad_Stuff" target=_blank> forum rules</a>.</strong>
			</p><p>If, on the other hand, you are here to see who I am and what I am up to, read on!</p>';

			update_option( 'sds_wp_referrer_modal_body', $body );
		}

		$e_title = stripslashes( $title );
		$e_body  = stripslashes( $body );

		$output = '<template id="sdsModal">
						<div class="sdsModal">
							<link rel="stylesheet" href="' . $url . '">
							<div class="sds-modal-content">
								<div class="sds-modal-header">
									<h4 class="modal-title">' . $e_title . '</h4>
								</div>
								<div class="modal-body">
									' . $e_body . '
								</div>
								<button>OK</button>
							</div>
						</div>
					</template>';
		echo $output;
	}

	/**
	 * Creates admin menu link
	 *
	 * @uses add_options_page()
	 *
	 * @return void
	 */

	public function create_admin_menu() {

		add_options_page(
			'WP Referrer Modal Settings',
			'WP Referrer Modal',
			'manage_options',
			'sds_wp_referrer_modal',
			array( $this, 'settings_page' )
		);

	}

	/**
	 * Register settings
	 *
	 * @uses add_option()
	 * @uses register_setting()
	 *
	 * @return void
	 */

	public function register_settings() {

		add_option( 'sds_wp_referrer_modal_title', 'Title for the modal' );
		add_option( 'sds_wp_referrer_modal_body', 'Body for the modal' );

		register_setting(
			'sds_wp_referrer_modal_options_group',
			'sds_wp_referrer_modal_title',
			array( $this, 'text_sanitize' )
		);

		register_setting(
			'sds_wp_referrer_modal_options_group',
			'sds_wp_referrer_modal_body',
			array( $this, 'html_sanitize' )
		);

	}

	/**
	* Sanitize text setting field as needed.
	*
	* @param array $input Contains the text string.
	*
	* @uses sanitize_text_field()
	*
	* @return string $new_input Sanitized text setting.
	*/

	public function text_sanitize( $input ) {

		if ( isset( $input ) ) {
			$new_input = sanitize_text_field( $input );
		}

		return $new_input;

	}

	/**
	* Sanitize textarea setting field as needed.
	*
	* @param array $input Contains the textarea string.
	*
	* @uses wp_kses_post()
	*
	* @return string $new_input Sanitized textarea string.
	*/

	public function html_sanitize( $input ) {

		if ( isset( $input ) ) {
			$new_input = wp_kses_post( $input );
		}

		return $new_input;

	}

	/**
	 * Output settings page.
	 *
	 * @uses settings_fields()
	 * @uses get_option()
	 * @uses wp_editor()
	 * @uses submit_button()
	 *
	 * @return void
	 */

	public function settings_page() {
	?>
		<div class="wrap">
			<h1>WP Referrer Modal</h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'sds_wp_referrer_modal_options_group' ); ?>
				<p>
					<h3><?php _e( 'Modal Title' ); ?><h3>
					<input type="text" id="sds_wp_referrer-modal_title" name="sds_wp_referrer_modal_title" value="<?php echo get_option( 'sds_wp_referrer_modal_title' ); ?>" />
				</p>
				<p>
					<h3><?php _e( 'Modal Body' ); ?><h3>
					<?php wp_editor( get_option( 'sds_wp_referrer_modal_body' ), 'sds_wp_referrer_modal_body', array( 'wpautop' => false ) ); ?>
				</p>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php
	}

}

new SDS_WP_MODAL();
