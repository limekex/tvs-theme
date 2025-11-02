<?php
/**
 * Server-side render for Routes Grid block
 * Layout: image background with overlay
 * - Title: top center
 * - Badges: season, region (top area)
 * - Meta (distance, elevation, duration): bottom center, evenly spaced
 * - Difficulty: icon indicator (1 easy, 2 moderate, 3 hard)
 */

// Attributes with sane defaults
$per_page       = isset( $attributes['perPage'] ) ? max( 1, intval( $attributes['perPage'] ) ) : 6;
$columns        = isset( $attributes['columns'] ) ? max( 1, min( 6, intval( $attributes['columns'] ) ) ) : 3;
$order_by       = isset( $attributes['orderBy'] ) && preg_match( '/^[a-z_]+$/', (string) $attributes['orderBy'] ) ? (string) $attributes['orderBy'] : 'date';
$order          = isset( $attributes['order'] ) && strtoupper( (string) $attributes['order'] ) === 'ASC' ? 'ASC' : 'DESC';
$filter_region  = isset( $attributes['region'] ) ? trim( (string) $attributes['region'] ) : '';
$filter_season  = isset( $attributes['season'] ) ? trim( strip_tags( (string) $attributes['season'] ) ) : '';
$show_badges    = array_key_exists( 'showBadges', $attributes ) ? (bool) $attributes['showBadges'] : true;
$show_meta      = array_key_exists( 'showMeta', $attributes ) ? (bool) $attributes['showMeta'] : true;
$show_difficulty= array_key_exists( 'showDifficulty', $attributes ) ? (bool) $attributes['showDifficulty'] : true;

$args = [
	'post_type'      => 'tvs_route',
	'posts_per_page' => $per_page,
	'post_status'    => 'publish',
	'orderby'        => in_array( $order_by, [ 'date', 'title', 'meta_value_num' ], true ) ? $order_by : 'date',
	'order'          => $order,
];

// Optional region filter (taxonomy)
if ( ! empty( $filter_region ) ) {
	$args['tax_query'] = [
		[
			'taxonomy' => 'tvs_region',
			'field'    => 'slug',
			'terms'    => $filter_region,
		],
	];
}

// Optional season filter (meta)
if ( ! empty( $filter_season ) ) {
	$args['meta_query'] = [
		[
			'key'   => 'season',
			'value' => $filter_season,
			'compare' => '=',
		],
	];
}

$q = new WP_Query( $args );

if ( ! $q->have_posts() ) {
	echo '<p>No routes available yet.</p>';
	return;
}

// Helpers
function tvs_human_km( $meters ) {
	$m = floatval( $meters );
	if ( $m <= 0 ) return '';
	$km = $m / 1000;
	return ( $km >= 10 ) ? number_format( floor( $km ) ) . ' km' : number_format( $km, 1 ) . ' km';
}
function tvs_human_duration( $seconds ) {
	$s = intval( $seconds );
	if ( $s <= 0 ) return '';
	$min = floor( $s / 60 );
	if ( $min < 60 ) return $min . ' min';
	$h = floor( $min / 60 );
	$rem = $min % 60;
	return sprintf( '%d:%02d h', $h, $rem );
}
function tvs_diff_count( $val ) {
	$map = [ 'easy' => 1, 'moderate' => 2, 'medium' => 2, 'hard' => 3, 'difficult' => 3 ];
	$k = strtolower( trim( (string) $val ) );
	return $map[ $k ] ?? 0;
}

echo '<div class="tvs-routes-grid" style="--tvs-routes-cols: ' . intval( $columns ) . ';">';
while ( $q->have_posts() ) {
	$q->the_post();
	$id    = get_the_ID();
	$title = get_the_title();
	$link  = get_permalink();
	$img   = get_the_post_thumbnail_url( $id, 'large' );

	// Meta with fallbacks to both legacy _tvs_* and new names
	$dist  = get_post_meta( $id, 'distance_m', true );
	if ( '' === $dist ) $dist = get_post_meta( $id, '_tvs_distance_m', true );
	$elev  = get_post_meta( $id, 'elevation_m', true );
	if ( '' === $elev ) $elev = get_post_meta( $id, '_tvs_elevation_m', true );
	$dur   = get_post_meta( $id, 'duration_s', true );
	if ( '' === $dur ) $dur = get_post_meta( $id, '_tvs_duration_s', true );
	$difficulty = get_post_meta( $id, 'difficulty', true );
	$season     = get_post_meta( $id, 'season', true );

	// Region term name(s)
	$region_names = [];
	$terms = get_the_terms( $id, 'tvs_region' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) { $region_names[] = $t->name; }
	}

	echo '<article class="tvs-route-card">';
	// Clickable card wrapper
	echo '<a class="tvs-route-card__link" href="' . esc_url( $link ) . '">';
	// Background
	echo '<div class="tvs-route-card__bg"' . ( $img ? ' style="background-image:url(' . esc_url( $img ) . ');"' : '' ) . '></div>';
	// Overlay content
	echo '<div class="tvs-route-card__overlay">';

	// Top cluster: title centered + optional badges row and difficulty indicator
	echo '<div class="tvs-route-card__top">';
		echo '<h3 class="tvs-route-card__title">' . esc_html( $title ) . '</h3>';
		if ( $show_badges ) {
			$badges = [];
			if ( ! empty( $season ) ) {
				$badges[] = '<span class="tvs-badge tvs-badge--season">' . esc_html( ucfirst( $season ) ) . '</span>';
			}
			if ( ! empty( $region_names ) ) {
				$badges[] = '<span class="tvs-badge tvs-badge--region">' . esc_html( implode( ', ', $region_names ) ) . '</span>';
			}
			if ( ! empty( $badges ) ) {
				echo '<div class="tvs-route-card__badges">' . implode( '', $badges ) . '</div>';
			}
		}
		if ( $show_difficulty ) {
			$count = tvs_diff_count( $difficulty );
			if ( $count > 0 ) {
				echo '<div class="tvs-route-card__difficulty" aria-label="Difficulty: ' . esc_attr( $difficulty ) . '">';
				for ( $i = 0; $i < $count; $i++ ) {
					echo '<span class="tvs-diff-dot" aria-hidden="true"></span>';
				}
				echo '</div>';
			}
		}
		echo '</div>'; // top

	// Bottom meta row
	if ( $show_meta ) {
		$meta_items = [];
		if ( $dist ) { $meta_items[] = '<span class="meta-item meta-item--distance"><span class="meta-icon" aria-hidden="true">⟷</span>' . esc_html( tvs_human_km( $dist ) ) . '</span>'; }
		if ( $elev ) { $meta_items[] = '<span class="meta-item meta-item--elevation"><span class="meta-icon" aria-hidden="true">⛰</span>' . esc_html( intval( $elev ) ) . ' m</span>'; }
		if ( $dur )  { $meta_items[] = '<span class="meta-item meta-item--duration"><span class="meta-icon" aria-hidden="true">⏱</span>' . esc_html( tvs_human_duration( $dur ) ) . '</span>'; }
		if ( ! empty( $meta_items ) ) {
			echo '<div class="tvs-route-card__meta">' . implode( '', $meta_items ) . '</div>';
		}
	}

	echo '</div>'; // overlay
	echo '</a>';
	echo '</article>';
}
echo '</div>';
wp_reset_postdata();
