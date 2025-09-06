<?php

if (!csrf_verify() || !honeypot_ok()) {
  flash_add('error', 'Nieprawidłowa próba wysłania formularza.');
  redirect('/?page=contact');
}

$name    = str_trimmed($_POST['name']    ?? '');
$email   = str_trimmed($_POST['email']   ?? '');
$message = str_trimmed($_POST['message'] ?? '');

$errors = [];
if ($name === '') {
  $errors[] = 'Podaj imię i nazwisko.';
}
if (!email_valid($email)) {
  $errors[] = 'Podaj poprawny adres email.';
}
$len = mb_strlen($message);
if ($len < 5) {
  $errors[] = 'Wiadomość jest zbyt krótka.';
} elseif ($len > 2000) {
  $errors[] = 'Wiadomość jest zbyt długa (max 2000 znaków).';
}

if ($errors) {
  flash_add('error', implode(' ', $errors));
  redirect('/?page=contact');
}

$ok = jsonl_append(AppConfig::storageDir() . '/contact_messages.jsonl', [
  'name'    => $name,
  'email'   => $email,
  'message' => $message,
  'ip'      => $_SERVER['REMOTE_ADDR']      ?? null,
  'ua'      => $_SERVER['HTTP_USER_AGENT']  ?? null,
]);

flash_add($ok ? 'success' : 'error', $ok ? 'Dziękujemy! Wiadomość została wysłana.' : 'Nie udało się zapisać wiadomości.');
redirect('/?page=contact');
