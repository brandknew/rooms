<?php
		  // checks if the post has an image in the content or a featured thumbnail
		  $imageSource = '';
		  $imageWidth = '';
		  $imageHeight = '';

		  // IF POST HAS FEATURED IMAGE
		  if( has_post_thumbnail() ) { 

				$imageData = wp_get_attachment_image_src( get_post_thumbnail_id(),'full');
				$imageSource = $imageData[0];
				$imageWidth = $imageData[1];
		 		$imageHeight = $imageData[2];
		 		$featuredImage['full']['src'] = $imageData[0];
		 		$featuredImage['full']['width'] = $imageData[1];
		 		$featuredImage['full']['height'] = $imageData[2];

		 		$imageData = wp_get_attachment_image_src( get_post_thumbnail_id(),'large');
		 		$featuredImage['large']['src'] = $imageData[0];
		 		$featuredImage['large']['width'] = $imageData[1];
		 		$featuredImage['large']['height'] = $imageData[2];

		 		$imageData = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium');
		 		$featuredImage['medium']['src'] = $imageData[0];
		 		$featuredImage['medium']['width'] = $imageData[1];
		 		$featuredImage['medium']['height'] = $imageData[2];

		 		$imageData = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbnail');
		 		$featuredImage['thumbnail']['src'] = $imageData[0];
		 		$featuredImage['thumbnail']['width'] = $imageData[1];
		 		$featuredImage['thumbnail']['height'] = $imageData[2];

		  // ELSE, GET POST FIRST IMAGE
		  } else {

				$content = $post->post_content;
				$searchimages = '~<img [^>]* />~';
				preg_match_all( $searchimages, $content, $pics );
				$iNumberOfPics = count($pics[0]); // Check to see if we have at least 1 image

				// If your post has one or more images in the content, use the catch_that_image() function to get the first image's SRC
				if ( $iNumberOfPics > 0 ) {  
				  $imageSource = catch_that_image();
				  
				  // get all sizes for the post's first image
				  $currentPostId = get_the_ID();
				  // use the get_image_id_by_link() function to get the first image's ID
				  $currentImageId = get_image_id_by_link( $imageSource );
				  
				  // use the ID to get all the SRC for all sizes
				  $imageSourceThumbnailArray = wp_get_attachment_image_src( $currentImageId, 'thumbnail');
				  $imageSourceThumbnail = $imageSourceThumbnailArray[0];
				  $imageSourceMediumArray = wp_get_attachment_image_src( $currentImageId, 'medium');
				  $imageSourceMedium = $imageSourceMediumArray[0];
				  $imageSourceLargeArray = wp_get_attachment_image_src( $currentImageId, 'large');
				  $imageSourceLarge = $imageSourceLargeArray[0];
				  $imageSourceFullArray = wp_get_attachment_image_src( $currentImageId, 'full');
				  $imageSourceFull = $imageSourceFullArray[0];
				  
				  if($imageSourceFullArray[1]>$imageSourceFullArray[2] || $imageSourceFullArray[1]==$imageSourceFullArray[2] ){
						//$imageSourceOrientation ='h';
				  } else {
						//$imageSourceOrientation = 'v';
				  }
				  
				  // if id wasnt retrieved succesfully, the image is external. Set all variables to external image.
				  if(!$currentImageId){
					  $imageSourceThumbnail = $imageSource;
					  $imageSourceMedium = $imageSource;
					  $imageSourceLarge = $imageSource;
					  $imageSourceFull = $imageSource;
				  }
				}

		  }





		  

?>