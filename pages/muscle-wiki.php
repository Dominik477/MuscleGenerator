<?php include __DIR__ . '/../templates/card.php'; ?>
<section class="page">
  <div class="container">
    <h1>Muscle Wiki</h1>
    <p>Podstawy anatomii mięśniowej i przykładowe ćwiczenia na grupy mięśni.</p>

    <div class="cards">
      <?php
        render_card('Klatka piersiowa', 'Podstawy', '
          <ul class="list">
            <li>Wyciskanie sztangi leżąc</li>
            <li>Rozpiętki z hantlami</li>
            <li>Pompki</li>
          </ul>
        ');
        render_card('Plecy', 'Grubość i szerokość', '
          <ul class="list">
            <li>Wiosłowanie sztangą</li>
            <li>Podciąganie nachwytem</li>
            <li>Ściąganie drążka</li>
          </ul>
        ');
        render_card('Nogi', 'Czworogłowe / dwugłowe / pośladki', '
          <ul class="list">
            <li>Przysiad</li>
            <li>Martwy ciąg</li>
            <li>Wykroki</li>
          </ul>
        ');
      ?>
    </div>
  </div>
</section>
