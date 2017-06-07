<?php
$title = get_option( 'sds_wp_referrer_modal_title' );
$body = get_option( 'sds_wp_referrer_modal_body' );
if ( ! $title ) {
	$title = 'Hello, fellow WordPresser';
	update_option( 'sds_wp_referrer_modal_title', $title );
}
if ( ! $body ) {
		$body = '
		<p>It seems you came here from a link on WordPress.org.<br>If you are following up on a support question that we were discussing in a forum, please note:</p><p><em>What happens in the forums stays in the forums.</em></p><p><strong>Also be aware that bringing a forum argument here or to any other moderator site is a violation of <a href="https://codex.wordpress.org/Forum_Welcome#The_Bad_Stuff" target=_blank> forum rules</a>.</strong>
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
