<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package electro
 */
?>
			<?php
			/**
			 *
			 */
			do_action( 'electro_content_bottom' ); ?>
		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'electro_before_footer_v2' ); ?>

	<footer id="colophon" class="site-footer footer-v2">

		<?php
		/**
		 * @hooked electro_footer_widgets - 10
		 * @hooked electro_credit - 20
		 */
		do_action( 'electro_footer_v2' ); ?>


	</footer><!-- #colophon -->

	<?php do_action( 'electro_after_footer_v2' ); ?>

</div><!-- #page -->
</div>
<?php do_action( 'electro_after_page' ); ?>

<?php wp_footer(); ?>

</body>
</html>
