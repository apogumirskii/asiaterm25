<?php

function register_my_menu() {
    register_nav_menus([
        'menu'    => __('Menu'),
        'topmenu' => __('Top Menu'),
    ]);
}
add_action('init', 'register_my_menu');
