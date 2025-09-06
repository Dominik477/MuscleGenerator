<?php
include_once __DIR__ . '/../templates/card.php';
$opinionsFile = AppConfig::storageDir() . '/opinions.jsonl';
$opinions = array_reverse(jsonl_read_all($opinionsFile));
?>

<section class="page">
  <div class="container">
   <h1>Opinie</h1>
    <p class="muted">Twoja opinia pomaga nam ustalić priorytety i robić lepsze narzędzia.</p>


    <div class="cards">
      <?php if (count($opinions) === 0): ?>
        <article class="card"><p>Brak opinii. Bądź pierwszy!</p></article>
      <?php else: ?>
        <?php foreach ($opinions as $op): ?>
          <article class="card">
            <h2><?= htmlspecialchars($op['name'] ?? 'Anonim') ?></h2>
            <div class="card-sub"><?= htmlspecialchars(substr($op['created_at'] ?? '', 0, 19)) ?></div>
            <div class="card-body"><p><?= nl2br(htmlspecialchars($op['message'] ?? '')) ?></p></div>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <h2 style="margin-top:24px;">Dodaj opinię</h2>
    <form class="form" method="post" action="/?action=opinion_submit&page=opinions">
      <?= csrf_field() ?>
      <div class="hp">
        <label>Website <input type="text" name="website" autocomplete="off"></label>
      </div>

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

      </div>
    </form>
  </div>
</section>
