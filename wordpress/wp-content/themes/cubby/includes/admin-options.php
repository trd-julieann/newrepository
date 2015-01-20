<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */
function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option(CUBBY_OPTIONS_PREFIXED.'optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option(CUBBY_OPTIONS_PREFIXED.'optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */
 

function optionsframework_options() {

	// Background Defaults
	
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );
	//Breadcrumb Navigation Background
	$header_background = array(
		'color' => '#CCCCCC',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'inherit',
		'style' => 'normal',
		'color' => '#666666' );
      
	  //Tagline Typography Defaults
	$tagline_typography_defaults = array(
		'size' => '13px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#666666' );
		
		   
	  //Header Menu Typography Defaults
	$header_menu_typography_defaults = array(
		'size' => '16px',
		'face' => 'Arial',
		'style' => 'normal',
		'color' => '#555555' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);


		
	
	// Pull all the categories into an array
	$options_categories = array("0"=>__("All Categories","cubby"));
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  CUBBY_THEME_BASE_URL . '/images/';

	$options = array();
/// HEADER
	$options[] = array(
		'name' => __('Header Settings', 'cubby'),
		'type' => 'heading');
     $options[] = array(
		'name' => __('Top Contact Info', 'cubby'),
		'id' => 'top_contact_info',
		'std' => 'Contact +01 2345 6789 | info@example.com',
		'type' => 'text');
		

	$options[] = array(
		'name' => __('Upload Logo', 'cubby'),
		'desc' => __('Upload a logo image, or enter the URL to an image if its already uploaded. The themes default logo gets applied if the input field is left blank .  Logo Dimension: 240px * 75px (if your logo is larger you might need to modify style.css to align it perfectly).', 'cubby'),
		'id' => 'logo',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Favicon', 'cubby'),
		'desc' => __('An icon associated with a URL that is variously displayed, as in a browser\'s address bar or next to the site name in a bookmark list. Learn more about <a href="'.esc_url("http://en.wikipedia.org/wiki/Favicon").' target="_blank">Favicon</a>', 'cubby'),
		'id' => 'favicon',
		'type' => 'upload');
		


		$options[] = array( 'name' => __('Header Menu Typography', 'cubby'),
		'id'   => "menu_fonts_color",
		'std'  => $header_menu_typography_defaults,
		'type' => 'typography' );

		
		$options[] = array(
		'name' =>  __('Breadcrumb Background', 'cubby'),
		'id' => 'breadcrumb_background',
		'std' => $background_defaults,
		'type' => 'background' );
	////
		
	$options[] = array(
		'name' => __('Custom CSS', 'cubby'),
		'desc' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'cubby'),
		'id' => 'header_code',
		'std' => 'body{margin:0px;}',
		'type' => 'textarea');
		
		
	$options[] = array(
		'name' => __('Skype url', 'cubby'),
		'desc' => __('Your Skype Url', 'cubby'),
		'id' => 'social_skype',
		'type' => 'text');
	$options[] = array(
		'name' => __('Facebook url', 'cubby'),
		'desc' => __('Your facebook url', 'cubby'),
		'id' => 'social_facebook',
		'type' => 'text');
	$options[] = array(
		'name' => __('Twitter url', 'cubby'),
		'desc' => __('Your Twitter url', 'cubby'),
		'id' => 'social_twitter',
		'type' => 'text');
	$options[] = array(
		'name' => __('Google plus url', 'cubby'),
		'desc' => __('Your Google plus url', 'cubby'),
		'id' => 'social_google_plus',
		'std' => "",
		'type' => 'text');
	$options[] = array(
		'name' => __('Youtube url', 'cubby'),
		'desc' => __('Your Youtube Url', 'cubby'),
		'id' => 'social_youtube',
		'type' => 'text');
	$options[] = array(
		'name' => __('Pinterest url', 'cubby'),
		'desc' => __('Your Pinterest Url', 'cubby'),
		'id' => 'social_pinterest',
		'type' => 'text');
	
		$options[] = array(
		'name' => __('Linkedin url', 'cubby'),
		'desc' => __('Your Linkedin Url', 'cubby'),
		'id' => 'social_linkedin',
		'type' => 'text');
	$options[] = array(
		'name' => __('Rss url', 'cubby'),
		'desc' => __('Your Rss feed Url', 'cubby'),
		'id' => 'social_rss',
		'std' => get_bloginfo('rss2_url'),
		'type' => 'text');
		
	////	BODY
		
	$options[] = array(
		'name' => __('Body Style', 'cubby'),
		'type' => 'heading');
		
   /* $options[] = array(
		'name' =>  __('Body Background', 'cubby'),
		'desc' => __('Change the body background CSS.', 'cubby'),
		'id' => 'body_background',
		'std' => $background_defaults,
		'type' => 'background' );*/
		$options[] = array( 'name' => __('Content Typography', 'cubby'),
		'desc' => __('Content typography.', 'cubby'),
		'id' => "content_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );
		
		
		
		
  
		////HOME PAGE
		$options[] = array(
		'name' => __('Home Page', 'cubby'),
		'type' => 'heading');
		
		$options[] = array(
		'name' => __('Enable Home Page Layout', 'cubby'),
		'desc' => __('Active custom home page layout.', 'cubby'),
		'id' => 'enable_home_page',
		'std'=>1,
		'type' => 'checkbox');
		
		//HOME PAGE SLIDER
		$options[] = array('name' => __('Top Slideshow', 'cubby'),'id' => 'group_title','type' => 'title');
		
		$options[] = array('name' => __('Slide 1', 'cubby'),'id' => 'slide_group_start_1','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_slide_image_1','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-banner-1.jpg');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_slide_title_1','type' => 'text','std'=>'Title 1');
		$options[] = array('name' => __('Text', 'cubby'),'id' => 'cubby_slide_text_1','type' => 'textarea','std'=>'Hic modo aliquid, ut infra ius textus amet tincidunt imago sedere involvent opportune. Usque essent omnia spatiosa satis sedeat. Yeah ... Sic. Nunquam tanta esse bonum est.');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_slide_link_1','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_1','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 2', 'cubby'),'id' => 'slide_group_start_2','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_slide_image_2','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-banner-2.jpg');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_slide_title_2','type' => 'text','std'=>'Title 2');
		$options[] = array('name' => __('Text', 'cubby'),'id' => 'cubby_slide_text_2','type' => 'textarea','std'=>'Hic modo aliquid, ut infra ius textus amet tincidunt imago sedere involvent opportune. Usque essent omnia spatiosa satis sedeat. Yeah ... Sic. Nunquam tanta esse bonum est.');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_slide_link_2','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_2','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 3', 'cubby'),'id' => 'slide_group_start_3','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_slide_image_3','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_slide_title_3','type' => 'text');
		$options[] = array('name' => __('Text', 'cubby'),'id' => 'cubby_slide_text_3','type' => 'textarea');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_slide_link_3','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_3','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 4', 'cubby'),'id' => 'slide_group_start_4','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_slide_image_4','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_slide_title_4','type' => 'text');
		$options[] = array('name' => __('Text', 'cubby'),'id' => 'cubby_slide_text_4','type' => 'textarea');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_slide_link_4','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_4','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 5', 'cubby'),'id' => 'slide_group_start_5','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_slide_image_5','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_slide_title_5','type' => 'text');
		$options[] = array('name' => __('Text', 'cubby'),'id' => 'cubby_slide_text_5','type' => 'textarea');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_slide_link_5','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_5','type' => 'end_group');
		
		
		//END HOME PAGE SLIDER
		
		$options[] = array(
	  'name' => __('Section #1(slogan)', 'cubby'),
	   'id'   => "subsection_1",
	   'type' => 'subsection'
	   );
		
	/*	$options[] = array(
		'name' => __('Top Testimonial', 'cubby'),
		'id' => 'top_testimonial',
		'desc' => 'Go and <a href="'.admin_url("post-new.php").'?post_type=cubby_testimonial">create testimonial</a>.',
		'std' => '',
		'options'=>$top_testimonial,
		'type' => 'select');*/
		////testimonials
		$options[] = array(
		'name' => __('Author', 'cubby'),
		'desc' => '',
		'id' => 'slogan_author_1',
		'std' => 'Aimee',
		'class' => 'column_1_3',
		'type' => 'text');
		$options[] = array(
		'name' => __('Slogan', 'cubby'),
		'id' => 'slogan_content_1',
		'class' => 'column_2_3 last',
		'std' => 'Respondit, quod bene propositum / industria adaptat ad perfectum in omnibus mobilibus, sicut et ratio, decernere, tabulis et desktops.',
		'type' => 'textarea');
		
		$options[] = array(
		'name' => __('Author', 'cubby'),
		'desc' => '',
		'id' => 'slogan_author_2',
		'std' => 'Reagan',
		'class' => 'column_1_3',
		'type' => 'text');
		$options[] = array(
		'name' => __('Slogan', 'cubby'),
		'id' => 'slogan_content_2',
		'class' => 'column_2_3 last',
		'std' => 'Pone, tincidunt ope simplicis tantum trahendo et distillans eget. Quis non coding artes exiguntur.',
		'type' => 'textarea');
			$options[] = array(
		'name' => __('Author', 'cubby'),
		'desc' => '',
		'id' => 'slogan_author_3',
		'std' => 'Ishara',
		'class' => 'column_1_3',
		'type' => 'text');
		$options[] = array(
		'name' => __('Slogan', 'cubby'),
		'id' => 'slogan_content_3',
		'class' => 'column_2_3 last',
		'std' => 'Curabitur a full width respondit, et labor lapsus est, cum effectus vident, et interim retinet, vel tuum, SEO ipsum.',
		'type' => 'textarea');
			$options[] = array(
		'name' => __('Author', 'cubby'),
		'desc' => '',
		'id' => 'slogan_author_4',
		'std' => 'Jessie',
		'class' => 'column_1_3',
		'type' => 'text');
		$options[] = array(
		'name' => __('Slogan', 'cubby'),
		'id' => 'slogan_content_4',
		'class' => 'column_2_3 last',
		'std' => 'Magna cum re, sicut hodierna navigatores Incendia Chrome Safari, Penitus Rimor VIII Opera, X et IX.',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Author', 'cubby'),
		'desc' => '',
		'id' => 'slogan_author_5',
		'std' => 'Lucy',
		'class' => 'column_1_3',
		'type' => 'text');
		$options[] = array(
		'name' => __('Slogan', 'cubby'),
		'id' => 'slogan_content_5',
		'class' => 'column_2_3 last',
		'std' => 'In C + et creare pulchra et fortis Shortcodes amet elit volutpat faucibus.',
		'type' => 'textarea');
		////
	  $options[] = array(
	  'name' => __('Section #2', 'cubby'),
	   'id'   => "subsection_2",
	   'type' => 'subsection'
	   );
	   
	   $options[] = array(
		'name' => __('Features Slider Title', 'cubby'),
		'desc' => '',
		'id' => 'content_slideshow_title',
		'std' => 'Features',
		'class' => '',
		'type' => 'text');
		
		//HOME PAGE Features SLIDER
		$options[] = array('name' => __('Features Slideshow (Image size: 340x280 px)', 'cubby'),'id' => 'group_title','type' => 'title');
		
		$options[] = array('name' => __('Slide 1', 'cubby'),'id' => 'slide_group_start_1','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_features_slide_image_1','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-features1.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_features_slide_title_1','type' => 'text','std'=>'Title 1');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_features_slide_link_1','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_1','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 2', 'cubby'),'id' => 'slide_group_start_2','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_features_slide_image_2','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-features2.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_features_slide_title_2','type' => 'text','std'=>'Title 2');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_features_slide_link_2','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_2','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 3', 'cubby'),'id' => 'slide_group_start_3','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_features_slide_image_3','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_features_slide_title_3','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_features_slide_link_3','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_3','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 4', 'cubby'),'id' => 'slide_group_start_4','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_features_slide_image_4','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_features_slide_title_4','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_features_slide_link_4','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_4','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 5', 'cubby'),'id' => 'slide_group_start_5','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_features_slide_image_5','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_features_slide_title_5','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_features_slide_link_5','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_5','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 6', 'cubby'),'id' => 'slide_group_start_6','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_features_slide_image_6','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_features_slide_title_6','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_features_slide_link_6','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_6','type' => 'end_group');
		
		
		//END HOME PAGE Features SLIDER
		
		$options[] = array(
		'name' => __('Latest News List Title', 'cubby'),
		'desc' => '',
		'id' => 'latest_news_title',
		'std' => 'Latest News',
		'class' => '',
		'type' => 'text');
		
		
      $options[] = array(
		'name' => __('Latest News', 'cubby'),
		'id' => 'latest_news',
		'desc' => '',
		'std' => '',
		'class'=>'',
		'options'=>$options_categories,
		'type' => 'select');
	  
		
		$options[] = array(
		'name' => __('Static Content &nbsp;(If you input the text in this area,that mean it will not show the latest news)', 'cubby'),
		'id' => 'static_content',
		'desc' => '',
		'std' => '',
		'class'=>'',
		'type' => 'editor');
		
		
		
		
		
		
		
	 $options[] = array(
	  'name' => __('Section #3', 'cubby'),
	   'id'   => "subsection_3",
	   'type' => 'subsection'
	   );

     $options[] = array(
		'name' => __('Text', 'cubby'),
		'id' => 'home_purchase',
		'std' => 'Like it ? <a href="#">Purchase Now</a> !',
		'type' => 'textarea');
		
	$options[] = array(
	  'name' => __('Section #4', 'cubby'),
	   'id'   => "subsection_4",
	   'type' => 'subsection'
	   );
	
	$options[] = array(
		'name' => __('Section Title', 'cubby'),
		'desc' => '',
		'id' => 'portfolio_title',
		'std' => 'Our Products',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Page 1', 'cubby'),
		'id' => 'portfolio_1',
		'desc' => '',
		'std' => '',
		'class'=>'',
		'options'=>$options_pages,
		'type' => 'select');
	$options[] = array(
		'name' => __('Page 2', 'cubby'),
		'id' => 'portfolio_2',
		'desc' => '',
		'std' => '',
		'class'=>'',
		'options'=>$options_pages,
		'type' => 'select');
	$options[] = array(
		'name' => __('Page 3', 'cubby'),
		'id' => 'portfolio_3',
		'desc' => '',
		'std' => '',
		'class'=>'',
		'options'=>$options_pages,
		'type' => 'select');
	$options[] = array(
		'name' => __('Page 4', 'cubby'),
		'id' => 'portfolio_4',
		'desc' => '',
		'std' => '',
		'class'=>'',
		'options'=>$options_pages,
		'type' => 'select');
	
	$options[] = array(
	  'name' => __('Section #5', 'cubby'),
	   'id'   => "subsection_5",
	   'type' => 'subsection'
	   );
	   
	 $options[] = array(
		'name' => __('Bottom Carousel Title', 'cubby'),
		'desc' => '',
		'id' => 'bottom_carousel_title',
		'std' => 'Our Partners',
		'type' => 'text');
		
		
		//HOME PAGE Bottom Carousel Slider
		$options[] = array('name' => __('Bottom Carousel Slideshow (Image size: 205x150 px)', 'cubby'),'id' => 'group_title','type' => 'title');
		
		$options[] = array('name' => __('Slide 1', 'cubby'),'id' => 'slide_group_start_1','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_1','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_1','type' => 'text','std'=>'Title 1');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_1','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_1','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 2', 'cubby'),'id' => 'slide_group_start_2','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_2','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_2','type' => 'text','std'=>'Title 2');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_features_slide_link_2','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_2','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 3', 'cubby'),'id' => 'slide_group_start_3','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_3','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_3','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_3','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_3','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 4', 'cubby'),'id' => 'slide_group_start_4','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_4','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_4','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_4','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_4','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 5', 'cubby'),'id' => 'slide_group_start_5','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_5','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_5','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_5','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_5','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 6', 'cubby'),'id' => 'slide_group_start_6','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_6','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_6','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_6','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_6','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 7', 'cubby'),'id' => 'slide_group_start_7','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_7','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_7','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_7','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_7','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 8', 'cubby'),'id' => 'slide_group_start_8','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_8','type' => 'upload','std'=>CUBBY_THEME_BASE_URL.'/images/cubby-partners.png');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_8','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_8','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_8','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 9', 'cubby'),'id' => 'slide_group_start_9','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_9','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_9','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_9','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_9','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 10', 'cubby'),'id' => 'slide_group_start_10','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'cubby'),'id' => 'cubby_carousel_slide_image_10','type' => 'upload');
		$options[] = array('name' => __('Title', 'cubby'),'id' => 'cubby_carousel_slide_title_10','type' => 'text');
		$options[] = array('name' => __('Link', 'cubby'),'id' => 'cubby_carousel_slide_link_10','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_10','type' => 'end_group');
		//END HOME PAGE Bottom Carousel Slider
		
		
		
		//FOOTER
		$options[] = array(
		'name' => __('Footer', 'cubby'),
		'type' => 'heading');
		
		$options[] = array(
		'name' =>  __('Footer Widget Area Background', 'cubby'),
		'id' => 'footer_widget_background',
		'std' => $header_background,
		'type' => 'background' );
		
		$options[] = array(
		'name' 	=> __('Footer Text', 'cubby'),
		'id' 	=> 'cubby_footer_text',
		'std' 	=> 'Cubby WordPress theme, Copyright &copy; 2014. All Rights Reserved.',
		'type' 	=> 'editor');
		

	return $options;
}






















