	<div id="featured" class="container">
		<h1 class="featured-heading">FEATURED STORIES</h1>
		<ul class="featured-posts clearfix">
		<?php 
		foreach ( $featured_posts as $post ) :
		setup_postdata( $post );
		include('check_post_images.php');
		?>
		<li>
			<a href="<?php the_permalink() ;?>">
				<span class="featured-post-content"><?php the_title() ;?></span>
				<!-- for 4 up, images should be 285x340 / for 3 up images should be 380x340 -->
				<img src="<?php echo $template_url;?>/scripts/timthumb.php?src=<?php echo $imageSource ;?>&w=285&h=340&zc=1&q=50" alt="">			
			</a>
		</li>
		<?php 		
		endforeach; 
		?>
		</ul>	
	</div>
