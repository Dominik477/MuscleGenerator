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
}
