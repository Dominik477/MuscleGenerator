<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/lib/helpers.php';

$page = $_GET['page'] ?? 'home';

$allowed_pages = ['home', 'diet-wiki', 'training-programs', 'muscle-wiki', 'about-us', 'contact', 'opinions'];
if (!in_array($page, $allowed_pages, true)) {
    $page = 'home';
}

function is_active(string $p, string $cur): string {
    return $p === $cur ? 'active' : '';
}

function flash_add(string $type, string $message): void {
    $_SESSION['__flash'][] = ['type' => $type, 'message' => $message];
}
function flash_get_all(): array {
    $msgs = $_SESSION['__flash'] ?? [];
    unset($_SESSION['__flash']);
    return $msgs;
}

if (isset($_GET['flash'], $_GET['msg'])) {
    $type = $_GET['flash'] === 'ok' ? 'success' : 'error';
    flash_add($type, (string)$_GET['msg']);
}
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <title>Muscle Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/styles/style.css">
</head>
<body>
  <?php include __DIR__ . '/templates/header.php'; ?>

  <main class="container">
    <?php
      include __DIR__ . '/templates/breadcrumb.php';

      $flashes = flash_get_all();
      if (!empty($flashes)): ?>
        <div class="flash-stack" id="flash-stack">
          <?php foreach ($flashes as $f): ?>
            <div class="flash <?= htmlspecialchars($f['type']) ?>">
              <?= htmlspecialchars($f['message']) ?>
            </div>
          <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php include __DIR__ . "/pages/{$page}.php"; ?>
  </main>

  <?php include __DIR__ . '/templates/footer.php'; ?>
  <script src="/assets/js/app.js"></script>
</body>
</html>
