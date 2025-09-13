<?php
declare(strict_types=1);

final class ContactRepo {
  public static function insert(string $name, string $email, string $message, ?string $ip, ?string $ua): bool {
    $sql = "INSERT INTO contact_messages (name, email, message, ip, ua)
            VALUES (:name, :email, :message, :ip, :ua)";
    return Db::pdo()->prepare($sql)->execute([
      ':name' => $name,
      ':email' => $email,
      ':message' => $message,
      ':ip' => $ip,
      ':ua' => $ua,
    ]);
  }
}
