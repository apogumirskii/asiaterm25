<?php

if ( ! function_exists( 'asiaterm_make_webp_from_file' ) ) {
    function asiaterm_make_webp_from_file( $file, $quality = 85 ) {
        if ( ! file_exists( $file ) ) return false;
        if ( ! preg_match( '#\.(jpe?g|png)$#i', $file ) ) return false;

        $webp_file = preg_replace( '#\.(jpe?g|png)$#i', '.webp', $file );
        if ( file_exists( $webp_file ) ) return $webp_file;

        if ( extension_loaded( 'imagick' ) && class_exists( 'Imagick' ) ) {
            try {
                $im = new Imagick( $file );
                $im->setImageFormat( 'webp' );
                $im->setImageCompressionQuality( $quality );
                $im->writeImage( $webp_file );
                $im->clear();
                $im->destroy();
                return $webp_file;
            } catch ( Exception $e ) { /* fallback to GD */ }
        }

        if ( ! function_exists( 'imagewebp' ) ) return false;

        $type = @exif_imagetype( $file );
        $img  = null;
        if ( IMAGETYPE_JPEG === $type ) {
            $img = @imagecreatefromjpeg( $file );
        } elseif ( IMAGETYPE_PNG === $type ) {
            $img = @imagecreatefrompng( $file );
            if ( $img ) {
                imagepalettetotruecolor( $img );
                imagealphablending( $img, false );
                imagesavealpha( $img, true );
            }
        }
        if ( ! $img ) return false;

        $ok = @imagewebp( $img, $webp_file, $quality );
        imagedestroy( $img );
        return $ok ? $webp_file : false;
    }
}

add_filter( 'wp_handle_upload', 'asiaterm_handle_upload_webp', 20 );
function asiaterm_handle_upload_webp( $upload ) {
    if ( ! empty( $upload['file'] ) ) {
        asiaterm_make_webp_from_file( $upload['file'] );
    }
    return $upload;
}

add_filter( 'wp_generate_attachment_metadata', 'asiaterm_metadata_webp', 20, 2 );
function asiaterm_metadata_webp( $metadata, $attachment_id ) {
    if ( empty( $metadata['file'] ) ) return $metadata;
    $upload_dir = wp_upload_dir();
    $base_path  = trailingslashit( $upload_dir['basedir'] );
    $main_file  = $base_path . $metadata['file'];
    asiaterm_make_webp_from_file( $main_file );
    if ( ! empty( $metadata['sizes'] ) ) {
        $main_dir = trailingslashit( dirname( $main_file ) );
        foreach ( $metadata['sizes'] as $size_data ) {
            if ( ! empty( $size_data['file'] ) ) {
                asiaterm_make_webp_from_file( $main_dir . $size_data['file'] );
            }
        }
    }
    return $metadata;
}

if ( ! function_exists( 'asiaterm_webp_url_swap' ) ) {
    function asiaterm_webp_url_swap( $url ) {
        if ( empty( $url ) || ! is_string( $url ) ) return $url;
        if ( ! preg_match( '#\.(jpe?g|png)(\?|$)#i', $url ) ) return $url;
        $upload_dir = wp_upload_dir();
        $base_url   = $upload_dir['baseurl'];
        $base_dir   = $upload_dir['basedir'];
        if ( strpos( $url, $base_url ) !== 0 ) return $url;
        $rel       = substr( $url, strlen( $base_url ) );
        $rel       = preg_replace( '#\?.*$#', '', $rel );
        $webp_path = $base_dir . preg_replace( '#\.(jpe?g|png)$#i', '.webp', $rel );
        if ( file_exists( $webp_path ) ) {
            return preg_replace( '#\.(jpe?g|png)(\?|$)#i', '.webp$2', $url );
        }
        return $url;
    }
}

add_filter( 'wp_get_attachment_image_src', 'asiaterm_webp_swap_image_src', 10, 4 );
function asiaterm_webp_swap_image_src( $image, $attachment_id, $size, $icon ) {
    if ( is_array( $image ) && ! empty( $image[0] ) ) {
        $image[0] = asiaterm_webp_url_swap( $image[0] );
    }
    return $image;
}

add_filter( 'wp_get_attachment_url', 'asiaterm_webp_url_swap', 10, 1 );

add_filter( 'wp_get_attachment_image_attributes', 'asiaterm_webp_swap_attrs', 10, 3 );
function asiaterm_webp_swap_attrs( $attr, $attachment, $size ) {
    if ( ! empty( $attr['src'] ) ) {
        $attr['src'] = asiaterm_webp_url_swap( $attr['src'] );
    }
    if ( ! empty( $attr['srcset'] ) ) {
        $attr['srcset'] = preg_replace_callback(
            '#(https?://[^\s,]+\.(?:jpe?g|png))#i',
            function ( $m ) { return asiaterm_webp_url_swap( $m[1] ); },
            $attr['srcset']
        );
    }
    return $attr;
}

add_filter( 'the_content', 'asiaterm_webp_swap_content', 99 );
function asiaterm_webp_swap_content( $html ) {
    if ( ! is_string( $html ) || strpos( $html, '<img' ) === false ) return $html;
    return preg_replace_callback(
        '#<img\b[^>]*?>#i',
        function ( $tag_match ) {
            $tag = $tag_match[0];
            return preg_replace_callback(
                '#\b(src|srcset|data-src|data-srcset)=("|\')(.*?)\2#i',
                function ( $a ) {
                    $value = preg_replace_callback(
                        '#https?://[^\s,"\']+\.(?:jpe?g|png)#i',
                        function ( $u ) { return asiaterm_webp_url_swap( $u[0] ); },
                        $a[3]
                    );
                    return $a[1] . '=' . $a[2] . $value . $a[2];
                },
                $tag
            );
        },
        $html
    );
}
