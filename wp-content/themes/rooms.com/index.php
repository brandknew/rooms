<?php get_header(); ?>

<div id="main-content" class="main-content">

	<?php
	$args = array('tag' => 'featured', 'posts_per_page' => -1 );
	$featured_posts = get_posts( $args );
	?>
	<?php if ( count($featured_posts) > 0 ) { ?>

	<div id="featured" class="container">
		<h1 class="featured-heading">FEATURED STORIES</h1>
		<ul class="featured-posts clearfix">
		<?php 
		foreach ( $featured_posts as $post ) :
		setup_postdata( $post );
		include('check_post_images.php');
		?>
		<li>
			<a href="<?php the_permalink() ;?>">
				<span class="featured-post-content"><?php the_title() ;?></span>
				<!-- for 4 up, images should be 285x340 / for 3 up images should be 380x340 -->
				<img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo $imageSource ;?>&w=285&h=340&zc=1&q=50" alt="">			
			</a>
		</li>
		<?php 		
		endforeach; 
		?>
		</ul>	
	</div>

	<?php } ?>

	<div class="container">
		<div class="columns-table div-table">
			<div class="left-column div-table-cell">

			<h2 class="main-heading"><span class="heading-icon rooms-icon-latest"></span>Latest from Rooms</h2>

			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			/*
			$latest_args = array('cat' => -9, 'paged' => $paged );
			$latest_posts = get_posts( $latest_args );
			if ( count($latest_posts) > 0 ) {
				foreach ( $featured_posts as $post ) :
				setup_postdata( $post );
				endforeach;
			}
			*/
			
			$query = new WP_Query('cat=-9&posts_per_page=6&paged='.$paged);
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
				
				get_template_part('post_listing');

				endwhile;
			else :
				// NO CONTENT CODE
			endif;
			?>

			<?php // if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>

			</div>
			<?php get_sidebar(); ?>
		</div>
		
	</div>

<!-- #main-content END -->
</div>
<?php get_footer(); ?>