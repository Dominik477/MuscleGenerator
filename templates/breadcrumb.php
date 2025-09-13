<?php
/** @var string $page */
$labels = [
  'home' => 'Home',
  'diet-wiki' => 'Dieta',
  'training-programs' => 'Plany treningowe',
  'muscle-wiki' => 'Mięśnie',
  'about-us' => 'O nas',
  'contact' => 'Kontakt',
  'opinions' => 'Opinie',
  'login' => 'Logowanie',
  'register' => "Rejestracja"
];
?>
<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="?page=home" class="crumb">Home</a>
  <?php if ($page !== 'home'): ?>
    <span class="crumb-sep">›</span>
    <span class="crumb-current"><?= htmlspecialchars($labels[$page] ?? $page) ?></span>
  <?php endif; ?>
</nav>
