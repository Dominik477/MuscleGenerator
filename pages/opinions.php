<?php
include_once __DIR__ . '/../templates/card.php';

$useDb  = (AppConfig::storageDriver() === 'db');
$pageNo = max(1, (int)($_GET['p'] ?? 1));
$perPage = 6;
$offset  = ($pageNo - 1) * $perPage;

if ($useDb) {
  try {
    $total    = OpinionsRepo::countAll();
    $opinions = OpinionsRepo::listPaged($perPage, $offset);
  } catch (Throwable $e) {
    flash_add('error', 'Błąd odczytu z bazy: ' . $e->getMessage());
    $useDb = false;
  }
}
if (!$useDb) {
  $file = AppConfig::storageDir() . '/opinions.jsonl';
  $all = array_reverse(jsonl_read_all($file));
  $total = count($all);
  $opinions = array_slice($all, $offset, $perPage);
}

$totalPages = max(1, (int)ceil($total / $perPage));
?>
<section class="page">
  <div class="container">
    <h1>Opinie</h1>
    <p class="muted">Twoja opinia pomaga nam ustalać priorytety i ulepszać narzędzia.</p>

    <div class="cards">
      <?php if (empty($opinions)): ?>
        <article class="card"><p>Brak opinii. Bądź pierwszy!</p></article>
      <?php else: foreach ($opinions as $op): ?>
        <article class="card">
          <h2><?= htmlspecialchars($op['name'] ?? 'Anonim') ?></h2>
          <div class="card-sub">
            <?= htmlspecialchars(substr((string)($op['created_at'] ?? ''), 0, 19)) ?>
          </div>
          <div class="card-body">
            <p><?= nl2br(htmlspecialchars($op['message'] ?? '')) ?></p>
          </div>
        </article>
      <?php endforeach; endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <nav class="pagination" aria-label="Opinions pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <?php if ($i === $pageNo): ?>
            <span class="page current"><?= $i ?></span>
          <?php else: ?>
            <a class="page" href="/?page=opinions&p=<?= $i ?>"><?= $i ?></a>
          <?php endif; ?>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>

    <h2 style="margin-top:24px;">Dodaj opinię</h2>
    <form class="form" method="post" action="/?action=opinion_submit&page=opinions" novalidate>
      <?= csrf_field() ?>
      <div class="hp"><label>Website <input type="text" name="website" autocomplete="off"></label></div>

      <div class="form-row">
        <label>Imię / Nick
          <input type="text" name="name" required>
        </label>
      </div>
      <div class="form-row">
        <label>Twoja opinia
          <textarea name="message" rows="4" required minlength="5" maxlength="1000"></textarea>
        </label>
      </div>
      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Wyślij opinię</button>
        <span class="muted">Dziękujemy! 👋</span>
      </div>
    </form>
  </div>
</section>
