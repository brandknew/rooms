<?php
/**
 * Tidal XML-RPC Web Service API Examples
 *
 * You can run this file as follows (tweak params for your own test endpoint):
 *
 * php -d display_errors=1 tidal_api_examples.php /www/wordpress http://wordpress.local/xmlrpc.php 1 'tidal_service' 'some_strong_password'
 *
 * Required command line arguments are:
 * 1. Path to WordPress home directory
 * 2. URL of the WordPress test XML-RPC endpoint
 * 3. Blog/Site ID of WordPress site to connect to.
 * 4. Username of the Tidal Service WordPress User (with Author Role)
 * 5. Password of the Tidal Service WordPress User
 */
$tidal_xml_rpc_lib = isset( $argv[1] ) ? $argv[1] . '/wp-includes/class-IXR.php' : NULL;
$tidal_endpoint = isset( $argv[2] ) ? $argv[2] : NULL;
$tidal_site = isset( $argv[3] ) ? $argv[3] : NULL;
$tidal_user = isset( $argv[4] ) ? $argv[4] : NULL;
$tidal_pass = isset( $argv[5] ) ? $argv[5] : NULL;

/**
 * Load the XML-RPC lib.
 */
if( file_exists( $tidal_xml_rpc_lib ) ) {
	require $tidal_xml_rpc_lib;
	$client = new IXR_Client( $tidal_endpoint );
	//$client->debug = true;
}
else {
	exit( "XML-RPC library does not exist at: $tidal_xml_rpc_lib\n" );
}

/**
 * From: http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
 */
function gen_uuid() {
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
					// 32 bits for "time_low"
					mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
					// 16 bits for "time_mid"
					mt_rand( 0, 0xffff ),
					// 16 bits for "time_hi_and_version",
					// four most significant bits holds version number 4
					mt_rand( 0, 0x0fff ) | 0x4000,
					// 16 bits, 8 bits for "clk_seq_hi_res",
					// 8 bits for "clk_seq_low",
					// two most significant bits holds zero and one for variant DCE1.1
					mt_rand( 0, 0x3fff ) | 0x8000,
					// 48 bits for "node"
					mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	);
}

/**
 * Create a Tidal Contributor
 */
$tidal_contributor_id = gen_uuid(); // Randomly generated GUID for this example run.

$content = array(
	'post_type' => 'tidal_contributor',
	'post_name' => $tidal_contributor_id, // Contributor slug (we are using a unique GUID here for example purposes; can be any unique string)
	'post_title' => 'Tidal User ' . mt_rand(), // Display name of Tidal Contributor (appending random #s for testing purposes only)
	'post_status' => 'publish',
	'custom_fields' => array(
		array(
			'key' => 'tidal_username',
			'value' => 'Tidal Username ' . mt_rand() // Username of Tidal Contributor in Tidal's systems (also needs to be unique in WordPress)
		)
	)
);

if( $client->query( 'wp.newPost', $tidal_site, $tidal_user, $tidal_pass, $content ) ) {
	$wp_contributor_id = $client->getResponse();
	echo "Tidal Contributor created. Post ID: {$wp_contributor_id}\n";
}
else {
	echo "Tidal Contributor creation failed: {$client->getErrorMessage()}\n";
}

/**
 * Get a Contributor ID by Tidal GUID
 */
if( $client->query( 'tidal.getPostID', $tidal_site, $tidal_user, $tidal_pass, $tidal_contributor_id ) ) {
	$wp_contributor_id = $client->getResponse();
	echo "Got Contributor ID: {$wp_contributor_id}\n";
}
else {
	echo "Failed to get Contributor ID: {$client->getErrorMessage()}\n";
}

/**
 * Create a Tidal Post
 */
$tidal_post_id = gen_uuid(); // Randomly generated GUID for this example run.

$content = array(
	'post_title' => 'Tidal Post ' . mt_rand(), // Tidal Post title.
	'post_status' => 'publish',
	'custom_fields' => array(
		array(
			'key' => 'tidal_id',
			'value' => $tidal_post_id // Tidal GUID (or any other unique identifier) of Post in Tidal's systems
		),
		array(
			'key' => 'tidal_contributor',
			'value' => $tidal_contributor_id // Slug (post_name field value) of Post's Contributor
		)
	)
);

if( $client->query( 'wp.newPost', $tidal_site, $tidal_user, $tidal_pass, $content ) ) {
	$wp_post_id = $client->getResponse();
	echo "Tidal Post created. Post ID: {$wp_post_id}\n";
}
else {
	echo "Tidal Post creation failed: {$client->getErrorMessage()}\n";
}

/**
 * Get a Tidal (WordPress) Post ID by Tidal-defined Unique ID
 */
if( $client->query( 'tidal.getPostID', $tidal_site, $tidal_user, $tidal_pass, $tidal_post_id ) ) {
	$wp_post_id = $client->getResponse();
	echo "Got Tidal Post ID: {$wp_post_id}\n";
}
else {
	echo "Failed to get Tidal Post ID: {$client->getErrorMessage()}\n";
}

/**
 * Get a Single Contributor
 */
if( $client->query( 'wp.getPost', $tidal_site, $tidal_user, $tidal_pass, $wp_contributor_id ) ) {
	$contributor = $client->getResponse();
	echo "Got Contributor: " . print_r( $contributor, true ) . "\n";
}
else {
	echo "Failed to get Contributor: {$client->getErrorMessage()}\n";
}

/**
 * Get a Single Tidal Post
 */
if( $client->query( 'wp.getPost', $tidal_site, $tidal_user, $tidal_pass, $wp_post_id ) ) {
	$tidal_post = $client->getResponse();
	echo "Got Tidal Post: " . print_r( $tidal_post, true ) . "\n";
}
else {
	echo "Failed to get Tidal Post: {$client->getErrorMessage()}\n";
}

/**
 * Get Multiple Contributors
 */
$filter = array(
	'post_type' => 'tidal_contributor'
);

if( $client->query( 'wp.getPosts', $tidal_site, $tidal_user, $tidal_pass, $filter ) ) {
	$tidal_contributors = $client->getResponse();
	echo "Got Tidal Contributors: " . print_r( $tidal_contributors, true ) . "\n";
}
else {
	echo "Failed to get Tidal Contributors: {$client->getErrorMessage()}\n";
}

/**
 * Get Multiple Tidal Posts
 */
$filter = array(
	'post_type' => 'post'
);

if( $client->query( 'wp.getPosts', $tidal_site, $tidal_user, $tidal_pass, $filter ) ) {
	$all_posts = $client->getResponse();
	
	$tidal_posts = array();

	foreach( $all_posts as $post ) {
		if( count( $post['terms'] ) ) {
			$terms = $post['terms'];

			foreach( $terms as $term ) {
				if( $term['taxonomy'] == 'tidal' ) {
					// Post has a Tidal taxonomy term/relationship, this means this is
					// a Tidal Post object (vs. a standard WordPress Post).
					$tidal_posts[] = $post;
					break;
				}
			}
		}
	}

	echo "Got Tidal Posts: " . print_r( $tidal_posts, true ) . "\n";
}
else {
	echo "Failed to get Tidal Posts: {$client->getErrorMessage()}\n";
}
