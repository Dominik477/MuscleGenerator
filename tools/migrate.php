<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/config.php';

$secret = AppConfig::env('MIGRATE_SECRET', 'dev');
if (($_GET['secret'] ?? '') !== $secret) {
  http_response_code(403);
  echo "Forbidden";
  exit;
}

try {
  $pdo = new PDO(
    AppConfig::pdoDsn(),
    AppConfig::dbUser(),
    AppConfig::dbPass(),
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  );
} catch (Throwable $e) {
  http_response_code(500);
  echo "DB CONNECT ERROR: " . $e->getMessage();
  exit;
}

$dir = realpath(__DIR__ . '/../migrations');
if ($dir === false || !is_dir($dir)) {
  http_response_code(500);
  echo "MIGRATIONS DIR MISSING: " . (__DIR__ . '/../migrations');
  exit;
}

$files = glob($dir . '/*.sql');
sort($files, SORT_NATURAL);

if (!$files) {
  http_response_code(500);
  echo "NO .sql FILES IN: $dir";
  exit;
}

try {
  $pdo->beginTransaction();
  foreach ($files as $path) {
    $sql = file_get_contents($path);
    if ($sql === false) {
      throw new RuntimeException("Cannot read file: $path");
    }
    $pdo->exec($sql);
  }
  $pdo->commit();
  echo "OK: applied " . count($files) . " migration file(s).";
} catch (Throwable $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  http_response_code(500);
  echo "MIGRATION ERROR: " . $e->getMessage();
}
