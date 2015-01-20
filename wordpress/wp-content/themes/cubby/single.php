<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 *
 * @since Cubby 1.0.0
 */

get_header(); ?>

<?php 
   cubby_get_breadcrumb();
?>
<?php if (have_posts()) :?>
<?php	while ( have_posts() ) : the_post();

$enable_right_sidebar = get_post_meta( get_the_ID(), '_cubby_right_sidebar', true );
	$col = "12";
	if($enable_right_sidebar == 1){
	$col = "9";
	}
?>

<div id="post-<?php the_ID(); ?>" <?php post_class("clear"); ?>>
<div class="blog-detail">
			<div class="container">
				<div class="row">
					<div class="col-md-<?php echo $col;?>">
<?php get_template_part( 'content', get_post_format() ); ?>
                   </div>
                   
                    <?php if($enable_right_sidebar == 1){?>
					<div class="col-md-3">
                       <aside class="blog-side left text-left">
                            <div class="widget-area">
                            <?php cubby_get_sidebar(2,true); ?>
                            </div>
                        </aside>
                    </div>
                    <?php }?>
                    
                 </div>
             </div>
         </div>
</div>
<?php endwhile;?>
<?php endif;?>

<?php get_footer(); ?>