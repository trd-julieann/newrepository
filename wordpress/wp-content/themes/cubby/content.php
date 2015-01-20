<?php
/**
 * Posts loop
 *
 */

	?>
<section class="blog-main text-center" role="main">
  <article class="post-entry text-left">
    <div class="entry-date text-center"> <?php echo get_the_time("M");echo " ";echo get_the_time("d"); ?><br />
      <?php echo get_the_time("Y");?> </div>
    <div class="entry-main">
      <div class="entry-header"> <a href="<?php the_permalink();?>">
        <h1 class="entry-title">
          <?php the_title();?>
        </h1>
        </a>
        <div class="entry-meta"> <span class="entry-category"><i class="fa fa-briefcase"></i>
          <?php _e("Categories","cubby");?>
          :
          <?php the_category(', '); ?>
          </span> <span class="entry-tags"><i class="fa fa-tags"></i>
          <?php _e("Tags","cubby");?>
          : <?php echo get_the_tag_list('',', ');?></span> <span class="entry-comments">
          <?php  comments_popup_link( '<i class="fa fa-comments"></i> No comments yet', '<i class="fa fa-comments"></i> 1 comment', '<i class="fa fa-comments"></i> % comments', 'comments-link', '');?>
          </span> </div>
      </div>
      <div class="entry-content">
        <?php
if ( has_post_thumbnail() && ! post_password_required()) { 
				
				 $feat_image = wp_get_attachment_image( get_post_thumbnail_id(get_the_ID()), 'blog-list');
				  if($feat_image ){ 
				echo "<div class='blog-item-image'><a href='".get_permalink()."'>".$feat_image."</a></div>";
				}

} 
  ?>
        <div class="post-content">
          <?php if(!is_singular()):?>
          <?php the_excerpt();?>
          <?php else: ?>
          <?php 
 the_content();
 wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'cubby' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );

?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </article>
  <div class="text-left">
    <?php if(is_singular()):
		   echo '<div class="comment-wrapper">';
	         comments_template(); 
	        echo '</div>';
	
		   endif; ?>
  </div>
</section>
