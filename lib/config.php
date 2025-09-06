<?php
declare(strict_types=1);


final class AppConfig {
  public static function env(string $key, ?string $default = null): ?string {
    $v = getenv($key);
    if ($v !== false) return $v;
    return $_ENV[$key] ?? $default;
  }

  public static function isDev(): bool {
    return (self::env('APP_ENV', 'dev') === 'dev');
  }

  public static function storageDir(): string {
    return rtrim(self::env('STORAGE_DIR', __DIR__ . '/../storage'), '/');
  }

  public static function storageDriver(): string {
    return self::env('STORAGE_DRIVER', 'file'); 
  }

  public static function pdoDsn(): string {
    $host = self::env('DB_HOST', 'postgres');
    $port = self::env('DB_PORT', '5432');
    $db   = self::env('DB_NAME', 'musclegenerator');
    return "pgsql:host={$host};port={$port};dbname={$db}";
  }
  public static function dbUser(): string { return self::env('DB_USER', 'postgres'); }
  public static function dbPass(): string { return self::env('DB_PASS', 'postgres'); }
}

