<?php

function asiaterm_allow_svg_upload($mimes) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'asiaterm_allow_svg_upload');

function asiaterm_fix_svg_mime_check($data, $file, $filename, $mimes) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext === 'svg' || $ext === 'svgz') {
        $data['type'] = 'image/svg+xml';
        $data['ext']  = $ext;
        $data['proper_filename'] = $filename;
    }
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'asiaterm_fix_svg_mime_check', 10, 4);

function allow_svg_uploads($mimes) {
    if (current_user_can('administrator')) {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
		$mimes['avif'] = 'image/avif';
    }
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

add_filter('file_is_displayable_image', function($result, $path) {
    if (!$result) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($ext === 'avif') {
            $result = true;
        }
    }
    return $result;
}, 10, 2);

function sanitize_svg($file) {
    if ($file['type'] !== 'image/svg+xml') return $file;

    $svg_content = file_get_contents($file['tmp_name']);
    $svg_content = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $svg_content);
    $svg_content = preg_replace('/\s+on\w+=["\'][^"\']*["\']/i', '', $svg_content);
    $svg_content = preg_replace('/(href|xlink:href)\s*=\s*["\']javascript:[^"\']*["\']/i', '', $svg_content);
    file_put_contents($file['tmp_name'], $svg_content);

    return $file;
}
add_filter('wp_handle_upload_prefilter', 'sanitize_svg');
