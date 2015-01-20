<?php
if( ! defined('CUBBY_THEME_BASE_URL' ) ) 	 { 	define( 'CUBBY_THEME_BASE_URL', get_template_directory_uri()); }
if( ! defined('CUBBY_OPTIONS_FRAMEWORK' ) ) 	 { 	define( 'CUBBY_OPTIONS_FRAMEWORK', get_template_directory().'/admin/' ); }
if( ! defined('CUBBY_OPTIONS_FRAMEWORK_URI' ) ){	define( 'CUBBY_OPTIONS_FRAMEWORK_URI',  CUBBY_THEME_BASE_URL. '/admin/'); }
if( ! defined('CUBBY_OPTIONS_PREFIXED' ) ){    define('CUBBY_OPTIONS_PREFIXED' ,'cubby_');}

require_once( CUBBY_OPTIONS_FRAMEWORK.'options-framework.php' );
require_once( 'includes/metabox-options.php' );
require_once( 'includes/register-widget.php' );
require_once( 'includes/class-breadcrumb.php' );

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 */


function cubby_setup(){
	global $content_width;
	$lang = CUBBY_THEME_BASE_URL. '/languages';
	load_theme_textdomain('cubby', $lang);
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => '',
        'default-text-color'     => '555555',
        'width'                  => 1170,
        'height'                 => 80,
        'flex-height'            => true
     );
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	register_nav_menus( array('primary' => __( 'Header Menu', 'cubby' )));
	register_nav_menus( array('footer_menu' => __( 'Footer Menu', 'cubby' )));
	add_editor_style("editor-style.css");
	
	add_image_size( 'blog-list', 747, 999999 , true);  
	add_image_size( 'home-news', 110, 70 , true); 
	add_image_size( 'home-carousel', 205, 150, true ); //(cropped)
	add_image_size( 'sidebar-posts', 60, 45 , true); 
	add_image_size( 'portfolio', 400, 300 , true);
    if ( ! isset( $content_width ) ) $content_width = 1170;
	
}

add_action( 'after_setup_theme', 'cubby_setup' );


function cubby_of_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option(CUBBY_OPTIONS_PREFIXED.'optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}



function cubby_of_get_options($default = false) {
	
	$optionsframework_settings = get_option(CUBBY_OPTIONS_PREFIXED.'optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options) ) {
		return $options;
	} else {
		return $default;
	}
}

global $cubby_options;
$cubby_options = cubby_of_get_options();

function cubby_options_array($name){
	global $cubby_options;
	if(isset($cubby_options[$name]))
	return $cubby_options[$name];
	else
	return "";
}
// set default options
function cubby_on_switch_theme(){
global $cubby_options;
 $optionsframework_settings = get_option( CUBBY_OPTIONS_PREFIXED.'optionsframework' );
 if(!get_option($optionsframework_settings['id'])){
 $config = array();
 $output = array();
 $location = apply_filters( 'options_framework_location', array('admin-options.php') );

	        if ( $optionsfile = locate_template( $location ) ) {
	            $maybe_options = require_once $optionsfile;
	            if ( is_array( $maybe_options ) ) {
					$options = $maybe_options;
	            } else if ( function_exists( 'optionsframework_options' ) ) {
					$options = optionsframework_options();
				}
	        }
	    $options = apply_filters( 'of_options', $options );
		$config  =  $options;
		foreach ( (array) $config as $option ) {
			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['std'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}
				$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
		}
		add_option($optionsframework_settings['id'],$output);

		
}
$cubby_options = cubby_of_get_options();
}
add_action( 'after_setup_theme', 'cubby_on_switch_theme' );
add_action('after_switch_theme', 'cubby_on_switch_theme');

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'cubby_optionsframework_custom_scripts');

function cubby_optionsframework_custom_scripts() { 

}


add_filter('options_framework_location','cubby_options_framework_location_override');

function cubby_options_framework_location_override() {
	return array('includes/admin-options.php');
}


/* 
 * Change the menu title name and slug
 */
 
 
function cubby_optionscheck_options_menu_params( $menu ) {
	
	$menu['page_title'] = __( 'Cubby Options', 'cubby');
	$menu['menu_title'] = __( 'Cubby Options', 'cubby');
	$menu['menu_slug'] = 'cubby-options';
	return $menu;
}

