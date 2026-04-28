<?php

function asiaterm_partner_form_send() {
    check_ajax_referer('partner_form_nonce', 'nonce');

    $company  = sanitize_text_field($_POST['company'] ?? '');
    $contact  = sanitize_text_field($_POST['contact_person'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');
    $phone    = sanitize_text_field($_POST['phone'] ?? '');
    $message  = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($company) || empty($contact) || (empty($email) && empty($phone))) {
        wp_send_json_error(['message' => 'Заполните обязательные поля']);
    }

    $to = get_option('my_mymail');
    if (!$to) {
        wp_send_json_error(['message' => 'Email получателя не настроен']);
    }

    $subject = 'Запрос от партнёра: ' . $company;
    $body  = "Организация: {$company}\n";
    $body .= "Контактное лицо: {$contact}\n";
    if ($email) $body .= "Email: {$email}\n";
    if ($phone) $body .= "Телефон: {$phone}\n";
    $body .= "\nСообщение:\n{$message}";

    $headers = ['Content-Type: text/plain; charset=UTF-8'];
    if ($email) {
        $headers[] = 'Reply-To: ' . $email;
    }

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Запрос успешно отправлен']);
    } else {
        wp_send_json_error(['message' => 'Ошибка при отправке']);
    }
}
add_action('wp_ajax_partner_form_send', 'asiaterm_partner_form_send');
add_action('wp_ajax_nopriv_partner_form_send', 'asiaterm_partner_form_send');
