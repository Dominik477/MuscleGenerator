<?php
/** @var string $page */
$labels = [
  'home' => 'Home',
  'diet-wiki' => 'Diet Wiki',
  'training-programs' => 'Training Programs',
  'muscle-wiki' => 'Muscle Wiki',
  'about-us' => 'About Us',
  'contact' => 'Contact',
  'opinions' => 'Opinions',
];
?>
<nav class="breadcrumb" aria-label="breadcrumb">
  <a href="?page=home" class="crumb">Home</a>
  <?php if ($page !== 'home'): ?>
    <span class="crumb-sep">›</span>
    <span class="crumb-current"><?= htmlspecialchars($labels[$page] ?? $page) ?></span>
  <?php endif; ?>
</nav>
