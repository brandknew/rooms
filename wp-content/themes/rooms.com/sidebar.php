<?php
global $template_url;
global $site_banners;
?>
<div class="right-column div-table-cell">
	
	<?php /* if ( $site_banners['top-medium-rectangle']['ad_image'] != '' ) { ?>
	<div class="sidebar-ad-content">
	    <a href="<?php echo $site_banners['top-medium-rectangle']['ad_link'] ;?>" target="_blank"><img  src="<?php echo $site_banners['top-medium-rectangle']['ad_image'] ;?>" /></a>
	</div>
	<?php } */ ?>

	<section id="trending">
		<h2 class="section-heading"><span class="heading-icon rooms-icon-trending"></span>Trending</h2>
		<?php wpp_get_mostpopular( 'limit=4&range="all"&post_type=post&stats_category=1&thumbnail_width=768&thumbnail_height=234&wpp_start="<ul class=\'image-post-list\'>"&wpp_end="</ul>"&post_html="<li class=\'clearfix\'><div class=\'image clearfix\'>{thumb}</div><span class=\'category-links\'>{category}</span><h3 class=\'title\'>{title}</h3></li>"' ); ?>
	</section>

	<?php
	$args = array('tag' => 'recommended', 'posts_per_page' => 5 );
	$recommended_posts = get_posts( $args );
	$post_index = 1;
	if ( count($recommended_posts) > 0 ) { ?>
	<section id="recommended">
		<h2 class="section-heading"><span class="heading-icon rooms-icon-recommended"></span>Recommended</h2>
		<ul class="numbered-post-list">
		<?php 
		foreach ( $recommended_posts as $post ) :
		setup_postdata( $post );
		include('check_post_images.php');
		?>
		<li>
			<a href="<?php the_permalink() ;?>">
				<span class="number"><?php echo $post_index; ?>.</span>
				<?php the_title() ;?> <span class="arrow">>></span>
			</a>
		</li>
		<?php
		$post_index ++;	
		endforeach; 
		?>
		</ul>
	</section>
	<?php } ?>

	<?php /* if ( $site_banners['bottom-medium-rectangle']['ad_image'] != '' ) { ?>
	<div class="sidebar-ad-content">
	    <a href="<?php echo $site_banners['bottom-medium-rectangle']['ad_link'] ;?>" target="_blank"><img  src="<?php echo $site_banners['bottom-medium-rectangle']['ad_image'] ;?>" /></a>
	</div>
	<?php } */ ?>


	
	<!-- <div class=\'views\'>Views: {views}</div> -->
	

</div>