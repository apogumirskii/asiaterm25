<?php

/**
 * Прогревает кэш _thumbnail_id и attachment-постов для массива WP_Post или ID.
 * Применять перед циклом, в котором планируются вызовы has_post_thumbnail / get_the_post_thumbnail_url по этим постам.
 */
function asiaterm_prime_thumbnails( $posts ) {
    if ( empty( $posts ) ) return;
    $ids = [];
    foreach ( $posts as $p ) {
        if ( is_object( $p ) && isset( $p->ID ) ) {
            $ids[] = (int) $p->ID;
        } elseif ( is_numeric( $p ) ) {
            $ids[] = (int) $p;
        }
    }
    $ids = array_filter( array_unique( $ids ) );
    if ( ! $ids ) return;
    $q = new WP_Query( [
        'post__in'               => $ids,
        'posts_per_page'         => count( $ids ),
        'post_type'              => 'any',
        'post_status'            => 'any',
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
    ] );
    update_post_thumbnail_cache( $q );
    wp_reset_postdata();
}
