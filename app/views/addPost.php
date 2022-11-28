<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Dodawanie nowego artykułu</div>
      <div class="card-body">
        <h5 class="card-title text-center"></h5>
        <p class="card-text">
          <?php $form = \app\core\form\Form::begin('/addpost', "post"); ?>
            <?= $form->field($post, 'title'); ?>
            <?= $form->select($post, 'productID', ['Synergia' => '1', 'eSekretariat' => '2']) ?>
            <?= $form->select($post, 'categoryID', ['Dodawanie' => '1', 'Usuwanie' => '2']) ?>
            <?= $form->field($post, 'remarks')->textareaField(); ?>
            <?= $form->field($post, 'content')->textareaField(); ?>
            <?= $form->field($post, 'tags') ?>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Dodaj artykuł</button>
            </div>
          <?= \app\core\form\Form::end(); ?>
        </p>
      </div>
    </div>
  </div>
</div>
