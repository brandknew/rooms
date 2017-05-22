<div id="sliders" class="">

	<?php
	$args = array('tag' => 'featured', 'posts_per_page' => -1 );
	$featured_posts = get_posts( $args );
	?>
	<?php if ( count($featured_posts) > 0 ) { ?>
	<div id="main-slider">
		<ul class="bxslider slides-container">
		<?php 
		foreach ( $featured_posts as $post ) :
		setup_postdata( $post );
		include('check_post_images.php');
		?>
		<li>
			<a href="<?php the_permalink() ;?>">
				<img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo $imageSource ;?>&w=1920&h=720&zc=1&q=50" alt="">
				<span class="slide-content"><?php the_title() ;?></span>
			</a>
		</li>
		<?php 		
		endforeach; 
		?>
		</ul>
	</div>
	<?php } ?>

    <?php if ( count($featured_posts) > 0 ) { ?>
	<div id="swipe-slider" class="swipe-slider">
		<ul class="swipe-slider-list clearfix">
		<?php 
		foreach ( $featured_posts as $post ) :
		setup_postdata( $post );
		include('check_post_images.php');
		?>
			<li>
				<a href="#">
					<img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo $imageSource ;?>&w=768&h=480&zc=1&q=50" alt="">
					<span class="slide-content"><?php the_title() ;?></span>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>  
	</div>
	<?php } ?>		

</div>