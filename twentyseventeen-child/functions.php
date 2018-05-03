<?php
function twentyseventeen_child_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'twentyseventeen_child_enqueue_styles');

function add_nav_menu_class ($items, $args) {

	if( $args->theme_location != 'primary' ) {
		return $items;
	}

	$dom = new DOMDocument;
	$dom->loadHTML($items);
	$xpath = new DOMXPath($dom);
	$lis = $xpath->query('/html/body/li');

	if ($lis->length == 0) {
		return $items;
	}

	for ($i = 0; $i < $lis->length; $i++) {
		$lis[$i]->setAttribute('class', $lis[$i]->getAttribute('class') . ' menu-item-order-' . ($i + 1));
	}

	$lis[0]->setAttribute('class', $lis[0]->getAttribute('class') . ' menu-item-order-first');
	$lis[$lis->length - 1]->setAttribute(
		'class', 
		$lis[$lis->length - 1]->getAttribute('class') . ' menu-item-order-last');

	return $dom->saveHTML();
}

add_filter('wp_nav_menu_items', 'add_nav_menu_class', 10, 2 );

function get_social_menu() {

	if (is_single()) {
		$url = get_permalink();
		$text = get_the_title();
	} else {
		$url = get_home_url();
		$text = get_bloginfo();
	}

	$url_enc = urlencode($url);
	$text_enc = urlencode($text);
	$facebook = 'http://www.facebook.com/sharer.php?u=' . $url;
	$twitter = 'http://twitter.com/share?url=' . $url . '&text=' . $text;
	$reddit = 'http://reddit.com/submit?url=' . $url . '&title=' . $text;
	$google = 'http://plus.google.com/share?url=' . $url;
	$mail = 'mailto:?subject=' . $text . '&body=' . $url;
	$facebook_icon = twentyseventeen_get_svg( array( 'icon' => 'facebook' ) );
	$twitter_icon = twentyseventeen_get_svg( array( 'icon' => 'twitter' ) );
	$reddit_icon = twentyseventeen_get_svg( array( 'icon' => 'reddit-alien' ) );
	$google_icon = twentyseventeen_get_svg( array( 'icon' => 'google-plus' ) );
	$mail_icon = twentyseventeen_get_svg( array( 'icon' => 'envelope-o' ) );
	$menu = <<<EOT
	<div class="menu-site-social-menu-container">
		<ul class="social-menu">
			<li class="social-menu-item social-menu-item-first">
				<a href="$facebook" target="_blank"><span class="screen-reader-text"><?php _e('Facebook', 'twentyseventeen'); ?></span>$facebook_icon</a>
			</li>
			<li class="social-menu-item">
				<a href="$twitter" target="_blank"><span class="screen-reader-text"><?php _e('Twitter', 'twentyseventeen'); ?></span>$twitter_icon</a>
			</li>
			<li class="social-menu-item">
				<a href="$reddit" target="_blank"><span class="screen-reader-text"><?php _e('Reddit', 'twentyseventeen'); ?></span>$reddit_icon</a>
			</li>
			<li class="social-menu-item">
				<a href="$google" target="_blank"><span class="screen-reader-text"><?php _e('Google Plus', 'twentyseventeen'); ?></span>$google_icon</a>
			</li>
			<li class="social-menu-item social-menu-item-last">
				<a href="$mail" target="_top"><span class="screen-reader-text"><?php _e('Email', 'twentyseventeen'); ?></span>$mail_icon</a>
			</li>
		</ul>
	</div>
EOT;

	return $menu;
}

function add_login_menu_item($items, $args) {
	global $wp;

	ob_start();
	wp_loginout(home_url($wp->request));
	$link = ob_get_contents();
	ob_end_clean();
	$items .= '<li class="menu-item">' . $link . '</li>';

	return $items;
}

add_filter('wp_nav_menu_items', 'add_login_menu_item', 10, 2);

function add_grid_post_class ($classes) {
   global $current_grid_post_class;
   
   $classes[] = 'grid-post-2-' . (1 + ($current_grid_post_class % 2));
   $classes[] = 'grid-post-3-' . (1 + ($current_grid_post_class % 3));
   $classes[] = 'grid-post-4-' . (1 + ($current_grid_post_class % 4));
   $current_grid_post_class++;
   
   return $classes;
}

$current_grid_post_class = 0;
add_filter ('post_class' , 'add_grid_post_class');

