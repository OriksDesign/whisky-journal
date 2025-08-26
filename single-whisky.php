<?php
/**
 * Single Whisky
 * Шаблон сторінки окремого віскі (CPT: whisky)
 */

get_header();

while ( have_posts() ) :
	the_post();

	$pid   = get_the_ID();
	$title = get_the_title();

	// Meta
	$age_raw = get_post_meta( $pid, 'age', true );
	$abv_raw = get_post_meta( $pid, 'abv', true );

	$age_out = ($age_raw !== '' && $age_raw !== null) ? (int) $age_raw : '0';
	if ( $abv_raw !== '' && $abv_raw !== null ) {
		$abv_num = (float) $abv_raw;
		$abv_out = rtrim( rtrim( number_format( $abv_num, 1, '.', '' ), '0' ), '.' );
	} else {
		$abv_out = '—';
	}

	// Таксономії
	$region_terms = get_the_terms( $pid, 'region' );
	$region       = ( $region_terms && ! is_wp_error( $region_terms ) ) ? $region_terms[0] : null;

	$class_terms  = get_the_terms( $pid, 'classification' );
	$classification = ( $class_terms && ! is_wp_error( $class_terms ) ) ? $class_terms[0] : null;

	// Зображення
	$img_id      = get_post_thumbnail_id();
	$placeholder = get_stylesheet_directory_uri() . '/whisky.png';
	$img_html    = '';

	if ( $img_id ) {
		$img_html = wp_get_attachment_image(
			$img_id,
			'wj_hero', // додається у functions.php (add_image_size)
			false,
			[
				'class'    => 'wj-img',
				'loading'  => 'eager',
				'decoding' => 'async',
				'sizes'    => '(min-width:1024px) 720px, 100vw',
				'alt'      => esc_attr( $title ),
			]
		);
	}

	// Посилання
	$home_url     = home_url( '/' );
	$catalog_url  = get_post_type_archive_link( 'whisky' );

?>
<main class="max-w-screen-xl mx-auto px-4 py-8">

	<!-- Хлібні крихти -->
	<nav class="text-sm mb-6 text-slate-600" aria-label="<?php echo esc_attr__( 'Breadcrumb', 'whisky' ); ?>">
		<ol class="flex flex-wrap gap-2 items-center">
			<li><a class="hover:underline" href="<?php echo esc_url( $home_url ); ?>"><?php esc_html_e( 'Головна', 'whisky' ); ?></a></li>
			<li class="opacity-50">/</li>
			<li><a class="hover:underline" href="<?php echo esc_url( $catalog_url ); ?>"><?php esc_html_e( 'Каталог', 'whisky' ); ?></a></li>
			<li class="opacity-50">/</li>
			<li class="font-medium text-slate-900"><?php echo esc_html( $title ); ?></li>
		</ol>
	</nav>

	<div class="grid gap-8 lg:grid-cols-2 items-start">
		<!-- HERO зображення без кропу -->
		<div class="wj-media bg-[#eef3f7] rounded-2xl overflow-hidden">
			<?php if ( $img_html ) : ?>
				<?php echo $img_html; ?>
			<?php else : ?>
				<img src="<?php echo esc_url( $placeholder ); ?>" alt="" class="wj-img" />
			<?php endif; ?>
		</div>

		<!-- Правий блок: заголовок + мета + опис + дії -->
		<section>
			<h1 class="text-3xl md:text-4xl font-extrabold mb-4 text-slate-900"><?php echo esc_html( $title ); ?></h1>

			<ul class="text-sm text-slate-700 space-y-1 mb-4">
				<li>
					<span class="opacity-70"><?php esc_html_e( 'Вік:', 'whisky' ); ?></span>
					<strong class="ml-1"><?php echo esc_html( $age_out ); ?></strong>
				</li>
				<li>
					<span class="opacity-70"><?php esc_html_e( 'ABV:', 'whisky' ); ?></span>
					<strong class="ml-1"><?php echo esc_html( is_numeric( $abv_out ) ? $abv_out . '%' : $abv_out ); ?></strong>
				</li>
				<?php if ( $region ) : ?>
				<li>
					<span class="opacity-70"><?php esc_html_e( 'Регіон:', 'whisky' ); ?></span>
					<a class="ml-1 hover:underline"
					   href="<?php echo esc_url( get_term_link( $region ) ); ?>">
						<?php echo esc_html( $region->name ); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php if ( $classification ) : ?>
				<li>
					<span class="opacity-70"><?php esc_html_e( 'Класифікація:', 'whisky' ); ?></span>
					<a class="ml-1 hover:underline"
					   href="<?php echo esc_url( get_term_link( $classification ) ); ?>">
						<?php echo esc_html( $classification->name ); ?>
					</a>
				</li>
				<?php endif; ?>
			</ul>

			<div class="prose max-w-none mb-6">
				<?php
				$desc = get_the_content();
				if ( ! empty( $desc ) ) {
					the_content();
				} else {
					echo '<p class="text-slate-700">' . esc_html__( 'Опис буде додано найближчим часом.', 'whisky' ) . '</p>';
				}
				?>
			</div>

			<div class="flex flex-wrap gap-3">
				<a href="<?php echo esc_url( $catalog_url ); ?>"
				   class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-slate-300 hover:bg-slate-50">
					<span aria-hidden="true">←</span>
					<?php esc_html_e( 'До каталогу', 'whisky' ); ?>
				</a>

				<?php if ( $classification ) : ?>
					<a href="<?php echo esc_url( get_term_link( $classification ) ); ?>"
					   class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-slate-300 hover:bg-slate-50">
						<?php esc_html_e( 'Більше з «', 'whisky' ); echo esc_html( $classification->slug ); echo '»'; ?>
					</a>
				<?php endif; ?>
			</div>
		</section>
	</div>

	<!-- Схожі віскі -->
	<?php
		$tax_query = [];
		if ( $classification ) {
			$tax_query[] = [
				'taxonomy' => 'classification',
				'field'    => 'term_id',
				'terms'    => $classification->term_id,
			];
		}
		if ( $region ) {
			$tax_query[] = [
				'taxonomy' => 'region',
				'field'    => 'term_id',
				'terms'    => $region->term_id,
			];
		}
		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'OR';
		}

		$related = new WP_Query( [
			'post_type'           => 'whisky',
			'posts_per_page'      => 6,
			'post__not_in'        => [ $pid ],
			'ignore_sticky_posts' => true,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'tax_query'           => $tax_query,
		] );
	?>

	<?php if ( $related->have_posts() ) : ?>
		<section class="mt-12">
			<h2 class="text-xl md:text-2xl font-semibold mb-4"><?php esc_html_e( 'Схожі віскі', 'whisky' ); ?></h2>
			<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
				<?php
				while ( $related->have_posts() ) :
					$related->the_post();
					get_template_part( 'template-parts/content', 'whisky-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php endif; ?>

</main>
<?php
endwhile;

get_footer();
