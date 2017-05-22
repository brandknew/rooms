	<div id="featured" class="">
		<h1 class="featured-heading"><?php echo get_field('featured_posts_text', 'option');?></h1>
		<div id="main-slider">
		<ul class="bxslider featured-posts-slider clearfix">
		<?php 
		foreach ( $featured_posts as $post ) :
		setup_postdata( $post );
		include('check_post_images.php');
		?>
		<li>
			<a href="<?php the_permalink() ;?>">
				<span class="featured-post-content"><?php the_title() ;?></span>
				<?php if ( $detect->isMobile() ) { ?>
				<img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo $featuredImage['large']['src'] ;?>&w=480&h=450&zc=1&q=75" alt="">					
				<?php } else { ?>
				<img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo $imageSource ;?>&w=1500&h=582&zc=1&q=90" alt="">					
				<?php } ?>	
			</a>
		</li>
		<?php 		
		endforeach; 
		?>
		</ul>
		</div>
	</div>
