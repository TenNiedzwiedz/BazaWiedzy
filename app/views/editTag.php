<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Edycja taga</div>
      <div class="card-body">
        <h5 class="card-title text-center"></h5>
        <p class="card-text">
          <?php $form = \app\core\form\Form::begin('/edittag', "post"); ?>
            <?= $form->field($tag, 'id')->hiddenField(); ?>
            <?= $form->field($tag, 'name'); ?>
            <?= $form->field($tag, 'visible')->checkSwitchField(); ?>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Zapisz</button>
            </div>
          <?= \app\core\form\Form::end(); ?>
        </p>
      </div>
    </div>
  </div>
</div>
