<section class="page">
  <div class="container">
    <h1>Rejestracja</h1>
    <p class="muted">Utwórz konto, aby korzystać z dodatkowych funkcji.</p>

    <form class="form" method="post" action="/?action=register&page=register" novalidate>
      <?= csrf_field() ?>
      <div class="hp"><label>Website <input type="text" name="website" autocomplete="off"></label></div>

      <div class="form-row">
        <label>Email
          <input type="email" name="email" required placeholder="np. user@example.com" inputmode="email" autocomplete="username">
        </label>
      </div>

      <div class="form-row">
        <label>Hasło
          <input type="password" name="password" required minlength="8" placeholder="min. 8 znaków" autocomplete="new-password">
        </label>
        <div class="help">Użyj co najmniej 8 znaków. Dla bezpieczeństwa zalecamy litery, cyfry i znak specjalny.</div>
      </div>

      <div class="form-row">
        <label>Powtórz hasło
          <input type="password" name="password2" required minlength="8" placeholder="powtórz hasło" autocomplete="new-password">
        </label>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Zarejestruj</button>
        <a class="btn btn-ghost" href="/?page=login">Masz konto? Zaloguj się</a>
      </div>
    </form>
  </div>
</section>
