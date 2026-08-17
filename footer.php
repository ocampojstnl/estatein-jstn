<?php
/**
 * The footer for the theme.
 */
?>
<footer id="site-footer">
	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php dynamic_sidebar( 'footer-1' ); ?>
	<?php endif; ?>
</footer>

<?php if ( ! empty( $GLOBALS['estatein_needs_faq_modal'] ) ) : ?>
	<div class="faq-modal-overlay" data-faq-modal-overlay></div>
	<div class="faq-modal" id="faq-modal" role="dialog" aria-modal="true" aria-labelledby="faq-modal-title">
		<button type="button" class="faq-modal__close" data-faq-modal-close aria-label="<?php esc_attr_e( 'Close', 'estatein' ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
		</button>
		<div class="faq-modal__body" data-faq-modal-body></div>
	</div>
<?php endif; ?>

<button type="button" id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'estatein' ); ?>">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
