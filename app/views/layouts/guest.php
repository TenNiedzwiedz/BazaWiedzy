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
        <div class="col">
          <div id="content" class="p-3 d-flex align-items-center">
            {{content}}
          </div>
        </div>
    </div>

    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <?php include_once  Application::$ROOT_DIR."/views/elements/flashMessages.php"; ?>
    <script>
      function setMainHeight()
      {
        var content = document.getElementById('content');
        var windowHeight = window.innerHeight;

        content.setAttribute("style", "height: "+windowHeight+"px;");
      }
      window.addEventListener("resize", setMainHeight);
      window.addEventListener("load", setMainHeight);

    </script>
  </body>
</html>
