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
          Ten artykuł może nie być aktualny. Sprawdź jego poprawność i zweryfikuj go.
        </div>
        <?php elseif($verifiedDaysAgo > 180): ?>
        <div class="alert alert-warning text-center m-5" role="alert">
          <h6>Artykuł zweryfikowany ponad 6 miesięcy temu!</h6>
          Ten artykuł może nie być aktualny. Sprawdź jego poprawność i zweryfikuj go.
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
        <small id='verifiedField' class="<?= ($post->verified) ? '' : 'd-none' ?>">Post zweryfikowany <?= $verified['date'] ?> przez <?= $verified['name'] ?></small>
        <hr>
      </div>
      <div class="card-body pt-0">
        <div class="collapse start-0 mb-3" id="collapseVerify">
          <h5 class="card-title text-center">Zweryfikuj artykuł</h5>
          <div class="card-text form-control mb-3">
            <b>Przed zweryfikowaniem artykułu, upewnij się, że spełnia on poniższe wymagania:</b>
            <ol>
              <li>Artykuł jest poprawny pod kątem merytorycznym (czy opisane rozwiązanie jest poprawne, czy zostały przedstawione alternatywne rozwiązania, czy problem w ogóle jeszcze występuje)</li>
              <li>Podobny artykuł nie występuje już w Bazie Wiedzy</li>
              <li>Nazwy użytkowników pisane są małą literą ("uczeń" zamiast "Uczeń")</li>
              <li>Nazwy naszych produktów są zapisane poprawnie ("Synergia" zamiast "e-Dziennik"</li>
              <li>W treści artykułu nie ma literówek, podwójnych spacji, itp.</li>
              <li>Nazwy modułów/widoków są pisane wielką literą ("moduł Wycieczki", widok "Panel zastępstw")</li>
              <li>Pole "Odpowiedź dla użytkownika" nie zawiera tagów HTML</li>
              <li>Artykuł posiada przypisane tagi, w tym conajmniej jeden tag produktu</li>
            </ol>
        </div>
          <div class="text-center">
            <button onclick="verifyPost(<?= $post->id ?>)" class="btn btn-warning">Potwierdzam, że artykuł jest aktualny i zgodny z procedurą</button>
          </div>
          <hr>
        </div>
        <div class="text-end">
          <a onclick="collapse()"class="btn btn-warning" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" data-bs-title="Zweryfikuj"><i class="bi bi-check2-square"></i></a>
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
    function collapse() {
      var collapse = document.getElementById("collapseVerify");
      var bsCollapse = new bootstrap.Collapse(collapse);
    }

    function verifyPost(id) {
      var xmlhttp=new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          var alerts = document.getElementsByClassName("alert");
          if(alerts[0]) {
            alerts[0].classList.add('d-none');
          }
          collapse();
          var verifiedField = document.getElementById('verifiedField');
          verifiedField.innerText = "Post zweryfikowany <?= $verified['today'] ?> przez <?= $currentUser->getUsername() ?>";
          verifiedField.classList.remove('d-none');

          console.log(this.response);
          showFlashMessage(this.response);
        }
      }
      xmlhttp.open("POST","verifypost",true);
      xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xmlhttp.send('id='+id);
    }
    //Favourite AJAX //TODO Add flashMessage
    function addFav(id) {
      var xmlhttp=new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("favAddBtn").classList.add('d-none');
          document.getElementById("favRemoveBtn").classList.remove('d-none');

          showFlashMessage(this.response);
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

          showFlashMessage(this.response);
        }
      }
      xmlhttp.open("POST","removefav",true);
      xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xmlhttp.send('id='+id);
    }
  </script>
</div>
