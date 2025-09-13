<?php /* templates/header.php */ ?>
<header class="header">
  <div class="container header__inner">
    <a href="?page=home" class="logo">Muscle Generator</a>

    <nav class="nav" style="margin-left:auto; margin-right:8px;">
      <a href="?page=diet-wiki" class="nav-link <?= is_active('diet-wiki', $page) ?>">Dieta</a>
      <a href="?page=training-programs" class="nav-link <?= is_active('training-programs', $page) ?>">Trening</a>
      <a href="?page=muscle-wiki" class="nav-link <?= is_active('muscle-wiki', $page) ?>">Wikipedia Mięśni</a>
      <a href="?page=opinions" class="nav-link <?= is_active('opinions', $page) ?>">Opinie</a>
      <a href="?page=about-us" class="nav-link <?= is_active('about-us', $page) ?>">O nas</a>
      <a href="?page=contact" class="nav-link <?= is_active('contact', $page) ?>">Kontakt</a>
      <?php if (auth_logged() && auth_is('admin')): ?>
        <a href="?page=admin" class="nav-link <?= is_active('admin', $page) ?>">Admin</a>
      <?php endif; ?>
    </nav>

    <div class="auth-area" style="display:flex; gap:8px;">
      <?php if (auth_logged()): ?>
        <span class="nav-link" style="opacity:.9;">
          <?= htmlspecialchars((string)auth_email()) ?> (<?= htmlspecialchars((string)auth_role()) ?>)
        </span>
        <a class="btn btn-outline btn-sm" href="/?action=logout">Wyloguj</a>
      <?php else: ?>
        <a class="btn btn-outline btn-sm <?= is_active('login', $page) ?>" href="/?page=login">Zaloguj</a>
      <?php endif; ?>
    </div>
  </div>
</header>
