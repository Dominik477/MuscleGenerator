<?php
if (!function_exists('render_card')) {
  function render_card(string $title, ?string $subtitle, string $bodyHtml): void { ?>
    <article class="card">
      <h2><?= htmlspecialchars($title) ?></h2>
      <?php if ($subtitle): ?><div class="card-sub"><?= htmlspecialchars($subtitle) ?></div><?php endif; ?>
      <div class="card-body"><?= $bodyHtml ?></div>
    </article>
  <?php }
}
