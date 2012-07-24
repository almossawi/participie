	</div></div>

	<div class="footer">
		<?php wp_nav_menu( array('fallback_cb' => 'clean_and_clear_page_menu_flat', 'container' => false, 'menu' => 'secondary', 'depth' => '1', 'theme_location' => 'secondary', 'link_before' => '', 'link_after' => '') ); ?>
		<p><?php _e('Powered by', 'clean_and_clear'); ?> <a href="http://wordpress.org/">WordPress</a>. <?php _e('Designed by', 'clean_and_clear'); ?> <a href="http://atrakcje-turystyczne.pl/">Atrakcje Turystyczne</a>.</p>
	</div>
<?php wp_footer();?>	
</body>
</html>