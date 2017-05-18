<?php
$text = get_option( 'wp_modal-referrer' );
if ( ! $text ) {
	$text = maybe_serialize( array (
		'title' => 'Hello, fellow WordPresser',
		'body' => '<p>It seems you've come here from a link on WordPress.org.<br>
		If you're following up on a support question that we were discussing in a forum, please note:</p>
		<p><em>What happens in the forums stays in the forums.</em></p>
		<p><strong>Also be aware that bringing a forum argument here or to any other moderator’s site  is a violation of <a href="https://codex.wordpress.org/Forum_Welcome#The_Bad_Stuff" target=_blank> forum rules</a>.</strong>
		</p>
		<p>If, on the other hand, you're here to see who I am and what I'm up to, read on!</p>',
		 )
	 );
	update_option( 'wp_modal_referrer', $text );
}
$content = maybe_unserialize( $text );
?>
<div id="sdsModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="sds-modal-content">
<div class="sds-modal-header">
<h4 class="modal-title"><?php echo $content[ 'title' ]; ?></h4>
</div>
<div class="modal-body">
<?php echo $content[ 'body' ]; ?>
</div>
</div>

</div>
</div>
