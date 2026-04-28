<?php

function my_post_type_portfolio() {
    register_post_type('portfolio', [
        'label'               => __('Проекты', 'asiaterm25'),
        'labels'              => [
            'name'               => __('Проекты', 'asiaterm25'),
            'singular_name'      => __('Проект', 'asiaterm25'),
            'add_new'            => __('Добавить проект', 'asiaterm25'),
            'add_new_item'       => __('Новый проект', 'asiaterm25'),
            'edit_item'          => __('Редактировать проект', 'asiaterm25'),
            'all_items'          => __('Все проекты', 'asiaterm25'),
            'search_items'       => __('Поиск проектов', 'asiaterm25'),
            'not_found'          => __('Проекты не найдены', 'asiaterm25'),
        ],
        'public'              => true,
        'has_archive'         => false,
        'show_ui'             => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-images-alt2',
        'rewrite'             => ['slug' => 'projects', 'with_front' => false],
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
    ]);
}
add_action('init', 'my_post_type_portfolio');

function create_portfolio_category_taxonomy() {
    register_taxonomy('portfolio_category', 'portfolio', [
        'label'             => __('Категории портфолио', 'asiaterm25'),
        'labels'            => [
            'name'          => __('Категории портфолио', 'asiaterm25'),
            'singular_name' => __('Категория', 'asiaterm25'),
            'add_new_item'  => __('Добавить категорию', 'asiaterm25'),
            'search_items'  => __('Поиск категорий', 'asiaterm25'),
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'portfolio-cat', 'with_front' => false],
    ]);
}
add_action('init', 'create_portfolio_category_taxonomy', 0);
