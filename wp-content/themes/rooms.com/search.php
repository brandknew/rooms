<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div class="container">
		<div class="columns-table div-table">
			<div class="left-column div-table-cell">

			<h1 class="main-heading"><?php printf( __( 'Search Results: %s', 'twentytwelve' ), '<strong>' . get_search_query() . '</strong>' ); ?></h1>

			<?php
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					
					get_template_part('post_listing');

					endwhile;
				else : ?>
				<article class="">
					<div class="single-post-content">
						<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
					<?php 
					$form_id = 1;
					get_search_form(); 
					?>
					</div> 
				</article>	
				<?php endif;
			?>

			<?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>

			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>

<!-- #main-content END -->
</div>
<?php get_footer(); ?>