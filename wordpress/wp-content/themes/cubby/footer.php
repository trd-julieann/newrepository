<?php
/**
 * The template for displaying the footer.
 */
?>
<footer>
<?php if(is_active_sidebar(8) || is_active_sidebar(9) || is_active_sidebar(10) || is_active_sidebar(11)){?>
			<div class="footer-widgets-area">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<?php cubby_get_sidebar(8,false); ?>
						</div>
						<div class="col-md-3">
							<?php cubby_get_sidebar(9,false); ?>
						</div>
						<div class="col-md-3">
							<?php cubby_get_sidebar(10,false); ?>
						</div>
                        <div class="col-md-3">
							<?php cubby_get_sidebar(11,false); ?>
						</div>
                        
					</div>
				</div>
			</div>
            <?php }?>
			<div class="footer-info-area">
				<div class="container">
					<div class="footer-info">
                    <?php cubby_footer_info(cubby_get_footer_text('cubby_footer_text'));?> <br> <?php printf( __( 'Powered by <a href="http://wordpress.org/" target="_blank">%s</a>', 'cubby' ), 'WordPress' ); ?>. Designed by <a href="<?php echo esc_url("http://www.mageewp.com/");?>">Mageewp Themes</a>.
					</div>
					<nav class="footer-menu">
						<?php
        
        wp_nav_menu(array('theme_location' 	=>'footer_menu',
						  'depth'			=>1,
						  'container'		=>'',
						  'fallback_cb' =>false,
						  'container_class'	=>'footer-menu',
						  'menu_id'			=>'menu-footer',
						  'menu_class'		=>'footer-nav',
						  'link_before' 	=> '<span>', 
						  'link_after' 		=> '</span>'));
        
        ?> 
					</nav>
				</div>
			</div>
		</footer>
	</div>
    <?php wp_footer(); ?>
</body>
</html>