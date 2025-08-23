<?php
$page = $_GET['page'] ?? 'home';

$allowed_pages = ['home', 'diet-wiki', 'training-programs'];
if (!in_array($page, $allowed_pages, true)) {
    $page = 'home';
}

function is_active(string $p, string $cur): string {
    return $p === $cur ? 'active' : '';
}
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <title>Muscle Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/styles/style.css">
</head>
<body>
  <?php include __DIR__ . '/templates/header.php'; ?>

  <main class="container">
    <?php include __DIR__ . "/pages/{$page}.php"; ?>
  </main>

  <?php include __DIR__ . '/templates/footer.php'; ?>

  <script src="/assets/js/app.js"></script>
</body>
</html>
