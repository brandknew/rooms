<?php get_header(); 

// get current tag
$queried_object = get_queried_object();
$tag = $queried_object->slug;
?>

<div id="main-content" class="main-content">

	<div class="container">
		<div class="columns-table div-table">
			<div class="left-column div-table-cell">

			<h1 class="main-heading clearfix">
				<span class="text">TAG: <?php echo single_tag_title( '', false ); ?></span>
			</h1>

			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$query = new WP_Query('tag='.$tag.'&posts_per_page=10&paged='.$paged);

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
					
					get_template_part('post_listing');

					endwhile;
				else : ?>
					<article class="post-listing clearfix">
						<p>Sorry! No posts match your criteria.</p>
					</article>
					
				<?php endif;
			?>

			<?php  if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>

			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>

<!-- #main-content END -->
</div>
<?php get_footer(); ?>