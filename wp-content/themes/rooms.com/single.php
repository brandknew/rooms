<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div class="container">

		<h1 class="main-heading"><?php echo get_the_category_list( __( ', ', 'empty' ) );?></h1>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		$obj=new shareCount(get_permalink()); 
		include('check_post_images.php');
		?>
					
		<h2 class="single-post-title"><?php the_title();?></h2>
		<div class="columns-table div-table">
			<div class="left-column div-table-cell">
					<article class="clearfix">
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
								wp_reset_query();

								?>
								<span class="image"><?php echo $author_image; ?></span>
								<span class="meta">
									<?php
									$data = apply_filters('get_author_data', $post);
									?>
									<span class="date"><?php the_time('M j Y') ?></span>
									<span class="name"><?php echo $data['author_name']; ?></span>
								</span>
							</a>

                            <nav id="social-share">
                                <a target="_blank" href="#" class="facebook post-to-facebook" data-picture="<?php echo $imageSource ;?>" data-linkname="<?php the_title();?>" data-linkurl="<?php the_permalink();?>" data-description="<?php echo strip_tags(excerpt( get_the_excerpt(),30,false) );?>"><span class="rooms-icon-facebook"></span></a>
                                <a target="_blank" href="" class="twitter tweet" data-url="<?php the_permalink();?>" data-text="<?php the_title();?>"><span class="rooms-icon-twitter"></span></a>
                                <!--
                                <a href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());" class="pinterest"><span class="rooms-icon-pinterest"></span></a>
                            	-->
                            </nav>

                            <span class="post-shares"><strong><?php echo $obj->get_fb() ;?></strong> Shares</span>

						</div>
						<div class="single-post-content-wrapper">


							<?php if( have_rows('slideshow') ) { ?>
							<div id="main-slider">
								<ul class="bxslider single-slider slides-container">
									<?php while ( have_rows('slideshow') ) : the_row(); ?>
									<li>
		                            <?php if ( get_sub_field('slide_image') != '' ) { ?>
			                            <img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo get_sub_field('slide_image') ;?>&w=800&h=500&zc=1&q=50" />
		                            <?php } ?>
		                            <?php if ( get_sub_field('slide_caption') != '' ) { ?>
			                            <div class="slide-caption"><?php echo get_sub_field('slide_caption') ;?></div>
		                            <?php } ?>			                            
									</li>
									<?php endwhile; ?>
								</ul>
							</div>
							<?php } ?>



							<?php if( have_rows('slideshow') ) { ?>
							<div id="swipe-slider" class="swipe-slider">
								<ul class="swipe-slider-list clearfix">
									<?php while ( have_rows('slideshow') ) : the_row(); ?>
									<li>
		                            <?php if ( get_sub_field('slide_image') != '' ) { ?>
			                            <img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo get_sub_field('slide_image') ;?>&w=800&h=500&zc=1&q=50" />
		                            <?php } ?>
		                            <?php if ( get_sub_field('slide_caption') != '' ) { ?>
			                            <span class="slide-content"><?php echo get_sub_field('slide_caption') ;?></span>
		                            <?php } ?>			                            
									</li>
									<?php endwhile; ?>
								</ul>
							</div>
							<?php } ?>


							
							<?php
							// load pinterest embed if it exists
							if ( get_field('pinterest_board') != '' ) { ?>
							<div class="pinterest-embed">
								<a data-pin-do="embedBoard" href="<?php echo get_field('pinterest_board'); ?>"> Follow Pinterest Pin pets on Pinterest </a>
							</div>
							<script type="text/javascript">(function(d){  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');  p.type = 'text/javascript';  p.async = true;  p.src = '//assets.pinterest.com/js/pinit.js';  f.parentNode.insertBefore(p, f);}(document));</script>
							<?php } ?>

							<div class="single-post-content">
								<div class="content">
									<?php the_content(); ?>
								</div>
								<br>

								<?php if ( dynamic_sidebar('Widgets Bar') ) : else : endif; ?>

								<!--
								// CODE USED BEFORE INSTALLING TABOOLA WIDGET PLUGIN
								 <div id="taboola">
									<div id="taboola-below-article-thumbnails"></div>
									<script type="text/javascript">
									  window._taboola = window._taboola || [];
									  _taboola.push({
									    mode: 'thumbs-a',
									    container: 'taboola-below-article-thumbnails',
									    placement: 'Below Article Thumbnails',
									    target_type: 'mix'
									  });
									</script>
								</div>
								-->

								<?php disqus_embed('roomsdotcom'); ?>
							</div>
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