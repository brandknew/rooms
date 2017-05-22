<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div class="container">

		<h1 class="main-heading"><?php echo get_the_category_list( __( ', ', 'empty' ) );?></h1>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					
		<h2 class="single-post-title"><?php the_title();?></h2>
		<div class="columns-table div-table">
			<div class="left-column div-table-cell">
					<article class="clearfix">
							<div class="post-info">
								<a class="post-author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
									<span class="image"><?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?></span>
									<span class="meta">
										<span class="date"><?php the_time('M j Y') ?></span>
										<span class="name"><?php the_author_meta( 'display_name' ); ?></span>
									</span>
								</a>
                                <nav id="social-share">
                                    <a target="_blank" href="#" class="facebook"><span class="rooms-icon-facebook"></span></a>
                                    <a target="_blank" href="#" class="twitter"><span class="rooms-icon-twitter"></span></a>
                                    <a target="_blank" href="#" class="pinterest"><span class="rooms-icon-pinterest"></span></a>
                                </nav>
                                <span class="post-shares"><strong>00</strong> Shares</span>


							</div>
							<div class="single-post-content">

								<?php if (wp_attachment_is_image($post->id)) {
								$att_image = wp_get_attachment_image_src( $post->id, "full");
								?>
								<p class="attachment">
									<a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>">
									<img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" />
									</a>
								</p>
								<?php } ?>

								<br>

								<?php disqus_embed('roomsdotcom'); ?>
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