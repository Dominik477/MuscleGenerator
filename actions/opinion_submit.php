<?php

if (!csrf_verify() || !honeypot_ok()) {
  flash_add('error', 'Nieprawidłowa próba wysłania formularza.');
  redirect('/?page=opinions');
}

$name    = str_trimmed($_POST['name']    ?? '');
$message = str_trimmed($_POST['message'] ?? '');

$errors = [];
if ($name === '') $errors[] = 'Podaj imię lub nick.';
$len = mb_strlen($message);
if ($len < 5)       $errors[] = 'Opinia jest zbyt krótka.';
elseif ($len > 1000)$errors[] = 'Opinia jest zbyt długa (max 1000 znaków).';

if ($errors) {
  flash_add('error', implode(' ', $errors));
  redirect('/?page=opinions');
}

$ip = $_SERVER['REMOTE_ADDR'] ?? null;
$ua = $_SERVER['HTTP_USER_AGENT'] ?? null;

$ok = false;
if (AppConfig::storageDriver() === 'db') {
  try {
    $ok = OpinionsRepo::insert($name, $message, $ip, $ua);
  } catch (Throwable $e) {
    flash_add('error', 'Błąd zapisu do bazy: ' . $e->getMessage());
    redirect('/?page=opinions');
  }
} else {
  $ok = jsonl_append(AppConfig::storageDir() . '/opinions.jsonl', [
    'name' => $name,
    'message' => $message,
    'ip' => $ip,
    'ua' => $ua,
  ]);
}

flash_add($ok ? 'success' : 'error', $ok ? 'Dziękujemy za opinię!' : 'Nie udało się zapisać opinii.');
redirect('/?page=opinions');
