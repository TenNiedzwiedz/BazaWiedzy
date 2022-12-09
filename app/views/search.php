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
      <div class="card-header h3 text-center">Wyszukiwarka</div>
      <div class="card-body ms-5 me-5">
      <form action="/search" method="get">
        <div class="mb-3">
          <label class="form-label">Szukaj</label>
          <input type="text" class="form-control" name="searchWords" value="<?= $searchWords ?>">
          <div class="form-text tips d-none">Podpowiedź: <i>+konto +uczeń</i> - znajduje artykuły, które zawierają każde słowo poprzedzone '+'</div>
          <div class="form-text tips d-none">Podpowiedź: <i>+konto -uczeń</i> - znajduje artykuły, które zawierają słowo 'konto', ale nie zawierają słowa 'uczeń'</div>
          <div class="form-text tips d-none">Podpowiedź: <i>"konto ucznia"</i> - znajduje artykuły, które zawierają dokładną frazę 'konto ucznia'</div>
          <div class="form-text tips d-none">Podpowiedź: <i>kont*</i> - znajduje artykuły, które zawierają słowa zaczynające się od 'kont', np. konto, konta, kontakt, koncie</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Tagi</label>
          <input type="text" class="form-control" name="searchTags" value="<?= $searchTags ?>">
          <div class="form-text">Podpowiedź: Wyszukuje tylko artykuły zawierające każdy z wprowadzonych tagów</div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-warning">Wyszukaj</button>
        </div>
      </form>
      </div>
      <div class="card-body">
        <?php
          if($postList) {
            foreach($postList as $post)
            {
              echo '<a href="/post?id='.$post->id.'"class="text-reset text-decoration-none"><h5 class="card-title">'.$post->title.'</h5></a>';
              foreach($postTagList[$post->id] as $tag) {
                echo '<span class="badge rounded-pill bg-primary me-1">'.$tag->value.'</span>';
              }
              echo '<hr>';
            }
          } else {
            echo '<div class="text-center"><h4>Brak artykułów spełniających kryteria</h4></div>';
          }
        ?>
      </div>
    </div>
  </div>
  <script>
    var input = document.querySelector('input[name=searchTags]');

    var tagify = new Tagify(input, {
      enforceWhitelist: true,
      whitelist: [<?= $tagList ?>]
    });

    var tips = document.getElementsByClassName('tips');
    var id = Math.floor(Math.random() * 4);
    tips[id].classList.remove('d-none');
  </script>
</div>
