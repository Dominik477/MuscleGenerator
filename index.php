<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/lib/config.php';
require_once __DIR__ . '/lib/helpers.php';

/* --- Front controller: akcje POST --- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';
    switch ($action) {
        case 'opinion_submit':
            require __DIR__ . '/actions/opinion_submit.php';
            exit;
        case 'contact_submit':
            require __DIR__ . '/actions/contact_submit.php';
            exit;
        default:
            flash_add('error', 'Nieznana akcja formularza.');
            redirect('/?page=home');
    }
}

/* --- Routing GET --- */
$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home','diet-wiki','training-programs','muscle-wiki','about-us','contact','opinions'];

$error = null;
if (!in_array($page, $allowed_pages, true)) {
    $error = ['code' => 404, 'message' => 'Strona nie została znaleziona.'];
    $page = null; // ważne: nie będziemy includować widoku
}

/* --- Helpery --- */
function is_active(string $p, ?string $cur): string {
    return $p === $cur ? 'active' : '';
}

/* --- Manualne testowe flashy z URL (opcjonalne) --- */
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
  <!-- Zostawiam Twoją ścieżkę do CSS; upewnij się, że plik istnieje -->
  <link rel="stylesheet" href="/assets/styles/style.css">
</head>
<body>
  <?php include __DIR__ . '/templates/header.php'; ?>

  <main class="container">
    <?php
      // breadcrumb tylko gdy NIE ma 404
      if (!$error) {
          include __DIR__ . '/templates/breadcrumb.php';
      }

      // flash messages
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

    <?php
      // >>> JEDYNE miejsce renderu treści <<<
      if ($error) {
          $code = $error['code']; $message = $error['message'];
          include __DIR__ . '/templates/error.php';
      } else {
          include __DIR__ . "/pages/{$page}.php";
      }
    ?>
  </main>

  <?php include __DIR__ . '/templates/footer.php'; ?>
  <script src="/assets/js/app.js"></script>
</body>
</html>
