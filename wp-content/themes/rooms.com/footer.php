<?php
global $template_url;
global $site_url;
?>
	<div class="container">
		<footer id="footer">
			<div class="row">
				<!-- 
				<div class="col-sm-3 left">
					<a href="<?php echo $site_url; ?>" class="logo">
						<span class="icon"><span class="rooms-icon-logo"></span></span>
						<span class="rooms-icon-rooms"></span>
					</a>
				</div>
				-->
				<div class="col-sm-6 col-md-5 center">
				    <nav id="footer-navigation" class="clearfix">
				        <?php
				        $locations = get_nav_menu_locations();
				        $menu = wp_get_nav_menu_object( $locations[ 'secondary' ] );
				        $menu_items = wp_get_nav_menu_items($menu->term_id);
				        foreach ( (array) $menu_items as $key => $menu_item ) {
				          $class_to_add = ( $current_page_id == $menu_item->object_id )?'active':'';
				          echo '<a href="'.$menu_item->url.'" class="'.$class_to_add.'">'.$menu_item->title.'</a>';  
				        }
				        ?>   
				    </nav>
				</div>
				<div class="col-md-4 col-md-offset-3 col-sm-5 col-sm-offset-1 right">
                <!-- Begin MailChimp Signup Form
                <div id="mc_embed_signup">
                <form action="http://rooms.us8.list-manage1.com/subscribe/post?u=4896729838572a5cedfe97a1a&amp;id=1518ad195a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate clearfix" target="_blank" novalidate>
                	<label>Subscribe to Our Newsletter</label>
                    <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter email address" required>
                    
                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_c11cb1716dbf058f68e440590_5cee6c3374" tabindex="-1" value=""></div>
                    <div class="clear"><input type="submit" value="Submit" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                </form>
                </div>
                End mc_embed_signup--> 
				
				<div class="mailchimp-ajax-wrapper clearfix">
					<label>Subscribe to Our Newsletter</label>
					<?php
					// echo yksemeProcessSnippet( "1" , "Submit" ); 
					echo do_shortcode('[yikes-mailchimp form="1"]');
					?>
				</div>
                

				</div>
			</div>
			<div class="copyright">&copy; <?php echo date('Y');?>, <?php bloginfo('name'); ?></div>
		</footer>
	</div>

    <!-- INCLUDE SCRIPTS -->
    <script>var templateUrl = '<?php echo $template_url;?>/';</script>
    <script src="<?php echo $template_url;?>/scripts/jquery-1.11.3.min.js"></script>
    <?php echo(  is_home() || is_single() || is_search() || is_page('home') || is_author() )? '<script src="'.$template_url.'/scripts/jquery.bxslider.min.js"></script>':'' ;?>
    <?php // echo(  is_home() || is_single() || is_search() || is_page('home') || is_author()  )? '<script src="'.$template_url.'/scripts/swipe.js"></script>':'' ;?>

    <script src="<?php echo $template_url;?>/scripts/jquery.fancybox.js"></script>

    <script src="<?php echo $template_url;?>/scripts/scripts.js"></script>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    
    <?php wp_footer(); ?>


	<!-- GOOGLE ANALYTICS -->
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-52000403-1', 'rooms.com');
	ga('send', 'pageview');
	</script>
	
	<!-- FACEBOOK RETARGETING PIXEL -->
	<script>(function() {
	  var _fbq = window._fbq || (window._fbq = []);
	  if (!_fbq.loaded) {
	    var fbds = document.createElement('script');
	    fbds.async = true;
	    fbds.src = '//connect.facebook.net/en_US/fbds.js';
	    var s = document.getElementsByTagName('script')[0];
	    s.parentNode.insertBefore(fbds, s);
	    _fbq.loaded = true;
	  }
	  _fbq.push(['addPixelId', '517376985058734']);
	})();
	window._fbq = window._fbq || [];
	window._fbq.push(['track', 'PixelInitialized', {}]);
	</script>
	<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=517376985058734&amp;ev=NoScript" /></noscript>
	
	</div> <!-- #body-wrapper END -->

	<script type="text/javascript">
	  /*
	  // CODE USED BEFORE INSTALLING TABOOLA WIDGET PLUGIN
	  window._taboola = window._taboola || [];
	  _taboola.push({flush: true});
	  */
	</script>

</body>
</html>