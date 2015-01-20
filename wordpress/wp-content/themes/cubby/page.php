<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

<?php 
   cubby_get_breadcrumb();
  ?>
 <?php

 if (have_posts()) :	while ( have_posts() ) : the_post();
  
    $enable_right_sidebar = get_post_meta( $post->ID, '_cubby_right_sidebar', true );
	$col = "12";
	if($enable_right_sidebar == 1){
	$col = "9";
	}
?>
   <div id="post-<?php the_ID(); ?>" <?php post_class("clear"); ?>>
		<div class="page-container">
			<div class="container">

				<div class="row">
					<div class="col-md-<?php echo $col;?>">
						<section class="blog-main text-center" role="main">
							<article class="post-entry text-left">
                            <h1 class="entry-title"><?php the_title();?></h1>
                            <div class="entry-content">
								<?php the_content();?>
                                </div>
                                <?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'cubby' ),
				'after'  => '</div>',
			) );

		echo '<div class="comment-wrapper">';
		comments_template(); 
		echo '<div class="clear"></div></div>';
	?>	
							</article>
						</section>
					</div>
                    <?php if($enable_right_sidebar == 1){?>
					<div class="col-md-3">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                            <?php cubby_get_sidebar(3,true); ?>
                                
                            </div>
                        </aside>
                    </div>
                    <?php }?>
                </div>
            </div>  
            
        </div>
      </div>
      
      <?php endwhile;endif;?>
		<!--Footer-->
        
<?php get_footer(); ?>