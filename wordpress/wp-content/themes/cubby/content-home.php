<?php
 	/*	
	*	The Template for displaying custom home page.
	*/
?>
<div class="homepage-main" role="main">
			<section class="homepage-slider">
				
                    <?php
					 cubby_get_slider();
					?>
				
			</section>
			<section class="homepage-section-1">
				<div class="container">
					<div class="testimonial">
						<div class="testimonial-icon"><?php _e("Client Says","cubby");?></div>
						<div class="testimonial-box client-says">
                         <ul class="testimonial">
                        <?php
	 for($i = 1;$i <= 5 ;$i++){
	 $slogan_author  = cubby_options_array('slogan_author_'.$i);
	 $slogan_content = cubby_options_array('slogan_content_'.$i);
	 if(trim($slogan_content) != ""){
 ?>
        <li>
          <h4><?php echo $slogan_author;?></h4>
          <p><?php echo $slogan_content;?></p>
        </li>
        <?php }}?>
        </ul>
						
						</div>
						<a class="up testimonial-control" href="javascript:;" id="scroll_down">
							<i class="fa fa-angle-up"></i>
						</a>
						<a class="down testimonial-control" href="javascript:;" id="scroll_up">
							<i class="fa fa-angle-down"></i>
						</a>
						</div>
					</div>		
                    </section>				
				</div>
			
			<div class="homepage-half-wrapper-1">
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<section class="homepage-section-2">
								<div class="title-wrapper">
									<h2 class="module-title"><?php echo cubby_options_array('content_slideshow_title');?></h2>
									
								</div>
								<div class="feature-box text-center">
									<div class="feature-content">
										<?php echo cubby_get_carousel('features',"feature-slider","340x280",5);?>
									</div>
									
								</div>
							</section>
						</div>
						<div class="col-md-7">
							<section class="homepage-section-3">
								<div class="title-wrapper">
									<h2 class="module-title"><?php	echo cubby_options_array('latest_news_title'); ?></h2>
								</div>
								<div class="news-box">
									<ul>
										<?php
			$args = array(
				'cat'				=> cubby_options_array('latest_news'),
				'posts_per_page'	=> 2,
				);
// The Query
$the_query = new WP_Query( $args );
// The Loop

if ( $the_query->have_posts() ) {

        echo '<ul>';

	while ( $the_query->have_posts() ) {

		$the_query->the_post();

		$cubby_feat_image  = "";

		$cubby_excerpt_css = "";

		//$feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
        $feat_image = wp_get_attachment_image( get_post_thumbnail_id(get_the_ID()), 'home-news');
		
		

		if($feat_image != ""){ 

		$cubby_feat_image  = '<span class="img"><a href="'.get_permalink().'" class="news-img">'.$feat_image.'</a></span>';

		$cubby_excerpt_css = "p-128";

		}
		
		
		if(cubby_options_array('static_content')){
			echo '<li><p><span>';
			echo do_shortcode(cubby_options_array('static_content'));
			echo '</span></p></li>';
			break;
		}else{
		echo '<li>'.$cubby_feat_image.'<a href="'.get_permalink().'"><h3>' . get_the_title() . '</h3></a>
		<p class="'.$cubby_excerpt_css.'"><span class="d-block">'.get_the_date('F dS, Y').'</span>'.cubby_cover_excerpt(22).'</p></li>';

		echo '';
		}
	}
       echo '</ul>';

} else {
	// no posts found
}

/* Restore original Post Data */

wp_reset_postdata();

?>
									</ul>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
            
             <?php if( cubby_options_array('home_purchase')){?>
 
 
			<section class="homepage-section-4">
				<div class="container">
					<div class="slogan">
					 <?php echo cubby_options_array('home_purchase');?>
					</div>
				</div>
			</section>
               <?php }?>
               
                <?php
						$portfolio = array();
						for($i=1;$i<=4;$i++){
							$portfolio_item = cubby_options_array('portfolio_'.$i);
							if(is_numeric($portfolio_item) && $portfolio_item>0) $portfolio[] = $portfolio_item;
							}
						$portfolio_num = count($portfolio);
						if($portfolio_num > 0){
							$col = 12/$portfolio_num;
						?>
                        
			<section class="homepage-section-5">
				<div class="container">
					<div class="title-wrapper">
						<h2 class="module-title"><?php echo cubby_options_array('portfolio_title');?></h2>
					</div>
					<div class="portfolio">
						<div class="row">
      <?php foreach($portfolio as $page_id){
          $query = new WP_Query( 'page_id='.$page_id );
		while ($query->have_posts()) : $query->the_post();
		
		  
	   $tags = get_the_tags($page_id);
	   $tags_list = '<ul>';
	   if(is_array($tags)){
	   foreach ( $tags as $tag ) {
		  $tag_link   = get_tag_link( $tag->term_id );
		  $tags_list .= "<li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
		  $tags_list .= "{$tag->name}</a></li>";
	   }
	   }
	  $tags_list .= '</ul>';
						   ?>
							<div class="col-sm-6 col-md-<?php echo $col;?>">
								<div class="portfolio-box text-center">
                                <?php
								 if ( has_post_thumbnail() ) { 
	                               echo '<a href="'.get_permalink().'">';
                                   the_post_thumbnail("portfolio");
                                   echo '</a>'; 
                                  } 
								?>
									<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
									<?php echo $tags_list;?>
								</div>
							</div>
                            <?php 
							endwhile;
				             wp_reset_postdata();
							}?>
						
						</div>
					</div>
				</div>
			</section>
            <?php }?>
			<section class="homepage-section-6">
				<div class="container">
					<div class="title-wrapper">
						<h2 class="module-title"><?php echo cubby_options_array('bottom_carousel_title');?></h2>
					</div>
					<div class="clients text-center">
						<div class="features">
        <div class="arrow-top left"><a href="javascript:;" class="carousel-prev"><span class="fa-3x fa fa-angle-left"></span></a></div>
        <div class="partners-content left"> <?php echo cubby_get_carousel('carousel',"partners-slider","205x150",10);?> </div>
        <div class="arrow-top last right"><a href="javascript:;" class="carousel-next right"><span class="fa-3x fa fa-angle-right"></a></div>
      </div>
					</div>
				</div>
			</section>