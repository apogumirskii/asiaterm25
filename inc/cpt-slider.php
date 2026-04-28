<?php

function my_post_type_sliderims() {
    register_post_type( 'sliderims',
        array(
            'label'               => __('Слайдер', 'asiaterm25'),
            'public'              => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => false,
            'menu_position'       => 10,
            'exclude_from_search' => true,
            'menu_icon'           => 'dashicons-book-alt',
            'rewrite'             => array(
                'slug'       => 'sliderims',
                'with_front' => false,
            ),
            'supports' => array(
                'title',
                'thumbnail',
                'page-attributes'
            ),
        )
    );
}
add_action('init', 'my_post_type_sliderims');

function my_sliderims_fields() {
    add_meta_box(
        'sliderims_fields',
        'Мета слайдера',
        'sliderims_fields_box_func',
        'sliderims',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'my_sliderims_fields');

function sliderims_fields_box_func( $post ) {
    $sliderlink = get_post_meta($post->ID, 'sliderlink', true);
    ?>
    <p><label for="sliderhead"><?php esc_html_e( 'Заголовок', 'asiaterm25' ); ?></label>
    <input type="text" name="sliderims[sliderhead]" id="sliderhead" value="<?php echo esc_attr( get_post_meta($post->ID, 'sliderhead', true) ); ?>" style="width:50%" /></p>

    <p><label for="slidertext"><?php esc_html_e( 'Описание', 'asiaterm25' ); ?></label>
    <input type="text" name="sliderims[slidertext]" id="slidertext" value="<?php echo esc_attr( get_post_meta($post->ID, 'slidertext', true) ); ?>" style="width:50%" /></p>

    <p><label for="sliderlink"><?php esc_html_e( 'Ссылка слайда', 'asiaterm25' ); ?></label>
    <select name="sliderims[sliderlink]" id="sliderlink">
        <option value=""><?php esc_html_e( 'Выберите страницу или запись', 'asiaterm25' ); ?></option>
        <?php
        $args = array('post_type' => array( 'post', 'page' ), 'posts_per_page' => -1, 'post_status' => 'publish');
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                echo '<option value="' . get_the_ID() . '" ' . selected( $sliderlink, get_the_ID(), false ) . '>' . get_the_title() . '</option>';
            endwhile;
        endif; wp_reset_postdata();
        ?>
    </select></p>

    <p><label for="sliderbtntext"><?php esc_html_e( 'Текст на кнопке', 'asiaterm25' ); ?></label>
    <input type="text" name="sliderims[sliderbtntext]" id="sliderbtntext" value="<?php echo esc_attr( get_post_meta($post->ID, 'sliderbtntext', true) ); ?>" style="width:50%" /></p>

    <p><label for="sliderfile"><?php esc_html_e( 'Файл слайдера (видео/фото)', 'asiaterm25' ); ?></label><br>
    <input type="hidden" id="sliderfile" name="sliderims[sliderfile]" value="<?php echo esc_attr( get_post_meta($post->ID, 'sliderfile', true) ); ?>" />
    <button class="button upload_slider_file"><?php esc_html_e( 'Выбрать файл', 'asiaterm25' ); ?></button>
    <div id="sliderfile-preview">
        <?php $file_id = get_post_meta($post->ID, 'sliderfile', true);
        if( $file_id ): $file = wp_get_attachment_url($file_id); ?>
            <p><strong><?php echo basename($file); ?></strong>
            <a href="<?php echo esc_url($file); ?>" target="_blank"><?php esc_html_e( 'Смотреть', 'asiaterm25' ); ?></a> |
            <button type="button" class="button remove_slider_file"><?php esc_html_e( 'Удалить', 'asiaterm25' ); ?></button></p>
        <?php endif; ?>
    </div>

    <input type="hidden" name="sliderims_fields_nonce" value="<?php echo wp_create_nonce('sliderims_save'); ?>" />

    <script>
    jQuery(document).ready(function($) {
        $('.upload_slider_file').click(function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: '<?php esc_html_e( "Выберите файл слайдера", "asiaterm25" ); ?>',
                button: { text: '<?php esc_html_e( "Использовать файл", "asiaterm25" ); ?>' },
                multiple: false,
                library: { type: 'video,image' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#sliderfile').val(attachment.id);
                $('#sliderfile-preview').html('<p><strong>' + attachment.filename + '</strong> <a href="' + attachment.url + '" target="_blank"><?php esc_html_e( "Смотреть", "asiaterm25" ); ?></a> | <button type="button" class="button remove_slider_file"><?php esc_html_e( "Удалить", "asiaterm25" ); ?></button></p>');
            });
            frame.open();
        });
        $(document).on('click', '.remove_slider_file', function() {
            $('#sliderfile').val(''); $('#sliderfile-preview').html('');
        });
    });
    </script>
    <?php
}

function my_sliderims_fields_update( $post_id ){
    if ( empty( $_POST['sliderims'] )
    || ! wp_verify_nonce( $_POST['sliderims_fields_nonce'], 'sliderims_save' )
    || wp_is_post_autosave( $post_id )
    || wp_is_post_revision( $post_id ) )
        return false;

    $_POST['sliderims'] = array_map( 'sanitize_text_field', $_POST['sliderims'] );

    foreach( $_POST['sliderims'] as $key => $value ){
        if( empty($value) ){
            delete_post_meta( $post_id, $key );
            continue;
        }
        update_post_meta( $post_id, $key, $value );
    }

    return $post_id;
}
add_action( 'save_post', 'my_sliderims_fields_update', 0 );
