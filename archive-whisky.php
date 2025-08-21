<?php
/**
 * Archive – Whisky
 * URL: /whisky/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main container" style="max-width:1200px;margin:0 auto;padding:40px 20px;">
	<header class="page-header" style="margin-bottom:24px;">
		<h1 class="page-title" style="font-size:32px;margin:0;"><?php esc_html_e( 'Whiskies', 'whisky' ); ?></h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="wj-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'whisky-card' );
			endwhile;
			?>
		</div>

		<nav class="pagination" style="margin-top:32px;">
			<?php
			the_posts_pagination( [
				'mid_size'  => 2,
				'prev_text' => '«',
				'next_text' => '»',
			] );
			?>
		</nav>

	<?php else : ?>

		<p><?php esc_html_e( 'No whiskies found.', 'whisky' ); ?></p>

	<?php endif; ?>
</main>

<?php
get_footer();