function twentyseventeen_posted_on() {

	$author_id = get_the_author_meta('ID');
	$author_posts_url = esc_url(get_author_posts_url($author_id));

	// Get the author avatar; wrap it in a link.
	if (is_single()) {
		$avatar = sprintf(
			/* translators: %s: post author */
			__( '%s', 'twentyseventeen' ),
			'<span class="author avatar"><a class="url fn n" href="' . $author_posts_url . '">' . get_avatar($author_id, 96) . '</a></span>'
		);
	}

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '%s', 'twentyseventeen' ),
		'<span class="author vcard"><a class="url fn n" href="' . $author_posts_url . '">' . get_the_author() . '</a></span>'
	);

	$posted_on = sprintf(
		/* translators: %s: post author */
		__( '%s', 'twentyseventeen' ),
		'<span class="posted-on">' . twentyseventeen_time_link() . '</span>'
	);

	// Finally, let's write all of this to the page.
	echo $avatar . $byline . '<span class="post-meta-divider"> / </span>' . $posted_on;
}

function twentyseventeen_single_post_meta() {

	$author_id = get_the_author_meta('ID');
	$author_posts_url = esc_url(get_author_posts_url($author_id));

	// Get the author avatar; wrap it in a link.
	$avatar = sprintf(
		/* translators: %s: post author */
		__( '%s', 'twentyseventeen' ),
		'<div class="author avatar"><a class="url fn n" href="' . $author_posts_url . '">' . get_avatar($author_id, 72) . '</a></div>'
	);

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '%s', 'twentyseventeen' ),
		'<div class="author vcard"><a class="url fn n" href="' . $author_posts_url . '">' . get_the_author() . '</a></div>'
	);

	$posted_on = sprintf(
		/* translators: %s: post author */
		__( '%s', 'twentyseventeen' ),
		'<div class="posted-on">' . twentyseventeen_time_link() . '</div>'
	);

	// Finally, let's write all of this to the page.
	echo $avatar . $byline . $posted_on;
}

function twentyseventeen_post_meta() {

	$author_id = get_the_author_meta('ID');
	$author_posts_url = esc_url(get_author_posts_url($author_id));

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '%s', 'twentyseventeen' ),
		'<span class="author vcard"><a class="url fn n" href="' . $author_posts_url . '">' . get_the_author() . '</a></span>'
	);

	$posted_on = sprintf(
		/* translators: %s: post author */
		__( '%s', 'twentyseventeen' ),
		'<span class="posted-on">' . twentyseventeen_time_link() . '</span>'
	);

	// Finally, let's write all of this to the page.
	echo $byline . '<span class="post-meta-divider"> / </span>' . $posted_on;
}

function twentyseventeen_entry_footer() {

	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'twentyseventeen' );

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	// $tags_list = get_the_tag_list( '', $separate_meta );

	$menu = get_social_menu();

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( twentyseventeen_categorized_blog() && $categories_list ) /*|| $tags_list*/ ) || get_edit_post_link() || $menu ) {

		echo '<footer class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && twentyseventeen_categorized_blog() ) /*|| $tags_list*/) {
					echo '<span class="cat-tags-links">';

						// Make sure there's more than one category before displaying.
						if ( $categories_list && twentyseventeen_categorized_blog() ) {
							echo '<span class="cat-links">' . twentyseventeen_get_svg( array( 'icon' => 'folder-open' ) ) . '<span class="screen-reader-text">' . __( 'Categories', 'twentyseventeen' ) . '</span>' . $categories_list . '</span>';
						}

						// if ( $tags_list ) {
						// 	echo '<span class="tags-links">' . twentyseventeen_get_svg( array( 'icon' => 'hashtag' ) ) . '<span class="screen-reader-text">' . __( 'Tags', 'twentyseventeen' ) . '</span>' . $tags_list . '</span>';
						// }

					echo '</span>';
				}

				if ($menu) {
					echo '<div class="call-to-action">If you liked this article, please take a moment to share it. You will be helping us grow our audience, which will motivate us to keep going. Otherwise, Narvin is gonna go play Skyrim and Marteena will work on her glutes.</div>';
					echo $menu;					
				}
			}

			twentyseventeen_edit_link();

		echo '</footer> <!-- .entry-footer -->';
	}
}

function append_to_head() {
   	global $post;

   	if(is_single()) {
	   	echo get_post_meta($post->ID, 'twitter_card', true) . get_post_meta($post->ID, 'facebook_open_graph', true);
   	}
}
add_action('wp_head', 'append_to_head');

function sanitize_user_description($description) {
	$user = wp_get_current_user();
	$role = $user && $user->roles ? $user->roles[0] : NULL;

	return in_array($role, array('administrator')) ? $description : wp_filter_kses($description);
}

remove_filter('pre_user_description', 'wp_filter_kses');
add_filter('pre_user_description', 'sanitize_user_description');
?>