add_filter( 'optionsframework_menu', 'cubby_optionscheck_options_menu_params' );


function cubby_wp_title( $title, $sep ) {
	global $paged, $page;
 
	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'cubby' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'cubby_wp_title', 10, 2 );


function cubby_title( $title ) {
  if ( $title == '' ) {
  return 'Untitled';
  } else {
  return $title;
  }
}
add_filter( 'the_title', 'cubby_title' );

add_action( 'wp_head', 'cubby_favicon' );

	function cubby_favicon()
	{
	    $url =  cubby_options_array('favicon');
		$icon_link = "";
		if($url)
		{
			$type = "image/x-icon";
			if(strpos($url,'.png' )) $type = "image/png";
			if(strpos($url,'.gif' )) $type = "image/gif";
		
			$icon_link = '<link rel="icon" href="'.esc_url($url).'" type="'.$type.'">';
		}
		
		echo $icon_link;
	}

////register styles & scripts
  function cubby_custom_scripts(){
    global $content_width,$post;

    wp_enqueue_script( 'nivo-slider', CUBBY_THEME_BASE_URL.'/js/jquery.nivo.slider.pack.js', array("jquery"), '3.2', false );
	wp_enqueue_script('owl-carousel', CUBBY_THEME_BASE_URL.'/js/owl.carousel.min.js',  array("jquery"), '', false );
	wp_enqueue_script( 'cubby-respond', get_template_directory_uri().'/js/respond.min.js', array( 'jquery' ), '', false );
	wp_enqueue_script( 'cubby-modernizr', get_template_directory_uri().'/js/modernizr.custom.js', array( 'jquery' ), '2.8.2', false );
	wp_enqueue_script('cubby-default', CUBBY_THEME_BASE_URL.'/js/cubby.js', array("jquery"), '1.1.0', false);
	if ( is_singular() ){
	wp_enqueue_script( 'comment-reply' );}
	
    wp_enqueue_style('bootstrap', CUBBY_THEME_BASE_URL.'/styles/bootstrap.css', false, '', false);
    wp_enqueue_style('font-awesome', CUBBY_THEME_BASE_URL.'/styles/font-awesome.min.css', false, '', false);
	wp_enqueue_style( 'cubby-main', get_stylesheet_uri(), array(), '1.1.0' );
	wp_enqueue_style('cubby-scheme', CUBBY_THEME_BASE_URL.'/styles/scheme.less', false, '1.0.9', false);
	
	wp_enqueue_style( 'Yanone-Kaffeesatz', esc_url('//fonts.googleapis.com/css?family=Yanone+Kaffeesatz'), false, '', false );
	wp_enqueue_style( 'Open-Sans', esc_url('//fonts.googleapis.com/css?family=Open+Sans'), false, '', false );
	
	 if(isset($post->ID) && is_numeric($post->ID) ){
	$top_slider      = get_post_meta( $post->ID, '_cubby_top_slider', true );
	if($top_slider !="" && $top_slider!=0){
	wp_enqueue_style('nivo-styles', CUBBY_THEME_BASE_URL.'/js/nivo-theme/default.css', false, '', false);
	}
	}
	
	wp_localize_script( 'cubby-default', 'cubby_params',  array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => CUBBY_THEME_BASE_URL,
		)  );
	
	$custom_css = "";
	$menu_fonts_color = cubby_options_array('menu_fonts_color');
	if ($menu_fonts_color) { 
	$custom_css .= '.site-nav ul:first-child > li > a > span{font-family: ' . $menu_fonts_color['face']. '; font-size:'.$menu_fonts_color['size'] . '; font-style: ' . $menu_fonts_color['style'] . '; color:'.$menu_fonts_color['color'].';font-weight:'.$menu_fonts_color['style'] . '}';
	}
	
	
	//// header background
	$header_image = get_header_image();
	if (isset($header_image) && ! empty( $header_image )) {
	$custom_css .= ".header-main{background:url(".$header_image. ") repeat;}\n";
	}
    if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
            $blog_title_style = ' display:none;';
        else
            $blog_title_style = ' color:#' . get_header_textcolor() . ';';
		$custom_css .= ".header-main .logo-box .site-name,.header-main .logo-box .site-tagline{".$blog_title_style."}\n";	
	
	//// breadcrumb background
	
	$breadcrumb_background = cubby_options_array('breadcrumb_background');
	if ($breadcrumb_background) {
	if (isset($breadcrumb_background['image']) && $breadcrumb_background['image']!="") {
	$custom_css .= ".breadcrumb-box{background:url(".$breadcrumb_background['image']. ")  ".$breadcrumb_background['repeat']." ".$breadcrumb_background['position']." ".$breadcrumb_background['attachment']."}\n";
	}
	else
	{
	if(isset($breadcrumb_background['color']) && $breadcrumb_background['color'] !=""){
	$custom_css .= "body .breadcrumb-box{ background:".$breadcrumb_background['color'].";}\n";
	}
	}
	}

	//// content typography
	$content_typography = cubby_options_array('content_typography');
	if ($content_typography) { 
	$custom_css .= '.entry-content{font-family: ' . $content_typography['face']. '; font-size:'.$content_typography['size'] . '; font-style: ' . $content_typography['style'] . '; color:'.$content_typography['color'].';font-weight:'.$content_typography['style'] . ';}';
	}
	
	
	// footer background
	
	//// header background
	$footer_widget_background = cubby_options_array('footer_widget_background');
	if ($footer_widget_background) {
	if (isset($footer_widget_background['image']) && $footer_widget_background['image']!="") {
	$custom_css .= ".footer-widgets-area{background:url(".$footer_widget_background['image']. ")  ".$footer_widget_background['repeat']." ".$footer_widget_background['position']." ".$footer_widget_background['attachment']."}\n";
	}
	else
	{
	if(isset($footer_widget_background['color']) && $footer_widget_background['color'] !=""){
	$custom_css .= ".footer-widgets-area{ background:".$footer_widget_background['color'].";}\n";
	}
	}
	}
	//Footer fonts color
	$footer_fonts_color = cubby_options_array('footer_fonts_color');
	if ($footer_fonts_color) {
	$custom_css .= ".footer-widgets-area{ color:".$footer_fonts_color.";}\n";
	}
	
	if(isset($post->ID)){ 
	 $cubby_top_slider_width = get_post_meta( $post->ID, '_cubby_top_slider_width', true );
	 
	 if($cubby_top_slider_width == "boxed"){
	 $custom_css .= ".banner{width:".$content_width."px;overflow: hidden;}"; 
	 }
	}
	
	$custom_css .= cubby_options_array('header_code');
    wp_add_inline_style( 'cubby-main', $custom_css );
 }
   if (!is_admin()) {
  add_action( 'wp_enqueue_scripts', 'cubby_custom_scripts' );
  }
  


  	/*-------------------------------------------------------------------------------------------*/
