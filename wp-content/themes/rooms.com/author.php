<?php 

get_header(); 
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

?>

<?php
/*
$args = array('tag' => 'featured', 'posts_per_page' => -1 );
$featured_posts = get_posts( $args );
if ( count($featured_posts) > 0 ) {
	include('featured_posts.php');
	include('featured_posts_slider.php');
} 
*/
?>

<div id="main-content" class="main-content">



	<div class="container">
		
		<?php
		// get author
		$author = get_queried_object();
		$authorid = $author->ID;

		// get author image & text
		$author_image = get_avatar( $author->ID );
		$author_title_company = get_field('title_company', 'user_'.$authorid);

		// if author profile image is not set, set default
		if( get_field('profile_picture', 'user_'.$authorid) != '' ){
			$author_profile_image = get_field('profile_picture', 'user_'.$authorid);
		} else {
			$author_profile_image = 'http://rooms.com/wp-content/uploads/2014/06/landing_bg.jpg';
		}

		// get this author data, to check against tidal contributors
		$data = apply_filters('get_author_data', $post);

		// get all contributors
		$tidal_users = new WP_Query( array('post_type' => 'tidal_contributor') );
		if ( $tidal_users->have_posts() ) :
			while ( $tidal_users->have_posts() ) :
				$tidal_users->the_post();
				// this author matches tidal user
				if( $data['author_name'] == get_the_title()){
					// see what images are availabe
					if (has_post_thumbnail($post->ID)) {
						// has featured image
						$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
						$url = $url[0];
					} elseif (get_post_meta($post->ID, 'profile_image', true)) {
						// has profile image
					   $url = get_post_meta($post->ID, 'profile_image', true); 
					} else {
						// no image, so set to tidal default image
					   $url = 'http://c581023.r23.cf2.rackcdn.com/anon.gif';
					}

					// set todal author image and text
					$author_image = '<img width="96" height="96" class="avatar avatar-96 wp-user-avatar wp-user-avatar-96 photo avatar-default" alt="" src="'.$url.'">';

					$author_title_company = get_post_meta($post->ID, 'profile_text', true);

				}

			endwhile;
		endif;
		wp_reset_query();
		wp_reset_postdata();

		?>
		<div style="display:none;">
			<?php
			echo 'author ID: '.$authorid.'<br>';
			echo 'author Meta ID: '.get_the_author_meta( 'ID' ).'<br>';
			var_dump($data); 
			?>
		</div>	
		<div id="author-profile">
			<div class="profile-header">
				<div class="author-image">
					<div class="author-image-wrapper">
						<?php echo $author_image ;?>
					</div>
				</div>
				<h1 class="author-name"><?php echo the_author_meta( 'display_name', $authorid ); ?></h1>
				<div class="profile-image" style="background-image:url(<?php echo $author_profile_image; ?>)">
				</div>
			</div>
			<div class="profile-bar">
				<?php echo $author_title_company; ?>
			</div>
			
			<?php // if ( current_user_can('manage_options') ) { ?>
			
			<div class="profile-columns clearfix">
				<div class="left">
					<h2 class="profile-heading">Contact</h2>
					<ul class="profile-left-list">
					<?php
					if( get_field('website_url', 'user_'.$authorid) != "" ){
						echo '<li><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="1000px" height="1000px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><path fill="#010101" d="M948.514,610.29L821.057,482.843c-34.305-34.306-75.966-51.469-124.987-51.469c-49.839,0-92.313,17.974-127.448,53.922l-53.922-53.922c35.95-35.129,53.922-77.812,53.922-128.064c0-49.021-16.951-90.477-50.859-124.388L391.536,52.088C357.631,17.368,315.966,0,266.54,0c-49.02,0-90.481,16.96-124.386,50.865l-90.073,89.458C17.358,174.238,0,215.693,0,264.709c0,49.022,17.161,90.694,51.469,125.004l127.449,127.448c34.316,34.312,75.981,51.469,125.001,51.469c49.832,0,92.316-17.973,127.445-53.925l53.922,53.925c-35.948,35.135-53.922,77.815-53.922,128.066c0,49.024,16.95,90.468,50.857,124.388l126.238,126.826c33.91,34.719,75.56,52.089,124.985,52.089c49.026,0,90.47-16.949,124.387-50.861l90.079-89.455c34.72-33.92,52.09-75.371,52.09-124.391C999.989,686.278,982.833,644.616,948.514,610.29z M431.373,348.056c-1.226-1.225-5.009-5.104-11.332-11.641c-6.326-6.537-10.719-10.928-13.168-13.177c-2.453-2.248-6.335-5.31-11.645-9.199c-5.318-3.883-10.521-6.533-15.624-7.964c-5.108-1.43-10.727-2.142-16.856-2.142c-16.334,0-30.227,5.722-41.666,17.154c-11.439,11.433-17.151,25.324-17.151,41.666c0,6.124,0.713,11.742,2.142,16.85c1.429,5.112,4.083,10.319,7.964,15.626c3.881,5.309,6.946,9.192,9.191,11.645c2.241,2.449,6.632,6.842,13.169,13.175c6.537,6.331,10.415,10.107,11.64,11.334c-12.256,12.658-26.962,18.989-44.114,18.989c-16.748,0-30.64-5.511-41.664-16.536l-127.46-127.454c-11.433-11.439-17.152-25.329-17.152-41.673c0-15.926,5.713-29.608,17.152-41.047l90.076-89.467c11.853-11.032,25.734-16.537,41.672-16.537c16.334,0,30.224,5.715,41.664,17.154l126.221,126.833c11.439,11.439,17.152,25.327,17.152,41.666C451.587,320.463,444.848,335.377,431.373,348.056z M865.21,776.334l-90.079,89.467c-11.443,10.614-25.324,15.931-41.674,15.931c-16.759,0-30.624-5.506-41.657-16.54L565.58,738.35c-11.441-11.443-17.148-25.324-17.148-41.656c0-17.158,6.734-32.065,20.219-44.729c1.234,1.216,5.009,5.109,11.341,11.633c6.331,6.536,10.722,10.929,13.177,13.176c2.454,2.258,6.329,5.318,11.632,9.203c5.319,3.886,10.517,6.544,15.628,7.969c5.112,1.432,10.725,2.145,16.849,2.145c16.353,0,30.232-5.72,41.676-17.156c11.427-11.434,17.157-25.326,17.157-41.656c0-6.127-0.729-11.744-2.146-16.852c-1.439-5.112-4.083-10.32-7.985-15.627c-3.886-5.305-6.931-9.196-9.188-11.65c-2.247-2.438-6.64-6.831-13.175-13.177c-6.537-6.33-10.414-10.106-11.648-11.324c12.265-13.074,26.967-19.611,44.111-19.611c16.347,0,30.228,5.713,41.656,17.157l127.455,127.443c11.443,11.441,17.158,25.339,17.158,41.672C882.348,751.226,876.633,764.924,865.21,776.334z"/></svg><a class="profile-url break-all" href="'.get_field('website_url', 'user_'.$authorid).'" target="_blank">'.get_field('website_url', 'user_'.$authorid).'</a></li>';
					}

					echo '<li><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><path d="M806.729,100H193.271C86.707,100,0,186.703,0,293.271V400v200v106.729C0,813.297,86.702,900,193.27,900h613.458c106.563,0,193.271-86.703,193.271-193.271V600V400V293.271C999.999,186.703,913.297,100,806.729,100z M902.561,706.729c0,52.883-42.947,95.829-95.828,95.829H193.27c-52.88,0-95.831-42.944-95.831-95.829l0-413.457c0-52.883,42.947-95.829,95.828-95.829h613.462c52.881,0,95.832,42.944,95.831,95.829L902.561,706.729z"/><path d="M845.812,202.858L567.615,481.056c-37.393,37.394-98.129,37.393-135.521,0L154.192,203.155L43.617,230.383l319.572,319.572c75.353,75.354,197.972,75.354,273.326,0l75.469-75.468l141.421-141.421l108.331-108.33L845.812,202.858z"/><rect x="192.781" y="424.77" transform="matrix(0.7071 0.7071 -0.7071 0.7071 519.2268 15.0053)" width="97.44" height="418.983"/><rect x="709.779" y="424.771" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 1743.3303 546.4171)" width="97.44" height="418.983"/></svg><a class="break-all" href="mailto:'.$author->user_email.'">'.$author->user_email.'</a></li>';

					if( get_field('phone', 'user_'.$authorid) != "" ){
						echo '<li><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><path fill="#010101" d="M704.23,1000c0,0,90.769,0,90.769-90.905V90.905C794.999,0,704.23,0,704.23,0h-408.46c0,0-90.77,0-90.77,90.905v818.189c0,90.905,90.77,90.905,90.77,90.905H704.23z M500,962.148c-25.051,0-45.384-20.333-45.384-45.383c0-25.053,20.333-45.385,45.384-45.385c25.052,0,45.386,20.333,45.386,45.385C545.386,941.816,525.053,962.148,500,962.148z M386.539,55.415c0-5.628,4.494-10.031,10.03-10.031h206.818c5.536,0,10.075,4.494,10.075,10.031v2.677c0,5.673-4.494,10.031-10.029,10.031H396.569c-5.49,0-10.03-4.494-10.03-10.031V55.415z M250.387,113.46h499.229v726.15H250.387V113.46z"/></svg><a class="profile-url" href="tel:'.get_field('phone', 'user_'.$authorid).'" target="_blank">'.get_field('phone', 'user_'.$authorid).'</a></li>';
					}
					?>
					</ul>

					<h2 class="profile-heading">Follow</h2>
					<ul class="profile-left-list">
					<?php 

					if( get_field('facebook_profile', 'user_'.$authorid) != "" ){
						echo '<li><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><path d="M714.172,500.366H574.035c0,223.999,0,499.634,0,499.634H366.394c0,0,0-272.949,0-499.634h-98.755V323.853h98.755V209.595C366.394,127.93,405.212,0,575.928,0l153.809,0.61v171.387c0,0-93.506,0-111.633,0c-18.189,0-44.068,9.155-44.068,48.096v103.76h158.326L714.172,500.366z"/></svg><a href="'.get_field('facebook_profile', 'user_'.$authorid).'" target="_blank">Facebook</a></li>';
					}

					if( get_field('twitter_profile', 'user_'.$authorid) != "" ){
						echo '<li><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><path d="M1000,188.125c-36.817,16.408-76.348,27.479-117.853,32.482c42.384-25.528,74.903-65.958,90.234-114.142c-39.668,23.633-83.554,40.821-130.292,50.057c-37.423-40.097-90.762-65.135-149.746-65.135c-113.301,0-205.156,92.364-205.156,206.308c0,16.172,1.797,31.896,5.292,46.994c-170.488-8.594-321.718-90.724-422.871-215.548c-17.657,30.47-27.793,65.917-27.793,103.712c0,71.582,36.23,134.727,91.27,171.717c-33.614-1.053-65.254-10.331-92.931-25.78c-0.02,0.859-0.02,1.698-0.02,2.578c0,99.959,70.744,183.359,164.59,202.306c-17.207,4.707-35.332,7.245-54.063,7.245c-13.203,0-26.055-1.289-38.593-3.712c26.114,81.954,101.894,141.623,191.661,143.263c-70.234,55.353-158.673,88.341-254.805,88.341	c-16.543,0-32.872-0.996-48.926-2.91c90.781,58.556,198.594,92.714,314.492,92.714c377.363,0,583.73-314.374,583.73-587.012	c0-8.924-0.195-17.833-0.587-26.699C937.715,265.841,972.481,229.513,1000,188.125z"/></svg><a href="'.get_field('twitter_profile', 'user_'.$authorid).'" target="_blank">Twitter</a></li>';
					}

					if( get_field('instagram_profile', 'user_'.$authorid) != "" ){
						echo '<li><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><path d="M806.728,0H193.27C86.702,0,0,86.674,0,193.243v204.123v409.362C0,913.297,86.702,1000,193.27,1000h613.458c106.564,0,193.271-86.703,193.271-193.272V397.363H1000V193.243C1000,86.672,913.297,0,806.728,0z M862.194,115.268l22.104-0.086v22.02v147.477l-168.98,0.546l-0.575-169.499L862.194,115.268z M357.315,397.363c31.98-44.327,83.944-73.381,142.684-73.381c58.74,0,110.703,29.057,142.683,73.381c20.902,28.939,33.361,64.308,33.361,102.635c0,97.036-79.009,175.987-176.044,175.987c-97.036,0-175.989-78.951-175.987-175.987C324.011,461.673,336.471,426.302,357.315,397.363z M902.56,806.728c0,52.883-42.947,95.83-95.828,95.83H193.27c-52.88,0-95.831-42.945-95.831-95.83V397.363h149.286c-12.917,31.725-20.154,66.346-20.154,102.635c0,150.78,122.647,273.427,273.427,273.427c150.78,0,273.427-122.647,273.427-273.427c0-36.29-7.293-70.91-20.152-102.635H902.56V806.728z"/></svg><a href="'.get_field('instagram_profile', 'user_'.$authorid).'" target="_blank">Instagram</a></li>';
					}

					if( get_field('pinterest_profile', 'user_'.$authorid) != "" ){
						echo '<li><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><path d="M577.148,722.752c-62.012,0-120.361-33.569-140.32-71.656c0,0-33.387,132.325-40.406,157.96c-24.902,90.211-98.084,180.543-103.699,187.868c-3.967,5.248-12.756,3.539-13.672-3.175c-1.587-11.597-20.264-125.488,1.709-218.385c11.047-46.631,73.914-312.959,73.914-312.959s-18.372-36.621-18.372-90.821c0-85.206,49.377-148.682,110.84-148.682c52.246,0,77.394,39.185,77.394,86.182c0,52.612-33.387,131.104-50.66,203.858c-14.404,60.913,30.518,110.565,90.638,110.565c108.826,0,182.13-139.74,182.13-305.269c0-125.978-84.778-220.216-239.015-220.216c-174.195,0-282.778,130.006-282.778,275.148c0,50.049,14.771,85.328,37.903,112.672c10.62,12.573,12.085,17.578,8.24,31.982c-2.808,10.62-9.033,36.011-11.719,46.143c-3.784,14.526-15.625,19.653-28.748,14.282c-80.262-32.715-117.615-120.606-117.615-219.361C112.913,195.68,250.487,0,523.438,0c219.301,0,363.649,158.692,363.649,329.104C887.087,554.446,761.781,722.752,577.148,722.752z"/></svg><a href="'.get_field('pinterest_profile', 'user_'.$authorid).'" target="_blank">Pinterest</a></li>';
					}


					?>
					</ul>

				</div>
				<div class="right">

					<?php
					$gallery_items = get_field('profile_gallery', 'user_'.$authorid);
					if($gallery_items)
					{
						echo '<ul class="photo-gallery clearfix">';
						foreach($gallery_items as $item)
						{
							echo '<li><a class="fancybox" '.( ( $item['image_caption'] != "" )? 'title="'.$item['image_caption'].'"':'' ).' rel="author-gallery" href="'.$item['image'].'" style="background-image:url('.$item['image'].');"></a></li>';
						}
						echo '</ul>';
					}
					?>

					<!-- <h2 class="profile-heading">About</h2> -->
					<div class="single-post-content profile-content">
						<?php echo get_field('short_bio', 'user_'.$authorid); ?>
					</div>
				</div>
			</div>


			<?php // } ?>

		</div>

		<div class="columns-table div-table">
			<div class="left-column div-table-cell">
				<?php
				$data = apply_filters('get_author_data', $post);
				?>

			<h2 class="main-heading"><span class="heading-icon rooms-icon-latest"></span>Latest from <?php // echo $curauth->nickname; ?><?php echo $data['author_name']; ?></h2>
			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			/*
			$latest_args = array('cat' => -9, 'paged' => $paged );
			$latest_posts = get_posts( $latest_args );
			if ( count($latest_posts) > 0 ) {
				foreach ( $featured_posts as $post ) :
				setup_postdata( $post );
				endforeach;
			}



			
			$query = new WP_Query('cat=-9&posts_per_page=6&paged='.$paged);
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();			
			*/

			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				
				get_template_part('post_listing');

				endwhile;
			else :
				// NO CONTENT CODE
			endif;
			?>

			<?php // if(function_exists('wp_page_numbers')) : wp_page_numbers(); endif; ?>

			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>

<!-- #main-content END -->
</div>
<?php get_footer(); ?>