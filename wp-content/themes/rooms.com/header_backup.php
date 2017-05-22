<?php
// get theme, site and current url's
global $general_site_content;
global $current_page_id;
global $template_url;
global $site_url;
global $form_id;

$current_page_id = get_queried_object_id();
$template_url = get_bloginfo('template_url');
$site_url = get_bloginfo('url');


// GET GENERAL SITE CONTENT
// create new custom query for general content
$args = array( 'pagename' => 'general-site-content' );
$general_content_query = new WP_Query( $args );
if ( $general_content_query->have_posts()) : while ( $general_content_query->have_posts()) : $general_content_query->the_post(); 
// populate array with all general content data
$general_site_content  = array(
    'facebook_url' => get_field('facebook_url'),
    'twitter_url' => get_field('twitter_url'),
    'pinterest_url' => get_field('pinterest_url'),
    'instagram_url' => get_field('instagram_url')
);
endwhile;
endif;
wp_reset_query();

include("shareCount.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
    <link rel="icon" href="<?php echo $template_url;?>/images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Description Here">
    <meta name="keywords" content="Keywords Here" >
    <link href="<?php echo $template_url;?>/css/bootstrap_3.0.3/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $template_url;?>/css/styles.css" rel="stylesheet">
    
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>

    <?php echo( is_home() || is_single() || is_search() )? '<link href="'.$template_url.'/css/jquery.bxslider.css" rel="stylesheet">':'' ;?>
    
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <nav id="push-navigation" class="clearfix">
        <a href="<?php echo $site_url; ?>"<?php echo ( is_home() )?' class="active"':''; ?>>Home</a>
        <?php
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        foreach ( (array) $menu_items as $key => $menu_item ) {
          $class_to_add = ( $current_page_id == $menu_item->object_id )?'active':'';
          echo '<a href="'.$menu_item->url.'" class="'.$class_to_add.'">'.$menu_item->title.'</a>';  
        }
        ?>   
    </nav>

    <div id="body-wrapper">

    <div class="top-wrapper">  

        <?php echo ( is_home() ) ? '<div class="header-ad-wrapper">' : '' ;?>

        <?php if (  is_home() ) { ?>
            <div class="container">
                <div class="header-home-ad-content">
                    <a href="#"><img  src="<?php echo $template_url;?>/images/rh-top-banner.png" /></a>
                </div> 
            </div>
        <?php } else { ?>
            <div class="container">
                <div class="header-pages-ad-content">
                    <a href="#"><img  src="<?php echo $template_url;?>/images/upload.png" /></a>
                </div> 
            </div>
        <?php } ?>

            <?php echo ( !is_home() ) ? '<div class="header-wrapper">' : '' ;?>      
            <div class="container">
                <header id="header" class="clearfix">
                    
  
                            <a href="<?php echo $site_url; ?>" class="logo"><span class="rooms-icon-logo"></span></a>

                            <div class="social-wrapper">

                                <!-- Begin MailChimp Signup Form -->
                                <div id="mc_embed_signup">
                                <form action="http://rooms.us8.list-manage1.com/subscribe/post?u=4896729838572a5cedfe97a1a&amp;id=1518ad195a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                    <input type="email" value="" name="EMAIL" class="email text-field" id="mce-EMAIL" placeholder="Enter email to subscribe" required>
                                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_c11cb1716dbf058f68e440590_5cee6c3374" tabindex="-1" value=""></div>
                                    <div class="clear"><input type="submit" value="Submit" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                                </form>
                                </div>
                                <!--End mc_embed_signup--> 


                                <nav id="social-links">
                                    <a target="_blank" class="email-link" href="#"><span class="rooms-icon-email"></span></a>
                                    <?php if( $general_site_content['facebook_url'] != '' ) { ?>
                                    <a target="_blank" href="<?php echo $general_site_content['facebook_url']; ?>"><span class="rooms-icon-facebook"></span></a>
                                    <?php } ?>
                                    <?php if( $general_site_content['twitter_url'] != '' ) { ?>
                                    <a target="_blank" href="<?php echo $general_site_content['twitter_url']; ?>"><span class="rooms-icon-twitter"></span></a>
                                    <?php } ?>
                                    <?php if( $general_site_content['pinterest_url'] != '' ) { ?>
                                    <a target="_blank" href="<?php echo $general_site_content['pinterest_url']; ?>"><span class="rooms-icon-pinterest"></span></a>
                                    <?php } ?>
                                    <?php if( $general_site_content['instagram_url'] != '' ) { ?>
                                    <a target="_blank" href="<?php echo $general_site_content['instagram_url']; ?>"><span class="rooms-icon-instagram"></span></a>
                                    <?php } ?>
                                </nav>  

                                 <?php 
                                 $form_id = 1;
                                 get_search_form(); 
                                 ?> 

                            </div>
                            <div class="nav-wrapper clearfix">
                                <a href="" class="menu-toggle dropdown-toggle"><span class="rooms-icon-menu-toggle"></span><span class="text">Menu</span></a>
                                <a href="" class="menu-toggle pushmenu-toggle"><span class="rooms-icon-menu-toggle"></span><span class="text"></span></a>
                                <?php 
                                 $form_id = 2;
                                 get_search_form(); 
                                 ?> 
                                <nav id="main-navigation" class="clearfix">
                                    <?php
                                    $locations = get_nav_menu_locations();
                                    $menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
                                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                                    foreach ( (array) $menu_items as $key => $menu_item ) {
                                      $class_to_add = ( $current_page_id == $menu_item->object_id )?'active':'';
                                      echo '<a href="'.$menu_item->url.'" class="'.$class_to_add.'">'.$menu_item->title.'</a>';  
                                    }
                                    ?>   
                                </nav>
                                                     
                            </div>


                </header>
            </div>

            <?php echo ( is_home() ) ? '<div class="header-ad-bg-image"><img  src="'.$template_url.'/images/1-Restoration-Hardware-living-room-.jpg" /></div>' : '' ;?>

            
    
            

            <?php echo ( !is_home() ) ? '</div>' : '' ;?>  

        <?php echo ( is_home() ) ? '</div>' : '' ;?>
    </div>
    

