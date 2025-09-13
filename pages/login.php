<section class="page">
  <div class="container">
    <h1>Logowanie</h1>
    <p class="muted">Zaloguj się, aby uzyskać dostęp do panelu.</p>

    <form class="form" method="post" action="/?action=login&page=login" novalidate>
      <?= csrf_field() ?>
      <div class="hp"><label>Website <input type="text" name="website" autocomplete="off"></label></div>

      <div class="form-row">
        <label>Email
          <input type="email" name="email" required placeholder="np. admin@example.com" inputmode="email" autocomplete="username">
        </label>
      </div>

      <div class="form-row">
        <label>Hasło
          <input type="password" name="password" required placeholder="••••••••" autocomplete="current-password">
        </label>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Zaloguj</button>
        <a class="btn btn-ghost" href="/?page=home">Anuluj</a>
      </div>
    </form>
  </div>
</section>
