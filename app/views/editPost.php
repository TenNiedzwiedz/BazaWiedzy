<?php

use app\core\Application;

?>
<style>

.tagify__tag {
  --readonly-striped: 0;
  --tag-bg: var(--bs-blue);
  --tag-hover: #0b5ed7;
  --tag-text-color: var(--bs-white);
  --tag-remove-bg: var(--bs-red);
  --tag-invalid-bg: var(--bs-red);
}

</style>

<div class="row d-flex justify-content-evenly">
<?php include_once  Application::$ROOT_DIR."/views/elements/tagifyRepo.php"; ?>  
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Edycja artykułu</div>
      <div class="card-body">
        <h5 class="card-title text-center"></h5>
        <p class="card-text">
        <?php $form = \app\core\form\Form::begin('/editpost', "post"); ?>
          <?= $form->field($post, 'id')->hiddenField(); ?>
          <?= $form->field($post, 'title'); ?>
          <?= $form->field($post, 'remarks')->textareaField(); ?>
          <?= $form->field($post, 'content')->textareaField(); ?>
          <?= $form->field($post, 'tags'); ?>
            <div class="text-center">
            <button type="submit" class="btn btn-primary">Zapisz</button>
          </div>
        <?= \app\core\form\Form::end(); ?>
        </p>
      </div>
    </div>
  </div>
  <script>
    var input = document.querySelector('input[name=tags]');

    var tagify = new Tagify(input, {
      enforceWhitelist: true,
      whitelist: [<?= $tagList ?>]
    });
  </script>
</div>