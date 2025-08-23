<?php
/**
 * render_card(string $title, ?string $subtitle, string $bodyHtml)
 * Użycie:
 *   include __DIR__.'/../templates/card.php';
 *   render_card('Tytuł', 'opcjonalny podtytuł', '<p>Treść</p>');
 */
if (!function_exists('render_card')) {
  function render_card(string $title, ?string $subtitle, string $bodyHtml): void { ?>
    <article class="card">
      <h2><?= htmlspecialchars($title) ?></h2>
      <?php if ($subtitle): ?><div class="card-sub"><?= htmlspecialchars($subtitle) ?></div><?php endif; ?>
      <div class="card-body"><?= $bodyHtml ?></div>
    </article>
  <?php }
}
