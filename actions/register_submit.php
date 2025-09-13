<?php

if (!auth_logged()) {
  flash_add('error', 'Zaloguj się, aby wysłać wiadomość.');
  redirect('/?page=login&return=contact');
}

if (!csrf_verify() || !honeypot_ok()) {
  flash_add('error', 'Nieprawidłowe żądanie.');
  redirect('/?page=register');
}

$email = str_trimmed($_POST['email'] ?? '');
$pass1 = (string)($_POST['password']  ?? '');
$pass2 = (string)($_POST['password2'] ?? '');

$errors = [];
if ($email === '' || !email_valid($email)) {
  $errors[] = 'Podaj poprawny adres email.';
}
if (mb_strlen($pass1) < 8) {
  $errors[] = 'Hasło musi mieć min. 8 znaków.';
}
if ($pass1 !== $pass2) {
  $errors[] = 'Hasła nie są takie same.';
}

if ($errors) {
  flash_add('error', implode(' ', $errors));
  redirect('/?page=register');
}

try {
  $exists = UsersRepo::findByEmail($email);
  if ($exists) {
    flash_add('error', 'Konto z tym adresem email już istnieje.');
    redirect('/?page=register');
  }

  $id = UsersRepo::create($email, $pass1, 'user');

  auth_login($id, 'user', $email);
  flash_add('success', 'Konto zostało utworzone. Zalogowano.');
  redirect('/?page=home');

} catch (Throwable $e) {
  flash_add('error', 'Błąd rejestracji: ' . $e->getMessage());
  redirect('/?page=register');
}
