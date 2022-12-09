<div class="row d-flex justify-content-evenly">

  <div class="col-3">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Mój profil</div>
      <div class="card-body">
        <div class="text-center">
          <i class="bi bi-person-circle" style="font-size: 100px"></i>
        </div>
        <hr>
        <h5 class="card-title text-center">Dane konta</h5>
        <p class="card-text">
          <small>Nazwa: </small><?= $user->getUsername() ?></br>
          <small>Login: </small><?= $user->login ?></br>
          <small>Email: </small><?= $user->email ?></br>
          <small>Rola: </small><?= $user->getUserRole() ?>
        </p>
        <hr>
        <h5 class="card-title text-center">Statystyki konta</h5>
        <div class="row d-flex justify-content-evenly mb-3 text-center">
          <div class="col-4 border rounded border-secondary text-bg-light">
            <i class="bi bi-pencil-square h2 text-primary"></i>
            <h2><?= $addedPosts ?></h2>
            <p style="font-size: 0.75rem;">Dodanych wpisów</p>
          </div>
          <div class="col-4 border rounded border-secondary text-bg-light">
            <i class="bi bi-check2-square h2 text-success"></i>
            <h2>32</h2>
            <p style="font-size: 0.75rem;">Zweryfikowanych wpisów</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Ostatnio dodane wpisy</div>
      <div class="card-body">
        <?php
        if(!empty($postList)) {
          foreach($postList as $post)
          {
            echo '<a href="/post?id='.$post->id.'"class="text-reset text-decoration-none"><h5 class="card-title">'.$post->title.'</h5></a>';
            echo '<p class="card-text post-body mb-1 ms-2"><em>'.$post->content.'</em></p>';
            foreach($tagList[$post->id] as $tag) {
              echo '<span class="badge rounded-pill bg-primary me-1">'.$tag->value.'</span>';
            }
            echo '<hr>';
          }
        } else {
          echo 'Brak postów do wyświetlenia';
        }
        ?>
      </div>
    </div>
  </div>
</div>

<script>
const postBodyList = document.getElementsByClassName('post-body');

Array.from(postBodyList).forEach((element) => {
  if(element.innerText.length > 200) {
    element.innerText = element.innerText.substr(0,200)+'...';
  }
});
</script>
