<section class="page">
  <div class="container">
    <h1>Contact</h1>
    <p>Masz pytanie? Wyślij wiadomość – odpowiemy ASAP.</p>

    <form class="form" method="post" action="/?action=contact_submit&page=contact">
      <?= csrf_field() ?>
      <div class="hp">
        <label>Website <input type="text" name="website" autocomplete="off"></label>
      </div>

      <div class="form-row">
        <label>Imię i nazwisko
          <input type="text" name="name" required>
        </label>
      </div>
      <div class="form-row">
        <label>Email
          <input type="email" name="email" required>
        </label>
      </div>
      <div class="form-row">
        <label>Wiadomość
          <textarea name="message" rows="5" required></textarea>
        </label>
      </div>
      <div class="form-actions">
        <button class="btn" type="submit">Wyślij</button>
      </div>
    </form>
  </div>
</section>
