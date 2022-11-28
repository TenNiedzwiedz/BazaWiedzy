<div class="card text-bg-dark mb-3 col-4 ms-auto me-auto align-middle">
  <div class="card-header h1 text-center"><a class="navbar-brand link-warning" href="/"><i class="bi bi-rocket-takeoff-fill"></i>&nbsp Baza wiedzy</a></div>
  <div class="card-body">
    <h5 class="card-title">Zaloguj się</h5>
    <p class="card-text">
      <?php $form = \app\core\form\Form::begin('/login', "post"); ?>
        <?= $form->field($model, 'login'); ?>
        <?= $form->field($model, 'password')->passwordField(); ?>
        <div class="text-center"><button type="submit" class="btn btn-warning">Zaloguj</button></div>
      <?= \app\core\form\Form::end(); ?>
    </p>
  </div>
</div>
