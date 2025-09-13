<?php

$currentUser = null;
$isAdmin = false;

if (function_exists('auth_logged') && auth_logged()) {
    $uid = auth_user_id();
    if ($uid !== null && class_exists('UsersRepo')) {
        $currentUser = UsersRepo::findById($uid); 
        $isAdmin = $currentUser && (($currentUser['role'] ?? '') === 'admin');
    }
}
?>
<header class="header">
  <div class="container header__inner">
    <a href="?page=home" class="logo">Muscle Generator</a>

    <nav class="nav">
      <a href="?page=diet-wiki" class="nav-link <?= is_active('diet-wiki', $page) ?>">Dieta</a>
      <a href="?page=training-programs" class="nav-link <?= is_active('training-programs', $page) ?>">Trening</a>
      <a href="?page=muscle-wiki" class="nav-link <?= is_active('muscle-wiki', $page) ?>">Mięśnie</a>
      <a href="?page=opinions" class="nav-link <?= is_active('opinions', $page) ?>">Opinie</a>
      <a href="?page=about-us" class="nav-link <?= is_active('about-us', $page) ?>">O nas</a>
      <a href="?page=contact" class="nav-link <?= is_active('contact', $page) ?>">Kontakt</a>
      <?php if ($isAdmin): ?>
        <a href="?page=admin" class="nav-link <?= is_active('admin', $page) ?>">Admin</a>
      <?php endif; ?>
    </nav>

    <div class="auth-area">
      <?php if ($currentUser): ?>
        <?php
          $email = trim((string)($currentUser['email'] ?? ''));
          $role  = trim((string)($currentUser['role']  ?? ''));
          $label = $email !== '' ? $email : 'Zalogowany';
        ?>
        <span class="nav-link" style="opacity:.9;">
          <?= htmlspecialchars($label) ?>
          <?php if ($role !== ''): ?>
            <span class="role-badge"
                  style="margin-left:6px; padding:2px 6px; border-radius:6px; border:1px solid var(--bd); background:var(--panel); font-size:12px; opacity:.9;">
              <?= htmlspecialchars($role) ?>
            </span>
          <?php endif; ?>
        </span>
        <a class="btn btn-outline btn-sm" href="/?action=logout">Wyloguj</a>
      <?php else: ?>
        <a class="btn btn-outline btn-sm <?= is_active('login', $page) ?>" href="/?page=login">Zaloguj</a>
        <a class="btn btn-primary btn-sm <?= is_active('register', $page) ?>" href="/?page=register">Zarejestruj</a>
      <?php endif; ?>
    </div>
  </div>
</header>