/* Get  carousel*/
/*-------------------------------------------------------------------------------------------*/
 function cubby_get_carousel($id = 'features',$container = "cubby-carousel",$size = "",$num = 5){
    $return = "";
	$image_size = "";
    $return = '<div id="'.$container.'" class="cubby-owl-carousel owl-carousel">';
 
	if($size !=""){
	$size_pice = explode("x",strtolower($size));
	if(is_numeric($size_pice[0]) && is_numeric($size_pice[1])){
	$image_size = 'width="'.$size_pice[0].'" height="'.$size_pice[1].'"';
	}
	}
	
	 for($i=1;$i<=$num;$i++){
	 $title = cubby_options_array('cubby_'.$id.'_slide_title_'.$i);
	 $image = cubby_options_array('cubby_'.$id.'_slide_image_'.$i);
	 $link  = cubby_options_array('cubby_'.$id.'_slide_link_'.$i);
	
	 if(isset($image) && strlen($image)>10){
	 if($link!=""){
	   $return .= '<div class="item"><a href="'.esc_url($link).'"><img '.$image_size.' src="'.$image.'" alt="'.$title.'" /></a></div>';
	}else{
	   $return .= '<div class="item"><img '.$image_size.' src="'.$image.'" alt="'.$title.'" /></div>';
	   }
	 }
	 
	 }
			
    $return .= '</div>'; 

	return  $return ;
 
 }
  
