<section class="page">
  <div class="container">
    <h1>Kontakt</h1>
    <p class="muted">Masz pytanie, pomysł lub zgłoszenie błędu? Napisz – chętnie pomożemy.</p>

    <form class="form" method="post" action="/?action=contact_submit&page=contact" novalidate>
      <?= csrf_field() ?>
      <div class="hp"><label>Website <input type="text" name="website" autocomplete="off"></label></div>

      <div class="form-row">
        <label>Imię i nazwisko
          <input type="text" name="name" required placeholder="np. Jan Kowalski">
        </label>
      </div>

      <div class="form-row">
        <label>Email
          <input type="email" name="email" required placeholder="np. jan@example.com" inputmode="email">
        </label>
      </div>

      <div class="form-row">
        <label>Wiadomość
          <textarea name="message" rows="5" required minlength="5" maxlength="2000" placeholder="Opisz krótko temat..."></textarea>
        </label>
        <div class="help">Nie udostępniamy Twojego adresu. Odpowiemy możliwie szybko.</div>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Wyślij</button>
        <a class="btn btn-ghost" href="/?page=home">Anuluj</a>
      </div>
    </form>
  </div>
</section>
