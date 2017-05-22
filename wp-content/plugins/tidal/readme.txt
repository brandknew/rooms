=== Tidal ===
Contributors: Tidal
Tags: blogger
Requires at least: 3.5
Tested up to: 3.8
Stable tag: 1.0
License: GPLv2 or later


== Description ==

Tidal is a unique platform that supercharges individuals online, bringing new tools and exposure to the most talented creators on the web by connecting them with top brands and publishers.

The Tidal Wordpress plugin enables publishers to securely push content from the Tidal platform onto Wordpress powered sites using the Wordpress XML-RPC web service.

Tidal generated content seamlessly integrates into Wordpress along side your already existing posts.

In order to use this plugin you must have a Tidal account. Please visit <a href='http://www.tid.al'> Tidal </a> to sign up.

== Installation ==

1. Upload tidal to /wp-content/plugins/ directory.

2. Activate the plugin through the Plugins menu in Wordpress.

3. (Optional) Enter custom structures for the Tidal contributors and Tidal-contributed posts endpoint in the Tidal Settings.

== Changelog ==

= 1.0-release =
Initial release to wordpress.org plugins.

== Usage Notes ==
The Tidal Wordpress plugin allows Tidal content to easily be incorporated into themes.

= Post Class =
Outermost HTML element for a post will have a 'tidal-post' class added for finer control in post styling.

= Filters =

The 'is_tidal_post' filter will identify if a post is a Tidal-contributed post. The Post ID must be passed as
a parameter.

The 'tidal_contributors' filter retrieves an array of all Tidal contributor post objects.

= Templates =

Contributor author pages uses the author.php template by default and can be overridden by supplying an author-tidal.php template file.

