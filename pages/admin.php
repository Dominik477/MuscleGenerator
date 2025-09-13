<?php
declare(strict_types=1);
require_role('admin');

$pdo = Db::pdo();

$stats = [
  'opinions' => (int)$pdo->query("SELECT COUNT(*) FROM opinions")->fetchColumn(),
  'contacts' => (int)$pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn(),
  'users'    => (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
];

$daily = [];
try {
  $dailyStmt = $pdo->query("
    SELECT day, opinions_count
    FROM opinions_last30_mv
    ORDER BY day ASC
  ");
  $daily = $dailyStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
  $dailyStmt = $pdo->query("
    SELECT day, opinions_count
    FROM opinions_daily_stats_v
    ORDER BY day ASC
    LIMIT 30
  ");
  $daily = $dailyStmt->fetchAll(PDO::FETCH_ASSOC);
}

$pageNo = max(1, (int)($_GET['p'] ?? 1));
$perPage = 10;
$offset  = ($pageNo - 1) * $perPage;

$totalOpinions = (int)$pdo->query("SELECT COUNT(*) FROM public_opinions_v")->fetchColumn();

$opinions = $pdo->prepare("
  SELECT id, author, message, created_at
  FROM public_opinions_v
  ORDER BY created_at DESC
  LIMIT :limit OFFSET :offset
");
$opinions->bindValue(':limit',  $perPage, PDO::PARAM_INT);
$opinions->bindValue(':offset', $offset,  PDO::PARAM_INT);
$opinions->execute();
$opinions = $opinions->fetchAll(PDO::FETCH_ASSOC);

$totalPages = max(1, (int)ceil($totalOpinions / $perPage));

$contacts = $pdo->query("
  SELECT id, name, email, message, created_at
  FROM contact_messages
  ORDER BY created_at DESC
  LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

$short = function (string $txt, int $len = 120): string {
  $t = trim($txt);
  return mb_strlen($t) > $len ? (mb_substr($t, 0, $len - 1) . '…') : $t;
};
?>
<section class="page">
  <div class="container">
    <h1>Panel administracyjny</h1>
    <p class="muted">Podgląd danych z widoków SQL i szybkie statystyki.</p>

    <div class="cards" style="margin-top:12px;">
      <article class="card">
        <h2>Opinie</h2>
        <p style="font-size:24px; margin:4px 0 0;"><?= (int)$stats['opinions'] ?></p>
      </article>
      <article class="card">
        <h2>Wiadomości</h2>
        <p style="font-size:24px; margin:4px 0 0;"><?= (int)$stats['contacts'] ?></p>
      </article>
      <article class="card">
        <h2>Użytkownicy</h2>
        <p style="font-size:24px; margin:4px 0 0;"><?= (int)$stats['users'] ?></p>
      </article>
      <article class="card">
        <h2>Statystyki</h2>
        <p class="muted" style="margin:0 0 8px;">Opinie – ostatnie 30 dni</p>
        <?php if ($daily): ?>
          <div class="admin-sparkline">
            <?php foreach ($daily as $row): $v = (int)$row['opinions_count']; ?>
              <span title="<?= htmlspecialchars($row['day'] . ' = ' . $v) ?>" style="height:<?= max(2, min(40, $v * 4)) ?>px"></span>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="muted">Brak danych.</p>
        <?php endif; ?>
      </article>
    </div>

    <h2 style="margin-top:24px;">Ostatnie opinie</h2>
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Autor</th>
            <th>Utworzono</th>
            <th>Treść (skrót)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$opinions): ?>
            <tr><td colspan="4" class="muted">Brak opinii.</td></tr>
          <?php else: foreach ($opinions as $op): ?>
            <tr>
              <td>#<?= (int)$op['id'] ?></td>
              <td><?= htmlspecialchars((string)$op['author']) ?></td>
              <td><?= htmlspecialchars(substr((string)$op['created_at'],0,19)) ?></td>
              <td><?= htmlspecialchars($short((string)$op['message'])) ?></td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <?php if ($totalPages > 1): ?>
      <nav class="pagination" aria-label="Opinions admin pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <?php if ($i === $pageNo): ?>
            <span class="page current"><?= $i ?></span>
          <?php else: ?>
            <a class="page" href="/?page=admin&p=<?= $i ?>"><?= $i ?></a>
          <?php endif; ?>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>

    <h2 style="margin-top:24px;">Ostatnie wiadomości kontaktowe</h2>
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nadawca</th>
            <th>Email</th>
            <th>Utworzono</th>
            <th>Treść (skrót)</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$contacts): ?>
          <tr><td colspan="5" class="muted">Brak wiadomości.</td></tr>
        <?php else: foreach ($contacts as $c): ?>
          <tr>
            <td>#<?= (int)$c['id'] ?></td>
            <td><?= htmlspecialchars((string)$c['name']) ?></td>
            <td><?= htmlspecialchars((string)$c['email']) ?></td>
            <td><?= htmlspecialchars(substr((string)$c['created_at'],0,19)) ?></td>
            <td><?= htmlspecialchars($short((string)$c['message'])) ?></td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
