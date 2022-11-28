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
          Nazwa: <?= $user->getUsername() ?></br>
          Login: <?= $user->login ?></br>
          Email: <?= $user->email ?></br>
          Rola: <?= $user->getUserRole() ?>
        </p>
        <hr>
        <h5 class="card-title text-center">Statystyki konta</h5>
        <div class="row d-flex justify-content-evenly mb-3 text-center">
          <div class="col-4 border rounded border-secondary text-bg-light">
            <i class="bi bi-pencil-square h2 text-primary"></i>
            <h2>15</h2>
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
        <h5 class="card-title">Dodawanie ucznia<span class="badge rounded-pill bg-primary ms-3">e-Sekretariat</span></h5>
        <p class="card-text post-body">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id ornare dolor. Ut molestie felis eget interdum venenatis. Quisque quis tortor sit amet nibh hendrerit malesuada. Sed laoreet suscipit auctor. Praesent tincidunt scelerisque pretium. Nulla at sem quam. Nam faucibus ligula ac arcu ullamcorper efficitur. Sed luctus, nulla quis vestibulum dictum, quam sem bibendum urna, vel dictum neque quam at felis. Morbi in porttitor nulla, a vulputate dolor. Aenean vitae ex odio. Maecenas vel nisi vitae libero cursus euismod. Proin consectetur venenatis neque, faucibus auctor ante feugiat a. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras volutpat sapien quis sapien elementum, nec iaculis justo fermentum. Vivamus gravida fringilla libero quis gravida.
        </p>
        <hr>
        <h5 class="card-title">Jak dodać nowego administratora?<span class="badge rounded-pill bg-primary ms-3">Synergia</span></h5>
        <p class="card-text post-body">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id ornare dolor. Ut molestie felis eget interdum venenatis. Quisque quis tortor sit amet nibh hendrerit malesuada. Sed laoreet suscipit auctor. Praesent tincidunt scelerisque pretium. Nulla at sem quam. Nam faucibus ligula ac arcu ullamcorper efficitur. Sed luctus, nulla quis vestibulum dictum, quam sem bibendum urna, vel dictum neque quam at felis. Morbi in porttitor nulla, a vulputate dolor. Aenean vitae ex odio. Maecenas vel nisi vitae libero cursus euismod. Proin consectetur venenatis neque, faucibus auctor ante feugiat a. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras volutpat sapien quis sapien elementum, nec iaculis justo fermentum. Vivamus gravida fringilla libero quis gravida.
        </p>
        <hr>
        <h5 class="card-title">Jak utworzyć konto Librus?<span class="badge rounded-pill bg-primary ms-3">Portal LIBRUS</span></h5>
        <p class="card-text post-body">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id ornare dolor. Ut molestie felis eget interdum venenatis. Quisque quis tortor sit amet nibh hendrerit malesuada. Sed laoreet suscipit auctor. Praesent tincidunt scelerisque pretium. Nulla at sem quam. Nam faucibus ligula ac arcu ullamcorper efficitur. Sed luctus, nulla quis vestibulum dictum, quam sem bibendum urna, vel dictum neque quam at felis. Morbi in porttitor nulla, a vulputate dolor. Aenean vitae ex odio. Maecenas vel nisi vitae libero cursus euismod. Proin consectetur venenatis neque, faucibus auctor ante feugiat a. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras volutpat sapien quis sapien elementum, nec iaculis justo fermentum. Vivamus gravida fringilla libero quis gravida.
        </p>
        <hr>
        <h5 class="card-title">Czym są i jak mogę dodać alerty?<span class="badge rounded-pill bg-primary ms-3">Synergia</span></h5>
        <p class="card-text post-body">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id ornare dolor. Ut molestie felis eget interdum venenatis. Quisque quis tortor sit amet nibh hendrerit malesuada. Sed laoreet suscipit auctor. Praesent tincidunt scelerisque pretium. Nulla at sem quam. Nam faucibus ligula ac arcu ullamcorper efficitur. Sed luctus, nulla quis vestibulum dictum, quam sem bibendum urna, vel dictum neque quam at felis. Morbi in porttitor nulla, a vulputate dolor. Aenean vitae ex odio. Maecenas vel nisi vitae libero cursus euismod. Proin consectetur venenatis neque, faucibus auctor ante feugiat a. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras volutpat sapien quis sapien elementum, nec iaculis justo fermentum. Vivamus gravida fringilla libero quis gravida.
        </p>
        <hr>
        <h5 class="card-title">Gdzie znajdę pomoc do stron EduPage?<span class="badge rounded-pill bg-primary ms-3">EduPage</span></h5>
        <p class="card-text post-body">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id ornare dolor. Ut molestie felis eget interdum venenatis. Quisque quis tortor sit amet nibh hendrerit malesuada. Sed laoreet suscipit auctor. Praesent tincidunt scelerisque pretium. Nulla at sem quam. Nam faucibus ligula ac arcu ullamcorper efficitur. Sed luctus, nulla quis vestibulum dictum, quam sem bibendum urna, vel dictum neque quam at felis. Morbi in porttitor nulla, a vulputate dolor. Aenean vitae ex odio. Maecenas vel nisi vitae libero cursus euismod. Proin consectetur venenatis neque, faucibus auctor ante feugiat a. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras volutpat sapien quis sapien elementum, nec iaculis justo fermentum. Vivamus gravida fringilla libero quis gravida.
        </p>
      </div>
    </div>
  </div>
</div>

<script>
const postBodyList = document.getElementsByClassName('post-body');

Array.from(postBodyList).forEach((element) => {
  element.innerText = element.innerText.substr(0,200)+'...';
});
</script>
