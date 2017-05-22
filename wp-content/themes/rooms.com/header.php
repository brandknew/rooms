<?php
// get theme, site and current url's
global $general_site_content;
global $current_page_id;
global $template_url;
global $site_url;
global $form_id;
global $site_banners;

$current_page_id = get_queried_object_id();
$current_page_cat_id = get_query_var('cat');
$template_url = get_bloginfo('template_url');
$site_url = get_bloginfo('url');


// GET GENERAL SITE CONTENT

$general_site_content  = array(
    'facebook_url' => get_field('facebook_url', 'option'),
    'twitter_url' => get_field('twitter_url', 'option'),
    'pinterest_url' => get_field('pinterest_url', 'option'),
    'instagram_url' => get_field('instagram_url', 'option'),
    'googleplus_url' => get_field('googleplus_url', 'option'),
    'welcome_overlay_heading' => get_field('welcome_overlay_heading', 'option'),
    'welcome_overlay_text' => get_field('welcome_overlay_text', 'option'),
    'landing_text' => get_field('landing_text', 'option'),
    'landing_background_image' => get_field('landing_background_image', 'option')
);


// DETECT MOBILE OBJECT
global $detect;
require_once 'scripts/Mobile_Detect.php';
$detect = new Mobile_Detect;

require("shareCount.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
    <link rel="icon" href="<?php echo $template_url;?>/images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Keywords Here" >

    <?php if ( !is_home() ) { ?><meta name="googlebot,googlebot-images,bingbot,teoma" content="noindex">
    <?php } ?>
    <link href="<?php echo $template_url;?>/css/bootstrap_3.0.3/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $template_url;?>/css/styles.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
    <!-- <link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'> -->

    <?php echo( is_home() || is_single() || is_search() || is_page('home') || is_author() )? '<link href="'.$template_url.'/css/jquery.bxslider.css" rel="stylesheet">':'' ;?>
    
    <link href="<?php echo $template_url;?>/css/jquery.fancybox.css" rel="stylesheet">

    <script>var templateUrl = '<?php echo $template_url;?>/';</script>
    <script src="<?php echo $template_url;?>/scripts/jquery-1.11.3.min.js"></script>
    <?php echo(  is_home() || is_single() || is_search() || is_page('home') || is_author() )? '<script src="'.$template_url.'/scripts/jquery.bxslider.min.js"></script>':'' ;?>
    
	<?php wp_head(); ?>

    <script type="text/javascript">
    /*
    // CODE USED BEFORE INSTALLING TABOOLA WIDGET PLUGIN
      window._taboola = window._taboola || [];
      _taboola.push({article:'auto'});
      !function (e, f, u) {
        e.async = 1;
        e.src = u;
        f.parentNode.insertBefore(e, f);
      }(document.createElement('script'),
      document.getElementsByTagName('script')[0],
      'http://cdn.taboola.com/libtrc/rooms/loader.js');
*/
    </script>
        
</head>
<body <?php body_class(); ?> data-curr-page-id="<?php echo $current_page_id; ?>" data-curr-page-cat-id="<?php echo $current_page_cat_id; ?>">

    <div id="welcome-overlay" class="overlay div-table">
      <div class="div-table-cell">
        <div class="overlay-content">
          <a href="#" class="overlay-close"><span class="rooms-icon-close"></span></a>
          <p class="text-teaser"><strong><?php echo $general_site_content['welcome_overlay_heading']; ?></strong></p>
          <span class="logo">
            <span class="icon"><span class="rooms-icon-logo"></span></span>
            <span class="rooms-icon-rooms"></span>
          </span>
          <p class="text-teaser bottom"><?php echo $general_site_content['welcome_overlay_text']; ?></p>
            <!-- Begin MailChimp Signup Form -->
            <div id="mc_embed_signup">
            <form action="http://rooms.us8.list-manage1.com/subscribe/post?u=4896729838572a5cedfe97a1a&amp;id=1518ad195a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate clearfix" target="_blank" novalidate>
                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter email address" required>
                <div style="position: absolute; left: -5000px;"><input type="text" name="b_c11cb1716dbf058f68e440590_5cee6c3374" tabindex="-1" value=""></div>
                <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
            </form>
            </div>
            <!-- End mc_embed_signup--> 
        </div>
      </div>    
    </div>

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


<?php
// GET HOME LEADERBOARD CONTENT
$args = array( 'post_type' => 'adunits' );
$home_leaderboard_query = new WP_Query( $args );
if ( $home_leaderboard_query->have_posts()) : while ( $home_leaderboard_query->have_posts()) : $home_leaderboard_query->the_post();
  
  if ( $post->post_name == 'home-leaderboard' ) {

  // populate array with all leaderboard data
  $home_leaderboard  = array(
      'background_image' => get_field('background_image'),
      'banner_image' => get_field('banner_image'),
      'video_url' => get_field('video_url'),
      'ad_link' => get_field('ad_link')
  );
  // Check if featured PSA is youtube or vimeo
  if (strpos($home_leaderboard['video_url'],'http://vimeo.com/') !== false) {
    $video_type = 'vimeo';
    $video_ID = str_replace("http://vimeo.com/","",$home_leaderboard['video_url']);
  }
  if (strpos($home_leaderboard['video_url'],'https://www.youtube.com/watch?v=') !== false) {
    $video_type = 'youtube';
    $video_ID = str_replace("https://www.youtube.com/watch?v=","",$home_leaderboard['video_url']);
  }
  $home_leaderboard['video_type'] = $video_type;
  $home_leaderboard['video_id'] = $video_ID;

  }

  if ( $post->post_name == 'pages-leaderboard' ) {
    $site_banners['pages-leaderboard'] = array (
      'ad_image' => get_field('ad_image'),
      'ad_link' => get_field('ad_link')
    );
  }

  if ( $post->post_name == 'top-medium-rectangle' ) {
    $site_banners['top-medium-rectangle'] = array (
      'ad_image' => get_field('ad_image'),
      'ad_link' => get_field('ad_link')
    );
  }

  if ( $post->post_name == 'bottom-medium-rectangle' ) {
   $site_banners['bottom-medium-rectangle'] = array (
      'ad_image' => get_field('ad_image'),
      'ad_link' => get_field('ad_link')
    );
  }

endwhile;
endif;
wp_reset_query();
?>


    <?php /* if (  is_home() || is_page('home') and $home_leaderboard['banner_image'] != '') { ?>

        <div class="header-home-ad-content">
            <div class="container">
                    <?php echo ( $home_leaderboard['ad_link'] != '' )?'<a href="'.$home_leaderboard['ad_link'].'" target="_blank">':'';?>
                      <img  src="<?php echo $home_leaderboard['banner_image'];?>" />
                    <?php echo ( $home_leaderboard['ad_link'] != '' )?'</a>':'';?>
                    <div class="expandable-area">
                        <div id="expandable-ad">
                             <br>
                             <div class="responsive-video-ad">
                                 <div class="responsive-video-wrapper" data-id="<?php echo $home_leaderboard['video_id'];?>" data-type="<?php echo $home_leaderboard['video_type'];?>">
                                      <iframe class="video" src="" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                 </div>                                 
                             </div>
                        </div>
                    </div>
             </div>
             <div class="header-ad-bg-image"><img  src="<?php echo $home_leaderboard['background_image'];?>" /></div>
             <a href="#" class="home-ad-toggle"><span class="text"><span class="open">Expand</span><span class="close">Close</span></span><span class="rooms-icon-expand"></span></a>
        </div> 
    <?php } else { ?>
        <div class="header-pages-ad-content">
            <?php if ( $site_banners['pages-leaderboard']['ad_image'] !='' ) { ?>
            <div class="container">
                <a href="<?php echo $site_banners['pages-leaderboard']['ad_link'];?>" target="_blank"><img  src="<?php echo $site_banners['pages-leaderboard']['ad_image'];?>" /></a>
            </div>
            <?php } ?> 
        </div>
    <?php } */ ?>   


    <header id="header" class="clearfix">
    <div class="container">
      

            <a href="" class="menu-toggle dropdown-toggle"><span class="rooms-icon-menu-toggle"></span><span class="text">Menu</span></a>

            <a href="" class="menu-toggle pushmenu-toggle"><span class="rooms-icon-menu-toggle"></span><span class="text"></span></a>

            <a href="<?php echo $site_url; ?>" class="logo">
              <span class="icon"><span class="rooms-icon-logo"></span></span>
              <span class="rooms-icon-rooms"></span>
            </a>
                 
            <nav id="social-links">
                <!-- <a target="_blank" class="email-link" href="#"><span class="rooms-icon-email"></span></a> -->
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
                <?php if( $general_site_content['googleplus_url'] != '' ) { ?>
                <a target="_blank" href="<?php echo $general_site_content['googleplus_url']; ?>"><span class="rooms-icon-googleplus"></span></a>
                <?php } ?>
            </nav>  
            
            <?php 
            $form_id = 1;
            get_search_form(); 
            ?>               
            
            <div class="nav-wrapper clearfix">

                <nav id="main-navigation" class="clearfix">
                    <?php
                    $locations = get_nav_menu_locations();
                    $menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                    foreach ( (array) $menu_items as $key => $menu_item ) {

                      $class_to_add = ( $current_page_cat_id == $menu_item->object_id && !is_page() )?'active':'';
                      echo '<a href="'.$menu_item->url.'" class="'.$class_to_add.'">'.$menu_item->title.'</a>';  $class_to_add = '';
                    }
                    ?>   
                </nav>
                                     
            </div>            
    </div>
    </header>