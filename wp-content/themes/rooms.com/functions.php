<?php


// ADD MENU SUPPORT
register_nav_menus( array(
    'primary'   => __( 'Menu 1' ),
    'secondary'   => __( 'Menu 2' )
) );


if ( function_exists('register_sidebar') )
register_sidebar( array(
    'name'         => __( 'Widgets Bar' ),
    'id'           => 'sidebar-1',
    'description'  => __( 'Widgets in this area will be shown on the right-hand side.' ),
    'before_title' => '<h1>',
    'after_title'  => '</h1>',
) );


// ADD FEATURED IMAGE SUPPORT
add_theme_support( 'post-thumbnails' );

// ALLOW SVG IMAGE SUPPORT, REMOVE PNG
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
  unset($mimes['png']); //Removing the png extension
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );


// GET THE FIRST IMAGE IN POST - USAGE: echo catch_that_image() 
function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "/images/default.jpg";
  }
  return $first_img;
}

// GET THE WORDPRESS POST ATTACHMENT ID FROM AN IMAGE SRC
function get_image_id_by_link($link)
{
global $wpdb;

$link = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $link);

return $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE guid='$link'");
}


// RETURNS A CUSTOM EXCERPT, WITH OR WITHOUT A LINK
function excerpt($content, $num,$moreLink=false) {
	$limit = $num+1;
	$excerpt = explode(' ', $content, $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt)."... ";
	echo $excerpt;
	if($moreLink){
		echo '  <a href="'. get_permalink($post->ID) . '">' . 'Lee Más &raquo;' . '</a>';
	}
}


// CUSTOMIZE THE EXCERPT [...] 
function new_excerpt_more( $more ) {
	return ' | <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More&nbsp;&raquo;', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


// CUSTOM LENGTH EXCERPT - USAGE: echo the_excerpt_max_charlength(200);
function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo ' | <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More&nbsp;&raquo;', 'your-text-domain') . '</a>';
	} else {
		echo $excerpt;
	}
}



// MAKE POST CAPTIONS RESPONSIVE
add_filter( 'img_caption_shortcode', 'bs_responsive_img_caption_filter', 10, 3 );
function bs_responsive_img_caption_filter( $val, $attr, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'align' => '',
		'width' => '',
		'caption' => ''
		), $attr
	) );

	if ( 1 > (int) $width || empty( $caption ) )
		return $val;

	$new_caption = sprintf( '<div id="%1$s" class="wp-caption %2$s" style="max-width:100%%;height:auto;width:auto;">%4$s<p class="wp-caption-text">%5$s</p></div>',
		esc_attr( $id ),
		esc_attr( $align ),
		'', //( 10 + (int) $width ),
		do_shortcode( $content ),
		$caption
	);
	return $new_caption;
}



// EXCLUDE 'uncategorized' FROM SEARCH RESULTS and ARCHIVE
add_filter( 'pre_get_posts', 'filterOutUncategorized' );
function filterOutUncategorized( $query ) {
	if ( $query->is_search || $query->is_archive )
		$query->set( 'cat','-1' );
	return $query;
}







function disqus_embed($disqus_shortname) {
    global $post;
    wp_enqueue_script('disqus_embed','http://'.$disqus_shortname.'.disqus.com/embed.js');
    echo '<div id="disqus_thread"></div>
    <script type="text/javascript">
        var disqus_shortname = "'.$disqus_shortname.'";
        var disqus_title = "'.$post->post_title.'";
        var disqus_url = "'.get_permalink($post->ID).'";
        var disqus_identifier = "'.$disqus_shortname.'-'.$post->ID.'";
    </script>';
}


// CUSTOM POST TYPES

// Ad Units custom type
add_action( 'init', 'create_ad_units' );
function create_ad_units() {
  $labels = array(
    'name' => _x('Ad Units', 'post type general name'),
    'singular_name' => _x('Ad Unit', 'post type singular name'),
    'add_new' => _x('Add New', 'Ad Unit'),
    'add_new_item' => __('Add New Ad Unit'),
    'edit_item' => __('Edit Ad Unit'),
    'new_item' => __('New Ad Unit'),
    'view_item' => __('View Ad Unit'),
    'search_items' => __('Search Ad Units'),
    'not_found' =>  __('No Ad Units found'),
    'not_found_in_trash' => __('No Ad Units found in Trash'),
    'parent_item_colon' => ''
  );
  $supports = array('title', 'editor', 'revisions', 'thumbnail');
  register_post_type( 'Ad Units',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports
    )
  );
}



function feedFilter($query) {
  if ($query->is_feed) {
    $query->set('posts_per_page','20');
  }
 
  return $query;
}
add_filter('pre_get_posts','feedFilter');


?>