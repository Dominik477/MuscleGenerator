<?php
declare(strict_types=1);

final class UsersRepo {
  public static function findByEmail(string $email): ?array {
    $st = Db::pdo()->prepare("SELECT id, email, password_hash, role FROM users WHERE email = :email LIMIT 1");
    $st->execute([':email' => $email]);
    $row = $st->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
  }

  public static function create(string $email, string $password, string $role = 'user'): int {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $st = Db::pdo()->prepare("INSERT INTO users (email, password_hash, role) VALUES (:email, :ph, :role) RETURNING id");
    $st->execute([':email' => $email, ':ph' => $hash, ':role' => $role]);
    return (int)$st->fetchColumn();
  }

  public static function findById(int $id): ?array {
  $st = Db::pdo()->prepare("SELECT id, email, role FROM users WHERE id = :id LIMIT 1");
  $st->execute([':id' => $id]);
  $row = $st->fetch(PDO::FETCH_ASSOC);
  return $row ?: null;
}

}
