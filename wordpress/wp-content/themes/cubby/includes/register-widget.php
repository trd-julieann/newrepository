<?php
// global $wp_registered_sidebars;
#########################################
function cubby_widgets_init() {
			register_sidebar(array(
				'name' => 'Displayed Everywhere',
				'id'  => 'First_sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Blog Post',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Pages',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Category',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>', 
			));
			register_sidebar(array(
				'name' => 'Sidebar Archive',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>', 
			));
		
			register_sidebar(array(
				'name' => 'Sidebar Search',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>', 
			));
			register_sidebar(array(
				'name' => 'Sidebar Tags',
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>', 
			));
		
		register_sidebar(array(
				'name' => 'Footer Area One',
				'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<div class="widget-title"><h3 class="">', 
			'after_title' => '</h3></div>', 
			));
			
			register_sidebar(array(
				'name' => 'Footer Area Two',
				'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<div class="widget-title"><h3 class="">', 
			'after_title' => '</h3></div>', 
			));
			
			register_sidebar(array(
				'name' => 'Footer Area Three',
				'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<div class="widget-title"><h3 class="">', 
			'after_title' => '</h3></div>', 
			));
			register_sidebar(array(
			'name' => 'Footer Area Four',
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<div class="widget-title"><h3 class="">', 
			'after_title' => '</h3></div>', 
			));
			
			 register_widget('cubby_recentPost');
			 register_widget('cubby_popular_post');
			 register_widget('cubby_contact');
			 
}
add_action( 'widgets_init', 'cubby_widgets_init' );
	/********************  Recent Post*************************************/


 class cubby_recentPost extends WP_Widget {

	function cubby_recentPost() {
		$widget_ops = array( 'classname' => 'recentpost-widget', 'description' => __('Display the recent posts on your website.', 'cubby') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'recentpost-widget' );
		$this->WP_Widget( 'recentpost-widget', __('(cubby) Recent Posts', 'cubby'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $cubby_options;
		extract( $args );
		$title = apply_filters('Recent Posts', $instance['title'] );
		$post_cat = $instance['post_cat'];
		if($post_cat == "All"){ $post_cat = ''; }
		$show_num = $instance['show_num'];
		echo $before_widget;
		if($title)
		echo $before_title . $title . $after_title;
		$custom_posts = get_posts('showposts='.$show_num.'&cat='.get_cat_ID($post_cat));
		if( !empty($custom_posts) ){ 
			echo "<div class='cubby-recent-post-widget'><ul>";
			foreach($custom_posts as $custom_post) { 
				?>
				
				<li>
							<?php
								$thumbnail_id = get_post_thumbnail_id( $custom_post->ID );	
								if(isset($thumbnail_id) && is_numeric($thumbnail_id)){			
								$feat_image = wp_get_attachment_image( $thumbnail_id, 'sidebar-posts');
								
								if( $feat_image ){
									echo '<a href="'.get_permalink( $custom_post->ID ).'" class="widget-img">'.$feat_image.'</a>';
								}
								}
							?>
						
<a href="<?php echo get_permalink( $custom_post->ID ); ?>"><?php echo $custom_post->post_title; ?> </a><br /> <?php echo get_the_time("M dS, Y", $custom_post->ID);?></li>

				
				<?php 
				
			}
			echo "</ul></div>";
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_cat'] = strip_tags( $new_instance['post_cat'] );
		$instance['show_num'] = strip_tags( $new_instance['show_num'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('Recent Posts', 'cubby'), 'post_cat' => __('All', 'cubby'), 'show_num' => '4');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title :', 'cubby'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_cat' ); ?>"><?php _e('Category :', 'cubby'); ?></label>		
			<select name="<?php echo $this->get_field_name( 'post_cat' ); ?>" id="<?php echo $this->get_field_id( 'post_cat' ); ?>">
				<option value="" <?php if (  $instance['post_cat'] == "" ) echo ' selected="selected"'; ?>>All Categories</option>	
			<?php 	
			$category_list = get_categories('taxonomy=category'); 
			if($category_list){
			foreach($category_list as $category ){
			?>
				<option value="<?php echo $category->cat_name; ?>" <?php if (  $instance['post_cat'] == $category->cat_name ) echo ' selected="selected"'; ?>><?php echo $category->cat_name; ?></option>				
			<?php } }?>	
			</select> 
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count :', 'cubby'); ?></label>
			<input id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" value="<?php echo $instance['show_num']; ?>" class="" />
		</p>

	<?php
	}
}

    /********************  Popular post *************************************/
	
   
  class cubby_popular_post extends WP_Widget {

	function  cubby_popular_post() {
		$widget_ops = array( 'classname' => 'popularpost-widget', 'description' => __('Display the popular posts on your website.', 'cubby') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'popularpost-widget' );
		$this->WP_Widget( 'popularpost-widget', __('(cubby) Popular Posts', 'cubby'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
	    global $cubby_options;
		extract( $args );
		$title = apply_filters('Most Popular', $instance['title'] );
		$show_num = $instance['show_num'];
		echo $before_widget;
		if($title){
			echo $before_title . $title . $after_title;
		}

		$custom_posts = get_posts('showposts='.$show_num.'&orderby=comment_count');
		if( !empty($custom_posts) ){ 
			echo "<div class='cubby-recent-post-widget'><ul>";
			foreach($custom_posts as $custom_post) { 	
				?>
				
				<li>
							<?php
								$thumbnail_id = get_post_thumbnail_id( $custom_post->ID );	
								if(isset($thumbnail_id) && is_numeric($thumbnail_id)){			
								$feat_image = wp_get_attachment_image( $thumbnail_id, 'sidebar-posts');
								if($feat_image){
									echo '<a href="'.get_permalink( $custom_post->ID ).'" class="widget-img">'.$feat_image.'</a>';
								}
								}
							?>
<a href="<?php echo get_permalink( $custom_post->ID ); ?>"><?php echo $custom_post->post_title; ?> </a><br /> <?php echo get_the_time("M dS, Y", $custom_post->ID);?></li>

										
				<?php 
				
			}
			echo "</ul></div>";
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_num'] = strip_tags( $new_instance['show_num'] );
		
		return $instance;
	}
	function form( $instance ) {
		$defaults = array( 'title' => __('Popular Posts', 'cubby'), 'post_cat' => __('0', 'cubby'), 'show_num' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
     <ul>
		<li><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'cubby'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"/>
		</li>
		<li>
			<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count', 'cubby'); ?></label>
			<input id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" value="<?php echo $instance['show_num']; ?>" />
		</li>
		
		
		</ul>

	<?php
	}
}


/********************  Contact form *************************************/

 class cubby_contact extends WP_Widget {
 	function cubby_contact() {
 		$widget_ops = array( 'classname' => 'contact-widget', 'description' => __( 'Contact form', 'cubby' ) );
		$control_ops = array( 'width' => 350, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( '(cubby) Contact Form', 'cubby' ), $widget_ops, $control_ops);
 	}

 	function form( $instance ) {
	$admin_email = get_option( 'admin_email' );
 	$defaults = array('contact_email' => $admin_email,'title'=>'Contact'); 		
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
    
    <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title :', 'cubby'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="" />
		</p>
  
            <p>
            <label for="<?php echo $this->get_field_id( 'contact_email'  ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Email', 'cubby'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'contact_email'  ); ?>" name="<?php echo $this->get_field_name( 'contact_email'  ); ?>" value="<?php echo $instance['contact_email']; ?>" class="" />
            
            
            </p>
            <p><?php _e("Your email address which use to receive email.","cubby");?></p>

		<?php

	}

 function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance[ 'contact_email']  =  $new_instance['contact_email'] ;
		$instance[ 'title']       =  $new_instance['title' ] ;
	//	$instance[ 'sub_title']   =  $new_instance['sub_title' ] ;
		

		return $instance;
	}

	function widget( $args, $instance ) {
 		extract( $args );
 		extract( $instance );
		
		echo $before_widget;
		if($title){
			echo $before_title . $title . $after_title;
		}
		echo '<div class="contact">
									<form action="'.esc_url(home_url('/')).'" class="contact-form" method="post">
			                        	<fieldset>
											<section>
												<label for="contact-name" class="sr-only">'.__("Name","cubby").'</label>
												<input type="text" name="contact-name" id="contact-name" placeholder="'.__("YOUR NAME","cubby").'*" tabindex="1" required="" aria-required="true">
											</section>
											<section>
												<label for="contact-email" class="sr-only">'.__("Email","cubby").'</label>
												<input type="email" name="contact-email" id="contact-email" placeholder="'.__("YOUR E-MAIL","cubby").'*" tabindex="2" required="" aria-required="true">
											</section>
											<section>
												<label for="contact-msg" class="sr-only">'.__("Message","cubby").'</label>
												<textarea name="contact-msg" id="contact-msg" cols="39" rows="5" tabindex="3" placeholder="'.__("YOUR MESSAGE","cubby").'*"></textarea>
											</section>
										</fieldset>
										<section>
											<span><div id="loading"></div></span><input type="submit" value="'.__("SEND MESSAGE","cubby").'">
										</section>
									</form>
								</div>';
		echo $after_widget;
 	}
 }