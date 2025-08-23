<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../index.php'; 


if (!csrf_verify() || !honeypot_ok()) {
  flash_add('error', 'Nieprawidłowa próba wysłania formularza.');
  redirect('/?page=contact');
}

$name = str_trimmed($_POST['name'] ?? '');
$email = str_trimmed($_POST['email'] ?? '');
$message = str_trimmed($_POST['message'] ?? '');

$errors = [];
if (!not_empty($name))   $errors[] = 'Podaj imię/nazwisko.';
if (!email_valid($email)) $errors[] = 'Podaj poprawny adres email.';
if (mb_strlen($message) < 5) $errors[] = 'Wiadomość jest zbyt krótka.';

if ($errors) {
  flash_add('error', implode(' ', $errors));
  redirect('/?page=contact');
}

$ok = jsonl_append(__DIR__ . '/../storage/contact_messages.jsonl', [
  'name' => $name,
  'email' => $email,
  'message' => $message,
  'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
  'ua' => $_SERVER['HTTP_USER_AGENT'] ?? null,
]);

flash_add($ok ? 'success' : 'error', $ok ? 'Dziękujemy! Wiadomość została wysłana.' : 'Nie udało się zapisać wiadomości.');
redirect('/?page=contact');
