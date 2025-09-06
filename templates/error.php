<?php
/** @var int $code */
/** @var string $message */
http_response_code($code ?? 500);
?>
<section class="page">
  <div class="container">
    <h1>Error <?= (int)($code ?? 500) ?></h1>
    <p><?= htmlspecialchars($message ?? 'Unexpected error.') ?></p>
    <p><a class="btn" href="/?page=home">Wróć na stronę główną</a></p>
  </div>
</section>
