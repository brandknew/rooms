<?php 
global $template_url; 
$obj=new shareCount(get_permalink()); 
include('check_post_images.php');
$post_date = get_the_date();
?>
			<article class="post-listing clearfix">
				<div class="post-image">
					<?php /* ?><span class="post-category"><?php echo get_the_category_list( __( ', ', 'empty' ) );?></span><?php */ ?>
					<a href="<?php the_permalink();?>" class="post-image-link"><span class="post-image-hover"><span class="text">See More</span></span><img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo $imageSource ;?>&w=820&h=446&zc=1&q=50" alt=""></a>
				</div>
				<div class="post-content">
					<span class="category-links"><?php echo get_the_category_list( __( ', ', 'empty' ) );?></span>
					<span class="post-tags">
					<?php
					$posttags = get_the_tags();
					if ($posttags) {
					  foreach($posttags as $tag) {
					  	if ( $tag->slug !== 'featured' && $tag->slug !== 'recommended' ) {
					  		echo '<a href="'.get_tag_link( $tag->term_id ).'">'.$tag->name .'</a>'; 
					  	}
					  }
					}
					?>
					</span>
					<h2 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a> </h2>

					<!-- <div class="post-excerpt"><?php the_excerpt(); ?></div> -->
					<a href="<?php the_permalink();?>" class="full-story"><?php echo get_field('read_more_button_text', 'option');?></a>
				</div>

					<div class="post-info clearfix">


						<a class="post-author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
							<?php
							// default image
							$author_image = get_avatar( get_the_author_meta( 'ID' ) );
							$data = apply_filters('get_author_data', $post);

							$contributor_args = array(
								'post_type' => 'tidal_contributor',
								);
							$contributor_query = new WP_Query($contributor_args);

							if ( $contributor_query->have_posts() ) :
								while ( $contributor_query->have_posts() ) :
									$contributor_query->the_post();
									if (has_post_thumbnail($post->ID)) {
									   $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
									   $url = $url[0];
									} elseif (get_post_meta($post->ID, 'profile_image', true)) {
									   $url = get_post_meta($post->ID, 'profile_image', true); 
									} else {
									   $url = 'http://c581023.r23.cf2.rackcdn.com/anon.gif';
									}

									if ( $data['author_name'] == get_the_title() ){

										$author_image = '<img width="96" height="96" class="avatar avatar-96 wp-user-avatar wp-user-avatar-96 photo avatar-default" alt="" src="'.$url.'">';
									}
								endwhile;
							endif;
							// wp_reset_query();
							// wp_reset_postdata();

							?>




							<span class="image">
								<div class="thumbnail">
									<?php echo $author_image; ?>
								</div>
							</span>
							<span class="meta">

								<span class="date"><?php echo $post_date; ?></span>
								<span class="name"><?php echo $data['author_name']; ?></span>
							</span>

						</a>
							<div style="display:none;">
								<?php





								?>
							</div>

						<span class="post-shares"><strong><?php echo $obj->get_fb() ;?></strong> Shares</span>
					</div>

			</article>