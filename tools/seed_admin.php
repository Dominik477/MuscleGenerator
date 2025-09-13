<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/config.php';
require_once __DIR__ . '/../lib/Db.php';
require_once __DIR__ . '/../lib/UsersRepo.php';

$secret = AppConfig::env('MIGRATE_SECRET', 'dev'); 
if (($_GET['secret'] ?? '') !== $secret) { http_response_code(403); echo 'Forbidden'; exit; }

$email = AppConfig::env('ADMIN_EMAIL', 'admin@example.com');
$pass  = AppConfig::env('ADMIN_PASS', 'admin');

try {
  $exists = UsersRepo::findByEmail($email);
  if ($exists) { echo "User already exists: $email\n"; exit; }
  $id = UsersRepo::create($email, $pass, 'admin');
  echo "OK: admin created #$id ($email)\n";
} catch (Throwable $e) {
  http_response_code(500);
  echo "ERROR: " . $e->getMessage();
}
