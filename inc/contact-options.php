<?php

function register_custom_settings_section() {
    add_settings_section(
        'custom_contact_section',
        'Контактная информация',
        null,
        'general'
    );
}
add_action('admin_init', 'register_custom_settings_section');

function my_mymail() {
    add_settings_field( 'mymail', 'EMAIL', 'callback_mymail', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_mymail', 'sanitize_email' );
}

function my_instagramm() {
    add_settings_field( 'instagramm', 'INSTAGRAMM link', 'callback_instagramm', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_instagramm', 'esc_url_raw' );
}

function my_facebook() {
    add_settings_field( 'facebook', 'Facebook link', 'callback_facebook', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_facebook', 'esc_url_raw' );
}

function my_youtube() {
    add_settings_field( 'youtube', 'Youtube link', 'callback_youtube', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_youtube', 'esc_url_raw' );
}

function my_adress() {
    add_settings_field( 'adress', 'adress text', 'callback_adress', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_adress', 'sanitize_text_field' );
}

function my_phone() {
    add_settings_field( 'phone', 'Телефон', 'callback_phone', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_phone', 'sanitize_text_field' );
}

function my_phone2() {
    add_settings_field( 'phone2', 'Доп. телефон', 'callback_phone2', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_phone2', 'sanitize_text_field' );
}

function my_whatsapp() {
    add_settings_field( 'whatsapp', 'WhatsApp номер', 'callback_whatsapp', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_whatsapp', 'sanitize_text_field' );
}

function my_telegram() {
    add_settings_field( 'telegram', 'Telegram ссылка', 'callback_telegram', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_telegram', 'esc_url_raw' );
}

function my_2gis() {
    add_settings_field( '2gis', '2GIS ссылка', 'callback_2gis', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_2gis', 'esc_url_raw' );
}

function my_work_hours() {
    add_settings_field( 'work_hours', 'Режим работы', 'callback_work_hours', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_work_hours', 'sanitize_text_field' );
}

function my_geo_lat() {
    add_settings_field( 'geo_lat', 'Широта (Latitude)', 'callback_geo_lat', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_geo_lat', 'sanitize_text_field' );
}

function my_geo_lng() {
    add_settings_field( 'geo_lng', 'Долгота (Longitude)', 'callback_geo_lng', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_geo_lng', 'sanitize_text_field' );
}

function my_yandex_verification() {
    add_settings_field( 'yandex_verification', 'Яндекс.Вебмастер verification', 'callback_yandex_verification', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_yandex_verification', 'sanitize_text_field' );
}

function my_google_verification() {
    add_settings_field( 'google_verification', 'Google Search Console verification', 'callback_google_verification', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_google_verification', 'sanitize_text_field' );
}

function my_oferta_page_id() {
    add_settings_field( 'oferta_page_id', 'ID страницы «Оферта и условия»', 'callback_oferta_page_id', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_oferta_page_id', 'absint' );
}

function my_faq_page_id() {
    add_settings_field( 'faq_page_id', 'ID страницы FAQ', 'callback_faq_page_id', 'general', 'custom_contact_section' );
    register_setting( 'general', 'my_faq_page_id', 'absint' );
}

add_action('admin_init', 'my_mymail');
add_action('admin_init', 'my_instagramm');
add_action('admin_init', 'my_facebook');
add_action('admin_init', 'my_youtube');
add_action('admin_init', 'my_adress');
add_action('admin_init', 'my_phone');
add_action('admin_init', 'my_phone2');
add_action('admin_init', 'my_whatsapp');
add_action('admin_init', 'my_telegram');
add_action('admin_init', 'my_2gis');
add_action('admin_init', 'my_work_hours');
add_action('admin_init', 'my_geo_lat');
add_action('admin_init', 'my_geo_lng');
add_action('admin_init', 'my_yandex_verification');
add_action('admin_init', 'my_google_verification');
add_action('admin_init', 'my_oferta_page_id');
add_action('admin_init', 'my_faq_page_id');

function callback_mymail() {
    echo "<input class='regular-text' type='text' name='my_mymail' value='" . esc_attr(get_option('my_mymail')) . "'>";
}
function callback_instagramm() {
    echo "<input class='regular-text' type='text' name='my_instagramm' value='" . esc_attr(get_option('my_instagramm')) . "'>";
}
function callback_facebook() {
    echo "<input class='regular-text' type='text' name='my_facebook' value='" . esc_attr(get_option('my_facebook')) . "'>";
}
function callback_youtube() {
    echo "<input class='regular-text' type='text' name='my_youtube' value='" . esc_attr(get_option('my_youtube')) . "'>";
}
function callback_adress() {
    echo "<input class='regular-text' type='text' name='my_adress' value='" . esc_attr(get_option('my_adress')) . "'>";
}
function callback_phone() {
    echo "<input class='regular-text' type='text' name='my_phone' value='" . esc_attr(get_option('my_phone')) . "'>";
}
function callback_phone2() {
    echo "<input class='regular-text' type='text' name='my_phone2' value='" . esc_attr(get_option('my_phone2')) . "' placeholder='+996 XXX XXX XXX'>";
}
function callback_whatsapp() {
    echo "<input class='regular-text' type='text' name='my_whatsapp' value='" . esc_attr(get_option('my_whatsapp')) . "' placeholder='+996XXXXXXXXX (без пробелов)'>";
}
function callback_telegram() {
    echo "<input class='regular-text' type='text' name='my_telegram' value='" . esc_attr(get_option('my_telegram')) . "' placeholder='https://t.me/username'>";
}
function callback_2gis() {
    echo "<input class='regular-text' type='text' name='my_2gis' value='" . esc_attr(get_option('my_2gis')) . "' placeholder='https://2gis.kg/bishkek/...'>";
}
function callback_work_hours() {
    echo "<input class='regular-text' type='text' name='my_work_hours' value='" . esc_attr(get_option('my_work_hours')) . "' placeholder='Пн-Пт: 9:00-18:00, Сб: 10:00-15:00'>";
}
function callback_geo_lat() {
    echo "<input class='regular-text' type='text' name='my_geo_lat' value='" . esc_attr(get_option('my_geo_lat')) . "' placeholder='42.8746'>";
}
function callback_geo_lng() {
    echo "<input class='regular-text' type='text' name='my_geo_lng' value='" . esc_attr(get_option('my_geo_lng')) . "' placeholder='74.5698'>";
}
function callback_yandex_verification() {
    echo "<input class='regular-text' type='text' name='my_yandex_verification' value='" . esc_attr(get_option('my_yandex_verification')) . "' placeholder='1a2b3c4d5e6f7g8h'>";
}
function callback_google_verification() {
    echo "<input class='regular-text' type='text' name='my_google_verification' value='" . esc_attr(get_option('my_google_verification')) . "' placeholder='XXXXXXXXXXXXXXXXXXXXXXXX'>";
}
function callback_oferta_page_id() {
    echo "<input class='small-text' type='number' name='my_oferta_page_id' value='" . esc_attr(get_option('my_oferta_page_id')) . "' placeholder='42'> <span style='color:#666; font-size:12px;'>ID страницы оферты (Страницы → Все → видно в URL ?post=ID)</span>";
}
function callback_faq_page_id() {
    echo "<input class='small-text' type='number' name='my_faq_page_id' value='" . esc_attr(get_option('my_faq_page_id')) . "' placeholder='43'> <span style='color:#666; font-size:12px;'>ID страницы FAQ</span>";
}
