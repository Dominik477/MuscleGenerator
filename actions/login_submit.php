<?php
declare(strict_types=1);


if (!csrf_verify() || !honeypot_ok()) {
  flash_add('error', 'Nieprawidłowe żądanie.');
  redirect('/?page=login');
}

$email = str_trimmed($_POST['email'] ?? '');
$pass  = (string)($_POST['password'] ?? '');

if ($email === '' || $pass === '') {
  flash_add('error', 'Podaj email i hasło.');
  redirect('/?page=login');
}

try {
  $user = UsersRepo::findByEmail($email);
  if (!$user || !password_verify($pass, $user['password_hash'])) {
    flash_add('error', 'Nieprawidłowy email lub hasło.');
    redirect('/?page=login');
  }

  session_regenerate_id(true);

  auth_login((int)$user['id'], (string)$user['role'], (string)$user['email']);
  flash_add('success', 'Zalogowano pomyślnie.');

  $allowedReturn = ['home','opinions','contact','about-us','diet-wiki','training-programs','muscle-wiki','admin'];
  $ret = (string)($_POST['__return'] ?? $_GET['return'] ?? '');
  if ($ret && in_array($ret, $allowedReturn, true)) {
    if ($ret === 'admin' && (string)$user['role'] !== 'admin') {
      redirect('/?page=home');
    }
    redirect('/?page=' . $ret);
  }

  redirect(((string)$user['role'] === 'admin') ? '/?page=admin' : '/?page=home');

} catch (Throwable $e) {
  flash_add('error', 'Błąd logowania: ' . $e->getMessage());
  redirect('/?page=login');
}
