<?php
/**
 * Whisky card (used on archive)
 */

/** @var int $post_id */
$post_id = get_the_ID();

// Age (years) and ABV (%)
$age = wj_get_number_meta( $post_id, 'age' );
$abv = wj_get_number_meta( $post_id, 'abv' );

// Terms
$region_txt = wj_terms_list( $post_id, 'region' );
$class_txt  = wj_terms_list( $post_id, 'classification' );

// Image
$thumb_html = get_the_post_thumbnail( $post_id, 'whisky-card', [
	'style' => 'width:100%;height:auto;display:block;border-radius:12px;object-fit:cover;background:#f2f2f2;aspect-ratio:1/1;',
	'alt'   => esc_attr( get_the_title() ),
] );

?>
<article <?php post_class( 'wj-card' ); ?> style="border:1px solid #e5e5e5;border-radius:16px;padding:12px;overflow:hidden;background:#fff;">
	<a href="<?php the_permalink(); ?>" style="display:block;text-decoration:none;color:inherit;">
		<div class="wj-card-image" style="margin-bottom:12px;">
			<?php
			if ( $thumb_html ) {
				echo $thumb_html; // phpcs:ignore WordPress.Security.EscapeOutput
			} else {
				// placeholder
				echo '<div style="display:flex;align-items:center;justify-content:center;background:#f3f4f6;border-radius:12px;aspect-ratio:1/1;color:#999;">No image</div>';
			}
			?>
		</div>
		<h2 class="wj-card-title" style="font-size:18px;margin:0 0 6px 0;"><?php the_title(); ?></h2>

		<?php if ( $region_txt || $class_txt ) : ?>
			<div class="wj-meta" style="font-size:13px;color:#666;margin-bottom:6px;">
				<?php if ( $region_txt ) : ?>
					<span><?php echo esc_html( $region_txt ); ?></span>
				<?php endif; ?>
				<?php if ( $region_txt && $class_txt ) : ?>
					<span> · </span>
				<?php endif; ?>
				<?php if ( $class_txt ) : ?>
					<span><?php echo esc_html( $class_txt ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="wj-specs" style="display:flex;gap:12px;font-size:13px;color:#444;margin-bottom:8px;">
			<?php
			$age_txt = $age ? sprintf( /* translators: age in years */ __( 'Age: %d', 'whisky' ), (int) $age ) : __( 'Age: NAS', 'whisky' );
			echo '<span>' . esc_html( $age_txt ) . '</span>';

			if ( $abv !== null ) {
				echo '<span>' . esc_html( sprintf( __( 'ABV: %s%%', 'whisky' ), rtrim( rtrim( (string) $abv, '0' ), '.' ) ) ) . '</span>';
			}
			?>
		</div>

		<button style="display:inline-block;padding:6px 10px;border-radius:8px;background:#111;color:#fff;border:0;cursor:pointer;font-size:13px;">
			<?php esc_html_e( 'Details', 'whisky' ); ?>
		</button>
	</a>
</article>
