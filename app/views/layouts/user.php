<?php
  use app\core\Application;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baza Wiedzy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css"/>
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
    <style>
      .collapse, .collapsing {
        position: relative;
        left: 1.25rem;
      }
      .collapse-toggle::before {
        width: 1.25em;
        line-height: 0;
        transition: transform .35s ease;
        transform-origin: .5em 50%;
      }
      .collapse-toggle[aria-expanded="true"]::before {
        transform: rotate(90deg);
      }
    </style>
  </head>
  <body onload="showFlashMessage()" style="background: #f6f6f6">
    <div class="container-fluid">
      <header class="row p-3 text-bg-dark border-bottom">
        <div class="col-2 h4 m-0" style="min-width: 280px">
          <a class="navbar-brand link-warning" href="/"><i class="bi bi-rocket-takeoff-fill"></i>&nbsp Baza wiedzy</a>
        </div>
        <div class="col text-end">
          <div class="dropdown d-inline-flex align-items-center">
            <form class="me-3" action="/search" method="get">
              <input type="text" name="searchWords" class="form-control form-control-dark text-bg-dark" placeholder="Szukaj...">
            </form>
            <span class="me-3"><?= $currentUser->getUsername() ?></span><a href="#" class="link-warning h4 m-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i></a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="/myprofile">Mój profil</a></li>
              <li><a class="dropdown-item" href="/settings">Ustawienia</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/logout">Wyloguj</a></li>
            </ul>
          </div>
        </div>
      </header>
      <div class="row">
        <div class="col-2 text-bg-dark" style="min-width: 280px;">
          <div id="sideNavbar" style="width:100%; overflow: hidden;" data-simplebar >
            <div class="navbar-nav mb-2 p-3">

              <?php include_once  Application::$ROOT_DIR."/views/elements/navProducts.php"; ?>

              <hr>
              <div class="h4">Pozostałe</div>
              <a class="nav-link" href="#">Rejestr tematów</a>
              <a class="nav-link" href="#">Lista telefonów</a>
              <a class="nav-link" href="#">Narzędzia sieciowe</a>

              <a class="nav-link bi bi-chevron-right collapse-toggle d-inline-flex align-items-center collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#jst-collapse" aria-expanded="false">
                  Szkoły projektowe
              </a>
              <div class="collapse" id="jst-collapse">
                  <a href="#" class="nav-link">Projekt Radom</a>
                  <a href="#" class="nav-link">Projekt Gorzów Wlkp.</a>
                  <a href="#" class="nav-link">Projekt Tarnobrzeg</a>
                  <a href="#" class="nav-link">Projekt Olsztyn</a>
              </div>
            </div>
          </div>
          <div id="sideNavbarFooter" class="p-3 border-top text-center fw-light">
            <small>Baza Wiedzy 2.0 - A.D. 2022</small>
          </div>
        </div>

        <div class="col">
          <div id="content" class="p-3" style="width:100%; overflow-x: hidden;" data-simplebar>
            {{content}}
          </div>
        </div>
      </div>
    </div>

    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
      function setMainHeight()
      {
        var header = document.getElementsByTagName('header');
        var sideNavbar = document.getElementById('sideNavbar');
        var sideNavbarFooter = document.getElementById('sideNavbarFooter');
        var content = document.getElementById('content');
        var windowHeight = window.innerHeight;
        var contentHeight = windowHeight - header[0].offsetHeight;
        var sideNavbarHeight = contentHeight - sideNavbarFooter.offsetHeight;

        sideNavbar.setAttribute("style", "height: "+sideNavbarHeight+"px; overflow-x:hidden;");
        content.setAttribute("style", "height: "+contentHeight+"px;");
      }
      window.addEventListener("resize", setMainHeight);
      window.addEventListener("load", setMainHeight);

      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    </script>
    <?php include_once  Application::$ROOT_DIR."/views/elements/flashMessages.php"; ?>

  </body>
</html>
