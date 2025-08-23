<?php /* templates/header.php */ ?>
<header class="header">
  <div class="container header__inner">
    <a href="?page=home" class="logo">Muscle Generator</a>
    <nav class="nav">
      <a href="?page=home" class="nav-link <?= is_active('home', $page) ?>">Home</a>
      <a href="?page=diet-wiki" class="nav-link <?= is_active('diet-wiki', $page) ?>">Diet Wiki</a>
      <a href="?page=training-programs" class="nav-link <?= is_active('training-programs', $page) ?>">Training</a>
      <a href="?page=muscle-wiki" class="nav-link <?= is_active('muscle-wiki', $page) ?>">Muscle Wiki</a>
      <a href="?page=about-us" class="nav-link <?= is_active('about-us', $page) ?>">About</a>
    </nav>
  </div>
</header>
