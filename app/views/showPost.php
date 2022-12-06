<?php

use app\core\Application;

?>
<style>

  .tagify__tag {
    --readonly-striped: 0;
    --tag-bg: var(--bs-blue);
    --tag-hover: #0b5ed7;
    --tag-text-color: var(--bs-white);
  }

</style>


<div class="row d-flex justify-content-evenly">
<?php include_once  Application::$ROOT_DIR."/views/elements/tagifyRepo.php"; ?>  
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Artykuł</div>
      <div class="card-body">
        <h5 class="card-title">Tytuł</h5>
        <p class="card-text form-control">
          <?= $post->title ?>
        </p>
        <h5 class="card-title">Uwagi</h5>
        <p class="card-text form-control">
          <?= $post->remarks ?>
        </p>
        <h5 class="card-title">Odpowiedź na użytkownika</h5>
        <p class="card-text form-control">
          <?= $post->content ?>
        </p>
        <h5 class="card-title">Tagi</h5>
        <input readonly name="tags" value="<?= $post->tags ?>" class="form-control %s">
      </div>
      <div class="card-body">
        <div class="text-end">
          <a href="/editpost?id=<?= $post->id ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edytuj"><i class="bi bi-pencil-square"></i></a>
          <a href="/changelog?object=post&id=<?= $post->id ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Historia modyfikacji"><i class="bi bi-clock-history"></i></a>
        </div>
      </div>
    </div>
  </div>
  <script>
    var input = document.querySelector('input[name=tags]');

    var tagify = new Tagify(input)
  </script>
</div>
