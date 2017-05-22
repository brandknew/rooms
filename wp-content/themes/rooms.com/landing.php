<?php
/*
 * Template Name: Landing Page
 */

$template_url = get_bloginfo('template_url');
$site_url = get_bloginfo('url');

// GET GENERAL SITE CONTENT
$general_site_content  = array(
	'landing_text' => get_field('landing_text', 'option'),
	'landing_background_image' => get_field('landing_background_image', 'option')
);

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
	    <link rel="icon" href="<?php echo $template_url;?>/images/favicon.ico" type="image/x-icon">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="keywords" content="Keywords Here" >

		<meta property="og:title" content="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>"/>
		<meta property="og:type" content="blog"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
		<meta property="og:url" content="http://rooms.com/"/>
		<meta property="og:description" content="Be first in line for our open house"/>
		<meta property="og:image" content="<?php echo $general_site_content['landing_background_image']['url']; ?>"/>

	    <link href="<?php echo $template_url;?>/css/bootstrap_3.0.3/bootstrap.min.css" rel="stylesheet">
	    <link href="<?php echo $template_url;?>/css/styles.css" rel="stylesheet">
	    
	    <link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>		
	    <script src="http://code.jquery.com/jquery.js"></script>
	</head>
	<body class="landing-body" style="background:url(<?php echo $general_site_content['landing_background_image']['url']; ?>) top center; background-size:0 0;" data-width="<?php echo $general_site_content['landing_background_image']['width']; ?>" data-height="<?php echo $general_site_content['landing_background_image']['height']; ?>">

		<div class="landing-wrapper div-table">
			<div class="div-table-cell">
				
				<div class="landing-content">
					<span class="logo full-size">
						<span class="icon"><span class="rooms-icon-logo"></span></span>
						<span class="rooms-icon-rooms"></span>
					</span>
					<p class="text-teaser"><strong><?php echo $general_site_content['landing_text']; ?></strong></p>

	                <!-- Begin MailChimp Signup Form
	                <div id="mc_embed_signup">
	                <form action="http://rooms.us8.list-manage1.com/subscribe/post?u=4896729838572a5cedfe97a1a&amp;id=1518ad195a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate clearfix" target="_blank" novalidate>
	                
	                    <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter email address" required>
	                    
	                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_c11cb1716dbf058f68e440590_5cee6c3374" tabindex="-1" value=""></div>
	                    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
	                </form>
	                </div>
	                End mc_embed_signup--> 

	                <div class="mailchimp-ajax-wrapper clearfix">
	                	<?php echo yksemeProcessSnippet( "1518ad195a" , "Subscribe" ); ?>
	                </div>

				</div>

			</div>
		</div>
		

		<script src="<?php echo $template_url;?>/scripts/scripts.js"></script>
	</body>
</html>