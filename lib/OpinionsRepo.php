<?php
declare(strict_types=1);

final class OpinionsRepo {
  public static function insert(string $name, string $message, ?string $ip, ?string $ua): bool {
    $sql = "INSERT INTO opinions (name, message, ip, ua) VALUES (:name, :message, :ip, :ua)";
    return Db::pdo()->prepare($sql)->execute([
      ':name' => $name,
      ':message' => $message,
      ':ip' => $ip,
      ':ua' => $ua,
    ]);
  }

  public static function countAll(): int {
    $q = Db::pdo()->query("SELECT COUNT(*) FROM opinions");
    return (int)$q->fetchColumn();
  }

  /** @return array<int, array<string, mixed>> */
  public static function listPaged(int $limit, int $offset): array {
    $sql = "SELECT id, name, message, created_at
            FROM opinions
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset";
    $st = Db::pdo()->prepare($sql);
    $st->bindValue(':limit', $limit, PDO::PARAM_INT);
    $st->bindValue(':offset', $offset, PDO::PARAM_INT);
    $st->execute();
    return $st->fetchAll();
  }
}
