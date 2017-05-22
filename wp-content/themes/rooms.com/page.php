<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div class="container">

		<h1 class="main-heading"><?php the_title();?></h1>
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					

		<div class="columns-table div-table">
			<div class="left-column div-table-cell">
					<article class="clearfix">

						<div class="single-post-content-wrapper">
							<div class="single-post-content"><?php the_content(); ?></div>
						</div>

							

					</article>

				<?php endwhile;
				else :
					// NO CONTENT CODE
				endif;
			?>

			<?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>

			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>

<!-- #main-content END -->
</div>
<?php get_footer(); ?>