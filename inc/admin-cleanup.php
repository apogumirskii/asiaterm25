<?php
// Скрыть уведомление Meta Box о лицензии в админке
add_action('admin_head', function () {
    echo '<style>
        .notice.notice-warning a[href*="meta-box-updater"],
        .notice.notice-warning a[href*="elu.to/mnp"] { display: none; }
        .notice.notice-warning:has(a[href*="meta-box-updater"]) { display: none !important; }
    </style>';
});

// Удаляем уведомления Meta Box об отсутствии лицензии
add_action('admin_init', function () {
    if (class_exists('MB_Updater_Notification')) {
        remove_action('admin_notices', ['MB_Updater_Notification', 'notify']);
    }
}, 100);
