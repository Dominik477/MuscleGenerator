<?php /* templates/header.php */ ?>
<header class="header">
  <div class="container header__inner">
    <a href="?page=home" class="logo">Muscle Generator</a>

    <nav class="nav" style="margin-left:auto; margin-right:8px;">
      <a href="?page=diet-wiki" class="nav-link <?= is_active('diet-wiki', $page) ?>">Dieta</a>
      <a href="?page=training-programs" class="nav-link <?= is_active('training-programs', $page) ?>">Plany treningowe</a>
      <a href="?page=muscle-wiki" class="nav-link <?= is_active('muscle-wiki', $page) ?>">Mięśnie</a>
      <a href="?page=opinions" class="nav-link <?= is_active('opinions', $page) ?>">Opinie</a>
      <a href="?page=about-us" class="nav-link <?= is_active('about-us', $page) ?>">O nas</a>
      <a href="?page=contact" class="nav-link <?= is_active('contact', $page) ?>">Kontakt</a>
      <?php if (auth_logged() && auth_is('admin')): ?>
        <a href="?page=admin" class="nav-link <?= is_active('admin', $page) ?>">Admin</a>
      <?php endif; ?>
    </nav>

 <div class="auth-area" style="display:flex; gap:8px;">
  <?php if (auth_logged()): ?>
    <?php
      $email = (string) (auth_email() ?? '');
      $role  = (string) (auth_role()  ?? '');
    ?>
    <?php if ($email !== ''): ?>
      <span class="nav-link" style="opacity:.9;">
        <?= htmlspecialchars($email) ?>
        <?php if ($role !== ''): ?>
          <span class="role-badge" style="margin-left:6px; padding:2px 6px; border-radius:6px; border:1px solid var(--bd); background:var(--panel); font-size:12px; opacity:.9;">
            <?= htmlspecialchars($role) ?>
          </span>
        <?php endif; ?>
      </span>
    <?php endif; ?>
    <a class="btn btn-outline btn-sm" href="/?action=logout">Wyloguj</a>
  <?php else: ?>
    <a class="btn btn-outline btn-sm <?= is_active('login', $page) ?>" href="/?page=login">Zaloguj</a>
    <a class="btn btn-primary btn-sm <?= is_active('register', $page) ?>" href="/?page=register">Zarejestruj</a>
  <?php endif; ?>
</div>


  </div>
</header>
