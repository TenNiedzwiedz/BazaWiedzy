<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Ustawienia konta</div>
      <div class="card-body">
        <div class="row d-flex justify-content-evenly">
          <div class="col-6">
            <h5 class="card-title text-center">Dane konta</h5>
            <p class="card-text">
              <?php $form = \app\core\form\Form::begin('/edituser', "post"); ?>
                <?= $form->field($user, 'firstname'); ?>
                <?= $form->field($user, 'lastname'); ?>
                <?= $form->field($user, 'email'); ?>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
              <?= \app\core\form\Form::end(); ?>
            </p>
          </div>
        </div>
        <hr>
        <div class="row d-flex justify-content-evenly">
          <div class="col-6">
            <h5 class="card-title text-center">Zmiana hasła</h5>
            <p class="card-text">
              <?php $form = \app\core\form\Form::begin('/changepassword', "post"); ?>
                <?= $form->field($model, 'password')->passwordField(); ?>
                <?= $form->field($model, 'newPassword')->passwordField(); ?>
                <?= $form->field($model, 'confirmNewPassword')->passwordField(); ?>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Zmień hasło</button>
                </div>
              <?= \app\core\form\Form::end(); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
