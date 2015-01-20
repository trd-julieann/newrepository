<?php
/**
 * The template for displaying 404 pages (Not Found).
 * @package WordPress
 */

get_header(); ?>

<?php 
   cubby_get_breadcrumb();
?>

<div class="page-404">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<section class="blog-main text-center" role="main">
							<article class="post-entry text-left">
								<h1>
      <?php _e('Whoops!', 'cubby'); ?>
    </h1>
    <h2>
      <?php _e('There is nothing here.', 'cubby'); ?>
    </h2>
    <p>
      <?php _e('Perhaps you were given the wrong URL?', 'cubby'); ?>
    </p>
							</article>
						</section>
					</div>
					
                </div>
            </div>  
        </div>
<?php get_footer(); ?>
