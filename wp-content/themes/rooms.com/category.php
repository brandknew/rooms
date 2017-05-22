<?php get_header(); 

// get current category & its URL
$cat = get_query_var('cat');
$current_cat = get_category ($cat);
$current_cat_url = get_category_link( $current_cat->cat_ID );

// get URL tags
if($_GET['tag']){
$url_tags = $_GET['tag'];	
}
// assign to final tags variable after any processing 
$final_tags = $url_tags;
?>

<div id="main-content" class="main-content">

	<div class="container">
		<div class="columns-table div-table">
			<div class="left-column div-table-cell">

			<h1 class="main-heading clearfix">
				<span class="text"><?php echo $current_cat->name; ?></span>
				<span class="filters_wrapper" data-category-url="<?php echo $current_cat_url;?>">
			
						<?php 
						$tags_args = array('exclude' => '14,12' );
						$tags = get_tags( $tags_args );
						$html = '<span class="tag-list">';
						$html .= '<span class="label">Filter By<span class="arrow-right"></span></span>';
						foreach ( $tags as $tag ) {
							$tag_link = get_tag_link( $tag->term_id );
							$class_to_add = "";
							if ( strpos($final_tags, $tag->slug) !== false) {
								$class_to_add = 'active';
							}
								
							$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='".$class_to_add."' data-tag='{$tag->slug}'>{$tag->name}<span class='remove'>&nbsp;x</span></a>";
						}
						$html .= '</span>';
						echo $html;
						?>

				</span>
			</h1>


			<?php

				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$query = new WP_Query('category_name='.$current_cat->slug.'&paged='.$paged.'&tag='.$final_tags);

				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
					
					get_template_part('post_listing');

					endwhile;
				else : ?>
					<article class="post-listing clearfix">
						<p>Sorry! No posts match your criteria.</p>
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