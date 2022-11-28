<div class="card text-bg-dark mb-3 col-4 ms-auto me-auto align-middle">
  <div class="card-header h1 text-center"><a class="navbar-brand link-warning" href="/"><i class="bi bi-rocket-takeoff-fill"></i>&nbsp Baza wiedzy</a></div>
  <div class="card-body">
    <h2 class="card-title">Błąd <?= $exception->getCode() ?></h2>
    <p class="card-text">
      <?= $exception->getMessage() ?>
    </p>
    <hr>
    <p class="card-text text-center">
      <a href="/" class="link-warning">Powrót do strony głównej</a>
    </p>
  </div>
</div>
