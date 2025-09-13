<?php
declare(strict_types=1);

final class Db {
  private static ?PDO $pdo = null;

  public static function pdo(): PDO {
    if (self::$pdo === null) {
      self::$pdo = new PDO(
        AppConfig::pdoDsn(),
        AppConfig::dbUser(),
        AppConfig::dbPass(),
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
      );
    }
    return self::$pdo;
  }
}
