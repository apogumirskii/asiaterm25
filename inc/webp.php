<?php

/**
 * Автоконвертация JPEG/PNG в современный формат (AVIF → WebP) при загрузке.
 *
 * Логика:
 *   1. Проверяем, умеет ли WP-image-editor создавать AVIF (WP 6.5+ + Imagick/GD с LIBAVIF).
 *   2. Если да — конвертим в AVIF (на ~20-30% легче WebP).
 *   3. Если нет — fallback в WebP.
 *
 * Исходный JPEG/PNG остаётся в Медиабиблиотеке как оригинал (доступен для скачивания
 * / lightbox / старых браузеров без AVIF), но все размеры через add_image_size()
 * создаются в новом формате.
 *
 * Для уже загруженных изображений нужно один раз запустить плагин «Regenerate Thumbnails»
 * — он пересоздаст размеры в новом формате.
 */
add_filter( 'image_editor_output_format', 'asiaterm_image_editor_output_format' );
function asiaterm_image_editor_output_format( $formats ) {
    $target = asiaterm_preferred_image_format();
    $formats['image/jpeg'] = $target;
    $formats['image/png']  = $target;
    return $formats;
}

/**
 * Возвращает MIME-тип лучшего доступного формата на текущем сервере.
 * Результат кэшируется в transient (1 неделя) — проверка через image_editor дорогая.
 */
function asiaterm_preferred_image_format() {
    $cached = get_transient( 'asiaterm_preferred_image_format' );
    if ( $cached ) return $cached;

    $target = 'image/webp'; // безопасный fallback

    if ( function_exists( 'wp_image_editor_supports' ) ) {
        // WP 6.5+ умеет AVIF при наличии Imagick с LIBAVIF или GD (PHP 8.1+ с AVIF)
        if ( wp_image_editor_supports( [ 'mime_type' => 'image/avif' ] ) ) {
            $target = 'image/avif';
        } elseif ( wp_image_editor_supports( [ 'mime_type' => 'image/webp' ] ) ) {
            $target = 'image/webp';
        }
    }

    set_transient( 'asiaterm_preferred_image_format', $target, WEEK_IN_SECONDS );
    return $target;
}

// Сброс кэша при апгрейде PHP/WP/расширений — раз в неделю и так истекает,
// но дадим способ форсировать через переключение темы.
add_action( 'switch_theme', function () { delete_transient( 'asiaterm_preferred_image_format' ); } );

/**
 * Совместимость: shim для вызовов asiaterm_webp_url_swap() из шаблонов.
 * WP сам отдаёт URL в правильном формате (AVIF/WebP для размеров, оригинал JPEG для full).
 */
if ( ! function_exists( 'asiaterm_webp_url_swap' ) ) {
    function asiaterm_webp_url_swap( $url ) {
        return $url;
    }
}
