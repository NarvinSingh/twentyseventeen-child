<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'twentyseventeen' ); ?>">

	<div class="menu-site-social-menu-container">
		<ul class="social-menu">
			<li class="social-menu-item social-menu-item-first">
				<a href="#"><span class="screen-reader-text"><?php _e('Facebook', 'twentyseventeen'); ?></span><?php echo twentyseventeen_get_svg( array( 'icon' => 'facebook' ) ); ?></a>
			</li>
			<li class="social-menu-item">
				<a href="#"><span class="screen-reader-text"><?php _e('Twitter', 'twentyseventeen'); ?></span><?php echo twentyseventeen_get_svg( array( 'icon' => 'twitter' ) ); ?></a>
			</li>
			<li class="social-menu-item">
				<a href="#"><span class="screen-reader-text"><?php _e('Reddit', 'twentyseventeen'); ?></span><?php echo twentyseventeen_get_svg( array( 'icon' => 'reddit-alien' ) ); ?></a>
			</li>
			<li class="social-menu-item">
				<a href="#"><span class="screen-reader-text"><?php _e('Google Plus', 'twentyseventeen'); ?></span><?php echo twentyseventeen_get_svg( array( 'icon' => 'google-plus' ) ); ?></a>
			</li>
			<li class="social-menu-item social-menu-item-last">
				<a href="#"><span class="screen-reader-text"><?php _e('Email', 'twentyseventeen'); ?></span><?php echo twentyseventeen_get_svg( array( 'icon' => 'envelope-o' ) ); ?></a>
			</li>
		</ul>
	</div>

 	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo twentyseventeen_get_svg( array( 'icon' => 'bars' ) );
		echo twentyseventeen_get_svg( array( 'icon' => 'close' ) );
		// _e( 'Menu', 'twentyseventeen' );
		?>
	</button>

	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>

	<?php if ( ( twentyseventeen_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
		<a href="#content" class="menu-scroll-down"><?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span></a>
	<?php endif; ?>
</nav><!-- #site-navigation -->