/*
*  page navigation
*
*/
function cubby_native_pagenavi($echo,$wp_query){
    if(!$wp_query){global $wp_query;}
    global $wp_rewrite;      
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
    'base' => @add_query_arg('paged','%#%'),
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'prev_text' => '&laquo;',
    'next_text' => '&raquo;'
    );
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
    if($echo == "echo"){
    echo '<p class="page_navi">'.paginate_links($pagination).'</p>'; 
	}else
	{
	
	return '<p class="page_navi">'.paginate_links($pagination).'</p>';
	}
}
   
   //// Get header social network icon list 
   
   function cubby_get_social_network($args){
   $return = "";
   if(is_array($args)){
   $return = '';
   foreach($args as $social){
   $social_link = cubby_options_array('social_'.$social);
   if($social_link!=""){
    $return .=  '<a href="'.esc_url($social_link).'" title="'.ucwords(str_replace("-"," ",$social)).'" target="_blank"><i class="fa fa-'.$social.'"></i></a>';
	}
   }
  
   }
   return $return;
   }
   // Get sidebar
   function cubby_get_sidebar($sidebar,$default=false){
   if ( function_exists('dynamic_sidebar')){
	if(is_active_sidebar($sidebar)){
	   dynamic_sidebar($sidebar);
	}
	else{
	if($default==true){
	dynamic_sidebar(1) ;
	}
	
	}
	}else{wp_link_pages(); } 
   }
   
   //// Custom comments list
   
   function cubby_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ;?>">
     <div id="comment-<?php comment_ID(); ?>">
	 
	 <div class="comment-avatar"><?php echo get_avatar($comment,'52','' ); ?></div>
			<div class="comment-info">
			<div class="reply-quote">
             <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
			</div>
      <div class="comment-author vcard">
        
			<span class="fnfn"><?php printf(__('%s </cite><span class="says">says:</span>','cubby'), get_comment_author_link()) ;?></span>
								<span class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">
<?php printf(__('%1$s at %2$s','cubby'), get_comment_date(), get_comment_time()) ;?></a>
<?php edit_comment_link(__('(Edit)','cubby'),'  ','') ;?></span>
				<span class="comment-meta">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">-#<?php echo $depth?></a>				</span>

      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.','cubby') ;?></em>
         <br />
      <?php endif; ?>
      <?php comment_text() ;?>
  </div>
 </div>
       
<?php

        }
	// get 	excerpt length
	
function cubby_cover_excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
    }
	
//// get breadcrumb wrapper and slider

