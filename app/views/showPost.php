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
        <?php if($verifiedDaysAgo > 360): ?>
        <div class="alert alert-danger text-center m-5" role="alert">
          <h6>Artykuł zweryfikowany ponad 12 miesięcy temu!</h6>
          Treść artykułu może nie być aktualna. Sprawdź jego poprawność i zweryfikuj go.
        </div>
        <?php elseif($verifiedDaysAgo > 180): ?>
        <div class="alert alert-warning text-center m-5" role="alert">
          <h6>Artykuł zweryfikowany ponad 6 miesięcy temu!</h6>
          Treść artykułu może nie być aktualna. Sprawdź jego poprawność i zweryfikuj go.
        </div>
        <?php endif; ?>
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
          <span id="favAddBtn" class="<?= ($isFav) ? 'd-none' : '' ?>">
            <button onclick="addFav(<?= $post->id ?>)" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dodaj do ulubionych"><i class="bi bi-heart"></i></button>
          </span>
          <span id="favRemoveBtn" class="<?= ($isFav) ? '' : 'd-none' ?>">
          <button onclick="removeFav(<?= $post->id ?>)" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Usuń z ulubionych"><i class="bi bi-heartbreak"></i></button>          </span>
          <a href="/editpost?id=<?= $post->id ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edytuj"><i class="bi bi-pencil-square"></i></a>
          <a href="/changelog?object=posts&id=<?= $post->id ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Historia modyfikacji"><i class="bi bi-clock-history"></i></a>
        </div>
      </div>
    </div>
  </div>
  <script>
    //Tagify init
    var input = document.querySelector('input[name=tags]');

    var tagify = new Tagify(input)
  </script>

  <script>
    //Favourite AJAX //TODO Add flashMessage
    function addFav(id) {
      var xmlhttp=new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("favAddBtn").classList.add('d-none');
          document.getElementById("favRemoveBtn").classList.remove('d-none');

          console.log(this.responseText);
        }
      }
      xmlhttp.open("POST","addfav",true);
      xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xmlhttp.send('id='+id);
    }
    function removeFav(id) {
      var xmlhttp=new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("favRemoveBtn").classList.add('d-none');
          document.getElementById("favAddBtn").classList.remove('d-none');
          console.log(this.responseText);
        }
      }
      xmlhttp.open("POST","removefav",true);
      xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xmlhttp.send('id='+id);
    }
  </script>
</div>
