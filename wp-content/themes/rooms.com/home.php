<?php 
/*
 * Template Name: Home Page
 */
get_header(); 
?>

<?php
$args = array('tag' => 'featured', 'posts_per_page' => -1 );
$featured_posts = get_posts( $args );
?>
<?php if ( count($featured_posts) > 0 ) { ?>

<?php // include('featured_posts.php');?>
<?php include('featured_posts_slider.php');?>

<?php } ?>

<div id="main-content" class="main-content">



	<div class="container">
		<div class="columns-table div-table">
			<div class="left-column div-table-cell">

			<h2 class="main-heading"><span class="heading-icon rooms-icon-latest"></span><?php echo get_field('latest_heading_text', 'option');?></h2>

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