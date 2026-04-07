jQuery(document).ready(function($) {
    // Обработчик кнопки "Выбрать изображение"
    $('.upload_image_button').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var input = $('#prod_category_thumbnail');
        var preview = $('#prod_category_thumbnail_preview');
        var removeButton = $('.remove_image_button');
        
        // Создаем медиа-фрейм
        var frame = wp.media({
            title: prodCategoryL10n.title,
            button: {
                text: prodCategoryL10n.button
            },
            multiple: false
        });
        
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            input.val(attachment.id);
            preview.attr('src', attachment.url).show();
            removeButton.show();
        });
        
        frame.open();
    });
    
    // Обработчик кнопки "Удалить"
    $('.remove_image_button').on('click', function(e) {
        e.preventDefault();
        
        $('#prod_category_thumbnail').val('');
        $('#prod_category_thumbnail_preview').hide();
        $(this).hide();
    });
});