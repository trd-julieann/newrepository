<?php
/**
 * The Header for our theme.
 *
 */
 global $cubby_options;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title('|', true, 'right'); ?></title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if(is_home()) $wrap_class = "homepage"; else $wrap_class = "blog-list-page both-aside";?>
	<div class="<?php echo $wrap_class;?>">
		<!--Header-->
		<header>
			<div class="header-menu">
				<div class="container">
					<div class="header-contact"><?php  echo cubby_options_array('top_contact_info') ; ?></div>
					<div class="header-sns">
                    <?php echo cubby_get_social_network(array("skype","facebook",'twitter','google-plus','youtube',"linkedin",'pinterest','rss'));?> 
					</div>
				</div>
			</div>
			<div class="header-main">
				<div class="container">
					<div class="logo-box text-left">
                    <?php if ( cubby_options_array('logo')!="") { ?>
						<a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo cubby_options_array('logo'); ?>" alt="<?php bloginfo('name'); ?>" /></a>
        <?php }?>
        				<div class="name-box">
							<a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
							<span class="site-tagline"><?php echo  get_bloginfo( 'description' );?></span>
						</div>
					</div>
					<button class="site-nav-toggle">
						<span class="sr-only"><?php _e("Toggle navigation","cubby");?></span>
						<i class="fa fa-bars fa-2x"></i>
					</button>
					<nav class="site-nav" role="navigation">
							<?php
        wp_nav_menu(array('theme_location'	=>'primary',
						  'depth'			=>0,
						  'container'		=>'',
						  'fallback_cb' =>false,
						  'container_class'	=>'main-menu',
						  'menu_id'			=>'menu-main',
						  'menu_class'		=>'main-nav',
						  'link_before' 	=> '<span>', 
						  'link_after' 		=> '</span>'));
        ?>
					</nav>
				</div>
			</div>
		</header>