function cubby_get_breadcrumb(){
   global $post;
   $show_breadcrumb = "";
   if(isset($post->ID) && is_numeric($post->ID)){
    $show_breadcrumb = get_post_meta( $post->ID, '_cubby_show_breadcrumb', true );
	}
	
	if($show_breadcrumb == 1 || $show_breadcrumb==""){
		
		echo  '<div class="breadcrumb-box">
            <div class="container">
                <div class="breadcrumb-link">';
                    new cubby_breadcrumb;
              echo  '</div>
                <form role="search" action="'.esc_url(home_url('/')).'"  class="breadcrumb-search">
                    <div>
                        <label class="sr-only">'.__("Search for","cubby").':</label>
                        <input type="text" value="Search" onFocus="if(this.value==\'Search\'){this.value=\'\'}" id="s" onBlur="if(this.value==\'\'){this.value=\'Search\'}" name="s">
                        <input type="submit" name="sa" value="">
                    </div>
                </form>
            </div>
        </div>';
	
	}
}
function cubby_get_slider(){


    $slide_caption = "";
	$slides = "";

	
	$return = '<div class="banner"><div class="slider-wrapper theme-bar"><div id="top-slider" class="nivoSlider">';
	 for($i=1;$i<=5;$i++){
	 $title = cubby_options_array('cubby_slide_title_'.$i);
	 $text  = cubby_options_array('cubby_slide_text_'.$i);
	 $image = cubby_options_array('cubby_slide_image_'.$i);
	 $link  = cubby_options_array('cubby_slide_link_'.$i);
	
	 if(isset($image) && strlen($image)>10){
	 
	$thumb     = $image;
	$slide_img = $image;
	
	if($link!=""){ $slides .=  '<a href="'.esc_url($link).'"><img src="'.$slide_img.'" data-thumb="'.$thumb.'" alt="'.$title.'" title="#htmlcaption-'.$i.'" /></a>';}
	else{
	   $slides .=  '<img src="'.$slide_img.'" data-thumb="'.$thumb.'" alt="'.$title.'" title="#htmlcaption-'.$i.'" />';
	}
	if($title != "" || $text != ""){
	$slide_caption .= '<div id="htmlcaption-'.$i.'" class="nivo-html-caption"><h4>'.$title.'</h4><p>'.$text.'</p></div>';
	}
	
			}

	}
	    $return .= $slides;
	    $return .= '</div>';
		$return .=  $slide_caption;
		$return .= '</div></div>';
	

		echo $return;

	
   }
   
	
	
	function cubby_get_footer_text($id) {
		if (cubby_options_array($id)) { 
			return cubby_options_array($id);
		}
	}
   	
	/*This funcion make the string from footer to array, and format output it*/
	function cubby_footer_info($str){
		
		$str = cubby_get_footer_text('cubby_footer_text');							//get the string from footer
	
		if(strlen($str) > 500){
			$sum = 4-(int)((strlen($str)-300)/100);
		}else{
			$sum = 6-(int)(strlen($str)/100);
		}
		
		$arr = explode("|",$str);													//separate the footer string to array 
		
		for($i=0; $i<count($arr); $i++){											//output the array
			echo $arr[$i];
			if($i == count($arr)-1)													//do not input the last "|"
				break;
			for($j=0;$j<$sum;$j++){													//control the word spacing
				echo "&emsp;";
			}
			echo "|";
			for($j=0;$j<$sum;$j++){
				echo "&emsp;";
			}
		}
   }
   
  
     function cubby_enqueue_less_styles($tag, $handle) {
		global $wp_styles;
		$match_pattern = '/\.less$/U';
		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
			$handle = $wp_styles->registered[$handle]->handle;
			$media  = $wp_styles->registered[$handle]->args;
			$href   = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
			$rel    = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
			$title  = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
	
			$tag    = "<link rel='stylesheet' id='$handle' $title href='".esc_url($href)."' type='text/less' media='$media' />";
		}
		return $tag;
	}
	add_filter( 'style_loader_tag', 'cubby_enqueue_less_styles', 5, 2);
	
	/*	
	*	send email
	*	---------------------------------------------------------------------
	*/
function cubby_contact(){
	if(trim($_POST['contact-name']) === '') {
		$Error = __('Please enter your name.','cubby');
		$name     = "";
		$hasError = true;
	} else {
		$name = trim($_POST['contact-name']);
	}
  
	if(trim($_POST['contact-email']) === '')  {
		$Error = __('Please enter your email address.','cubby');
		$email    = "";
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['contact-email']))) {
		$Error = __('You entered an invalid email address.','cubby');
		$email    = "";
		$hasError = true;
	} else {
		$email = trim($_POST['contact-email']);
	}
	

	if(trim($_POST['contact-msg']) === '') {
		$Error =  __('Please enter a message.','cubby');
		$message  = "";
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$message = stripslashes(trim($_POST['contact-msg']));
		} else {
			$message = trim($_POST['contact-msg']);
		}
	}

	if(!isset($hasError)) {
		
		$options = get_option("widget_cubby_contact");
	
		
	   if (isset($options[2]['contact_email']) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($options[2]['contact_email']))) {
	     $emailTo = $options[2]['contact_email'];
	   }
	   else{
	 	 $emailTo = get_option('admin_email');
		}
		 if($emailTo !=""){
		$subject = 'From '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nMessage: $message";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		wp_mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
		}
		echo json_encode(array("msg"=>__("Your message has been successfully sent!" ,"cubby"),"error"=>0));
		
	}
	else
	{
	echo json_encode(array("msg"=>$Error,"error"=>1));
	}
	die() ;
	}
	add_action('wp_ajax_cubby_contact', 'cubby_contact');
	add_action('wp_ajax_nopriv_cubby_contact', 'cubby_contact');