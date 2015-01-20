<?php
/**
 * The main template file.
 *
 */

get_header(); ?>
<?php 
   $enable_home_page = cubby_options_array('enable_home_page');
   if($enable_home_page == 1  && $wp_query->get_queried_object_id() != get_option( 'page_for_posts' )){
   get_template_part("content","home");
   }else{
 ?>
<div class="blog-list">
			<div class="container">
				<div class="row">
                  <?php if (have_posts()) :?>
					<div class="col-md-9">
                    <?php while ( have_posts() ) : the_post();
	                              get_template_part("content",get_post_format());
                                endwhile;
								?>
 <div class="list-pagition text-center"><?php cubby_native_pagenavi("echo",$wp_query);?></div>
                    </div>
                    <div class="col-md-3">
                    <?php cubby_get_sidebar(4,true); ?>
                    </div>
                    <?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
                      
                    </div>
                  
                   </div>
                  </div>
                  <?php }?>

<?php get_footer(); ?>