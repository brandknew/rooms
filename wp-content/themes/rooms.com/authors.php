<?php
/*
Template Name: Authors
*/
 get_header(); ?>

<div id="main-content" class="main-content">

	<div class="container">		

		<div class="columns-table div-table">
			<div class="left-column div-table-cell">

			<h1 class="main-heading"><?php the_title();?></h1>

			<?php
			/*
			$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name");
			
				echo '<ul id="authors-list">';
				foreach($authors as $author) {
					echo '<li>';
					echo '<a href="'.get_bloginfo('url').'/author/'.$author->user_nicename.'">';
					echo '<span class="author-thumb">';
					echo get_avatar($author->ID);
					echo '</span>';
					echo '<span class="author-name">';
					the_author_meta('display_name', $author->ID);
					echo '</span>';
					echo '<span class="author-posts">';
					echo count_user_posts($author->ID);
					echo ' posts </span>';
					echo '</a>';
					echo '</li>';
				}
				echo '</ul>';
				*/



				$user_query = new WP_User_Query(  array( 'role' => '' ) );

				echo '<ul id="authors-list">';
				foreach ( $user_query->results as $author ) {
					if( $author->find_pros ){
						echo '<li data-test="'.$author->find_pros.'">';
						echo '<a href="'.get_bloginfo('url').'/author/'.$author->user_nicename.'">';
						echo '<span class="author-thumb">';
						echo get_avatar($author->ID);
						echo '</span>';
						echo '<span class="author-name">';
						echo $author->display_name;
						echo '</span>';
						echo '<span class="author-posts">';
						echo count_user_posts($author->ID);
						echo ' posts </span>';
						echo '</a>';
						echo '</li>';
					}

				}
				echo '</ul>';





			?> 
			</div>
		</div>		

	</div>

<!-- #main-content END -->
</div>
<?php get_footer(); ?>