	<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div class="container">

		<h1 class="main-heading">Error: 404!</h1>
		<h2 class="single-post-title">Page not found</h2>


		<div class="columns-table div-table">
			<div class="left-column div-table-cell">

				<article class="">
					<div class="single-post-content">
						
					<p>Sorry, but the page you're looking for cannot be found. Try returning to our <a href="<?php echo $site_url ;?>">Homepage</a> and starting over.</p>
					<p>You can also try searching for the page you want.</p>
					<?php 
					$form_id = 1;
					get_search_form(); 
					?> 						
					</div>
					
				</article>	

			<?php if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>

			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>

<!-- #main-content END -->
</div>
<?php get_footer(); ?>