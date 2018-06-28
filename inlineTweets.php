<?php 
/*
Plugin Name: InlineTweets
Description: InlineTweets allows you to easily create tweetable links out of any text on a webpage.
Plugin URI: http://ireade.github.io/inlinetweetjs/
Version: 1.0
Author: Ire Aderinokun & Emma Kalson
Author URI: http://ireade.github.io/inlinetweetjs/
License: GPL v3 or later
*/
defined( 'ABSPATH' ) or die( 'Go away!' );

/* Create Menu Item */
if ( is_admin() ){
  add_action( 'admin_menu', 'inline_tweets_menu' );
  add_action( 'admin_init', 'register_inline_tweets_settings' );
}

if (!function_exists("inline_tweets_menu")) {
	function inline_tweets_menu() {
		add_options_page('Inline Tweets Global Settings', 'Inline Tweets', 'manage_options', 'inline-tweets', 'inline_tweets_page');
	}
}

if (!function_exists("register_inline_tweets_settings")) {
	function register_inline_tweets_settings() {
		register_setting( 'inline_tweets_group', 'inline_tweets_via' );
		register_setting( 'inline_tweets_group', 'inline_tweets_tags' );
		register_setting( 'inline_tweets_group', 'inline_tweets_wrapper' );
	}
}

/* Create Settings Page */
if( !function_exists("inline_tweets_page") ) {
	function inline_tweets_page(){
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}
	?>
	<div class="wrap">
	<h2>Inline Tweets Global Settings</h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'inline_tweets_group' ); ?>
		<?php do_settings_sections( 'inline_tweets_group' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Add a twitter username (without the @) to append to the tweet</th>
				<td><input type="text" name="inline_tweets_via" value="<?php echo esc_attr( get_option('inline_tweets_via') ); ?>"/></td>
			</tr>
			<tr valign="top">
				<th scope="row">Add hashtags to the tweet (comma-separated, no spaces or punctuation)</th>
				<td><input type="text" name="inline_tweets_tags" value="<?php echo esc_attr( get_option('inline_tweets_tags') ); ?>"/></td>
			</tr>
			<tr valign="top">
				<th scope="row">Inline Tweets Wrapper (default is &lt;span&gt;)</th>
				<td><input type="text" name="inline_tweets_wrapper" value="<?php echo esc_attr( get_option('inline_tweets_wrapper') ); ?>"/></td>
			</tr>
		</table>		
		<?php submit_button(); ?>
	</form>
	<h2>How to Use</h2>
	<p>To use in a post or page: <strong>[inlinetweet]Your content here[/inlinetweet]</strong>.</p>
	<p>Shortcode options will overwrite the global settings above. These are:<br>
		<ul>
			<li>via</li>
			<li>tags</li>
			<li>url</li>
			<li>wrapper</li>
		</ul>
	</p>
	<p>For example, <strong>[inlinetweet wrapper="p" via="creativecatapps"]Click here to tweet this![/inlinetweet]</strong></p>
	</div>
	<?php
	}
}

/* Create shortcode */
if (!function_exists("inline_tweet_link")) {
	add_shortcode("inlinetweet", "inline_tweet_link");
	
	function inline_tweet_link( $atts, $content = null ) {
		
		extract(shortcode_atts(array(
			"via" => "",
			"tags" => "",
			"url" => "",
			"wrapper" => ""
		), $atts));
		
		wp_enqueue_style( 'inlineTweets', plugins_url('assets/inline-tweet.min.css',__FILE__ ));
		wp_enqueue_script( 'inlineTweets', plugins_url('assets/inline-tweet.min.js',__FILE__ ),array(jquery));
		
		global $wp;
		//$current_url = home_url(add_query_arg(array(),$wp->request));
		//$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		  $current_url = wp_get_shortlink();
		// check for local setting first
		if (isset($atts['via'])) {
			$via = $atts['via'];
		// then check for global setting
		} else if ( get_option('inline_tweets_via') != "") {
			$via = get_option('inline_tweets_via');
		// no via to display
		} else {
			$via = "";
		}
		
		// check for local setting first
		if (isset($atts['tags'])) {
			$tags = $atts['tags'];
		// then check for global setting
		} else if ( get_option('inline_tweets_tags') != "") {
			$tags = get_option('inline_tweets_tags');
		// no tags to display
		} else {
			$tags = "";
		}
		
		// check for local setting first
		if (isset($atts['url'])) {
			$url = $atts['url'];
		} else {
			// if no user setting, use current page URL
			$url = $current_url;
		}
		
		// check for local setting first
		if (isset($atts['wrapper'])) {
			$wrapper = $atts['wrapper'];
		// then check for global setting
		} else if ( get_option('inline_tweets_wrapper') != "") {
			$wrapper = get_option('inline_tweets_wrapper');
		// user default
		} else {
			$wrapper = "span";
		}
		
		if ( $via != "") {
			$setVia = ' data-inline-tweet-via="'. $via .'"';
		}
		if ( $tags != "") {
			$setTags = ' data-inline-tweet-tags="'. $tags .'"';
		}
		if ( $url != "") {
			$setUrl = ' data-inline-tweet-url="'. $url .'"';
		}

		return '<'.$wrapper.' data-inline-tweet'.$setVia.$setTags.$setUrl.'>'.$content.'</'.$wrapper.'>';
	}	
}
?>
