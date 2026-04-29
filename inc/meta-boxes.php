<?php

add_filter( 'rwmb_meta_boxes', 'your_prefix_register_meta_boxes' );

function your_prefix_register_meta_boxes( $meta_boxes ) {
    $prefix = 'prod_';

    $meta_boxes[] = [
        'title'      => esc_html__( 'Основные параметры', 'asiaterm25' ),
        'id'         => 'product_params_base',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'fields'     => [

            [
                'type' => 'textarea',
                'name' => esc_html__( 'Иконка', 'asiaterm25' ),
                'id'   => $prefix . 'icon',
                'desc' => esc_html__( 'Вставьте HTML-код иконки (SVG, Font Awesome и т.д.)', 'asiaterm25' ),
                'rows' => 3,
            ],

            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея', 'asiaterm25' ),
                'id'               => $prefix . 'service_gallery',
                'desc'             => esc_html__( 'Загрузите до 20 изображений', 'asiaterm25' ),
                'max_file_uploads' => 20,
            ],

        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Параметры категории / Иконки', 'asiaterm25' ),
        'id'         => 'category_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-category.php', 'page-complexproduct.php', 'page-singleproduct.php'],
        ],
        'fields'     => [
            [
                'name'    => esc_html__( 'Краткое описание', 'asiaterm25' ),
                'id'      => $prefix . 'cat_shortdesc',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 6,
                    'media_buttons' => false,
                    'teeny'         => true,
                ],
            ],
            [
                'name'       => esc_html__( 'Иконки-преимущества', 'asiaterm25' ),
                'id'         => $prefix . 'cat_features',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить иконку', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name'             => esc_html__( 'Иконка (SVG/PNG)', 'asiaterm25' ),
                        'id'               => 'feature_icon',
                        'type'             => 'image_advanced',
                        'max_file_uploads' => 1,
                        'desc'             => esc_html__( 'SVG или PNG иконка', 'asiaterm25' ),
                    ],
                    [
                        'name' => esc_html__( 'Заголовок', 'asiaterm25' ),
                        'id'   => 'feature_title',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Описание', 'asiaterm25' ),
                        'id'   => 'feature_desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ],
                ],
            ],
        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Параметры товара', 'asiaterm25' ),
        'id'         => 'product_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-singleproduct.php', 'page-complexproduct.php'],
        ],
        'fields'     => [

			[
				'name' => esc_html__( 'Показать на главной', 'asiaterm25' ),
				'id'   => $prefix . 'show_on_home',
				'type' => 'checkbox',
				'desc' => esc_html__( 'Вывести товар в блоке "Популярные товары"', 'asiaterm25' ),
			],

			[
				'name'        => esc_html__( 'Цена', 'asiaterm25' ),
				'id'          => $prefix . 'price',
				'type'        => 'text',
				'placeholder' => '999',
			],

            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея дополнительная', 'asiaterm25' ),
                'id'               => $prefix . 'service_gallery2',
                'desc'             => esc_html__( 'Загрузите до 20 изображений', 'asiaterm25' ),
                'max_file_uploads' => 20,
            ],

			[
				'name'        => esc_html__( 'Вариации', 'asiaterm25' ),
				'id'          => $prefix . 'var_titles',
				'type'        => 'text',
				'clone'       => true,
				'add_button'  => esc_html__( '+ Добавить вариацию', 'asiaterm25' ),
				'placeholder' => 'Стандарт / Премиум',
			],

            [
                'name'    => esc_html__( 'Технические характеристики', 'asiaterm25' ),
                'id'      => $prefix . 'specs',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Подробное описание с форматированием, таблицами и изображениями', 'asiaterm25' ),
            ],

            [
                'name'    => esc_html__( 'Краткое описание', 'asiaterm25' ),
                'id'      => $prefix . 'shortdesc',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Краткое текстовое описание', 'asiaterm25' ),
            ],

            [
                'name' => esc_html__( 'Название блока', 'asiaterm25' ),
                'id'   => $prefix . 'costomdescr_title',
                'type' => 'text',
            ],

            [
                'name'    => esc_html__( 'Произвольный редактор', 'asiaterm25' ),
                'id'      => $prefix . 'costomdescr',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Краткое текстовое описание', 'asiaterm25' ),
            ],

            [
                'name'    => esc_html__( 'Комплектация', 'asiaterm25' ),
                'id'      => $prefix . 'complect',
                'type'    => 'wysiwyg',
                'options' => [
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny'         => false,
                ],
                'desc'    => esc_html__( 'Текстовое описание комплектации', 'asiaterm25' ),
            ],

            [
                'name'             => esc_html__( 'Файлы для скачивания', 'asiaterm25' ),
                'id'               => $prefix . 'downloads',
                'type'             => 'file_advanced',
                'max_file_uploads' => 10,
                'mime_type'        => 'application/pdf,image,application/zip,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'add_button'       => esc_html__( '+ Добавить медиа', 'asiaterm25' ),
                'desc'             => esc_html__( 'PDF, JPG, PNG. Максимум 10 файлов.', 'asiaterm25' ),
            ],

            [
                'name'        => esc_html__( 'Смежные товары', 'asiaterm25' ),
                'id'          => $prefix . 'related_pages',
                'type'        => 'post',
                'post_type'   => 'page',
                'field_type'  => 'select_advanced',
                'multiple'    => true,
                'placeholder' => esc_html__( 'Выберите смежные товары', 'asiaterm25' ),
                'query_args'  => [
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ],
                'desc'        => esc_html__( 'Только страницы, вложенные в ID 13 (включая подуровни)', 'asiaterm25' ),
            ],

            [
                'name'        => esc_html__( 'Портфолио проекты', 'asiaterm25' ),
                'id'          => $prefix . 'portfolio_pages',
                'type'        => 'post',
                'post_type'   => 'portfolio',
                'field_type'  => 'select_advanced',
                'multiple'    => true,
                'placeholder' => esc_html__( 'Выберите проекты', 'asiaterm25' ),
                'query_args'  => [
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ],
            ],

        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "О нас"', 'asiaterm25' ),
        'id'         => 'about_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-about.php'],
        ],
        'fields'     => [
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Фото компании', 'asiaterm25' ),
                'id'               => 'about_image',
                'max_file_uploads' => 1,
            ],
            [
                'name'    => esc_html__( 'Текст о компании', 'asiaterm25' ),
                'id'      => 'about_text',
                'type'    => 'wysiwyg',
                'options' => ['textarea_rows' => 10, 'media_buttons' => true],
            ],
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея', 'asiaterm25' ),
                'id'               => 'about_gallery',
                'max_file_uploads' => 20,
            ],
            [
                'name'       => esc_html__( 'Преимущества', 'asiaterm25' ),
                'id'         => 'about_features',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить преимущество', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name' => esc_html__( 'Номер', 'asiaterm25' ),
                        'id'   => 'about_feature_num',
                        'type' => 'text',
                        'placeholder' => '01',
                        'size' => 5,
                    ],
                    [
                        'name' => esc_html__( 'Заголовок', 'asiaterm25' ),
                        'id'   => 'about_feature_title',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Описание', 'asiaterm25' ),
                        'id'   => 'about_feature_desc',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            [
                'name'       => esc_html__( 'Команда', 'asiaterm25' ),
                'id'         => 'about_team',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить сотрудника', 'asiaterm25' ),
                'fields'     => [
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Фото', 'asiaterm25' ),
                        'id'               => 'team_photo',
                        'max_file_uploads' => 1,
                    ],
                    [
                        'name' => esc_html__( 'Имя', 'asiaterm25' ),
                        'id'   => 'team_name',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Должность', 'asiaterm25' ),
                        'id'   => 'team_position',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'name' => esc_html__( 'HTML-код карты', 'asiaterm25' ),
                'id'   => 'about_map_embed',
                'type' => 'textarea',
                'rows' => 4,
                'desc' => esc_html__( 'Вставьте iframe карты (Google/Yandex/2GIS)', 'asiaterm25' ),
            ],
        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Услуги"', 'asiaterm25' ),
        'id'         => 'services_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-services.php'],
        ],
        'fields'     => [
            [
                'name'       => esc_html__( 'Список услуг', 'asiaterm25' ),
                'id'         => 'services_list',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить услугу', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name'        => esc_html__( 'Иконка (CSS-класс)', 'asiaterm25' ),
                        'id'          => 'service_icon',
                        'type'        => 'text',
                        'placeholder' => 'fas fa-building',
                    ],
                    [
                        'name' => esc_html__( 'Заголовок', 'asiaterm25' ),
                        'id'   => 'service_title',
                        'type' => 'text',
                    ],
                    [
                        'name'    => esc_html__( 'Описание', 'asiaterm25' ),
                        'id'      => 'service_desc',
                        'type'    => 'wysiwyg',
                        'options' => ['textarea_rows' => 6, 'media_buttons' => false],
                    ],
                    [
                        'name' => esc_html__( 'Ссылка', 'asiaterm25' ),
                        'id'   => 'service_link',
                        'type' => 'url',
                    ],
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Изображение', 'asiaterm25' ),
                        'id'               => 'service_image',
                        'max_file_uploads' => 1,
                    ],
                ],
            ],
        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Сертификаты"', 'asiaterm25' ),
        'id'         => 'cert_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-certificates.php'],
        ],
        'fields'     => [
            [
                'name'        => esc_html__( 'YouTube видео URL', 'asiaterm25' ),
                'id'          => 'cert_video_url',
                'type'        => 'url',
                'placeholder' => 'https://www.youtube.com/watch?v=...',
            ],
            [
                'name' => esc_html__( 'Заголовок секции', 'asiaterm25' ),
                'id'   => 'cert_heading',
                'type' => 'text',
            ],
            [
                'name'       => esc_html__( 'Кнопки', 'asiaterm25' ),
                'id'         => 'cert_buttons',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить кнопку', 'asiaterm25' ),
                'fields'     => [
                    [
                        'name' => esc_html__( 'Текст кнопки', 'asiaterm25' ),
                        'id'   => 'cert_btn_text',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Ссылка', 'asiaterm25' ),
                        'id'   => 'cert_btn_url',
                        'type' => 'url',
                    ],
                ],
            ],
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Галерея сертификатов', 'asiaterm25' ),
                'id'               => 'cert_gallery',
                'max_file_uploads' => 999,
            ],
        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Партнёрам"', 'asiaterm25' ),
        'id'         => 'partners_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-partners.php'],
        ],
        'fields'     => [
            [
                'name'    => esc_html__( 'Вступительный текст', 'asiaterm25' ),
                'id'      => 'partners_intro',
                'type'    => 'wysiwyg',
                'options' => ['textarea_rows' => 8, 'media_buttons' => true],
            ],
            [
                'name'       => esc_html__( 'Организации-партнёры (дилеры)', 'asiaterm25' ),
                'id'         => 'partners_brands',
                'type'       => 'group',
                'clone'      => true,
                'add_button' => esc_html__( '+ Добавить организацию', 'asiaterm25' ),
                'fields'     => [
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Логотип', 'asiaterm25' ),
                        'id'               => 'brand_logo',
                        'max_file_uploads' => 1,
                    ],
                    [
                        'name' => esc_html__( 'Название компании', 'asiaterm25' ),
                        'id'   => 'brand_name',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Краткое описание', 'asiaterm25' ),
                        'id'   => 'brand_desc',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                    [
                        'name'        => esc_html__( 'Тип продукции', 'asiaterm25' ),
                        'id'          => 'brand_product_type',
                        'type'        => 'text',
                        'placeholder' => 'Конвекторы, радиаторы, котлы',
                    ],
                    [
                        'name' => esc_html__( 'Адрес / Страна', 'asiaterm25' ),
                        'id'   => 'brand_address',
                        'type' => 'text',
                    ],
                    [
                        'name' => esc_html__( 'Сайт', 'asiaterm25' ),
                        'id'   => 'brand_website',
                        'type' => 'url',
                    ],
                    [
                        'type'             => 'image_advanced',
                        'name'             => esc_html__( 'Фото продукции', 'asiaterm25' ),
                        'id'               => 'brand_photo',
                        'max_file_uploads' => 1,
                    ],
                ],
            ],
            [
                'type'             => 'image_advanced',
                'name'             => esc_html__( 'Логотипы партнёров (карусель)', 'asiaterm25' ),
                'id'               => 'partners_logos',
                'max_file_uploads' => 20,
            ],
        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Контент страницы "Контакты"', 'asiaterm25' ),
        'id'         => 'contact_params',
        'post_types' => ['page'],
        'context'    => 'normal',
        'priority'   => 'high',
        'show'       => [
            'template' => ['page-contact.php'],
        ],
        'desc'       => esc_html__( 'Адрес, телефон, email — из Настройки → Общие → Контактная информация', 'asiaterm25' ),
        'fields'     => [
            [
                'name' => esc_html__( 'Режим работы', 'asiaterm25' ),
                'id'   => 'contact_work_hours',
                'type' => 'text',
                'placeholder' => 'Пн-Пт: 09:00 - 18:00',
            ],
            [
                'name' => esc_html__( 'HTML-код карты', 'asiaterm25' ),
                'id'   => 'contact_map_embed',
                'type' => 'textarea',
                'rows' => 4,
                'desc' => esc_html__( 'Вставьте iframe карты (Google/Yandex/2GIS)', 'asiaterm25' ),
            ],
            [
                'name'    => esc_html__( 'Дополнительная информация', 'asiaterm25' ),
                'id'      => 'contact_extra_info',
                'type'    => 'wysiwyg',
                'options' => ['textarea_rows' => 8, 'media_buttons' => true],
            ],
        ],
    ];

    $meta_boxes[] = [
        'title'      => esc_html__( 'Галерея проекта', 'asiaterm25' ),
        'id'         => 'portfolio_params',
        'post_types' => ['portfolio'],
        'context'    => 'normal',
        'priority'   => 'high',
        'fields'     => [
            [
                'name'             => esc_html__( 'Галерея', 'asiaterm25' ),
                'id'               => 'portfolio_gallery',
                'type'             => 'image_advanced',
                'max_file_uploads' => 20,
                'force_delete'     => false,
            ],
        ],
    ];

    return $meta_boxes;
}
