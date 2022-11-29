<?php
  use app\core\table\Table;
?>

<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Lista artykułów</div>
      <div class="card-body">
        <?php
          if($postList) {
            Table::table($postList, ['id', 'title', 'views']);
          } else {
            echo '<h4>Brak wpisów dla wybranego produktu</h4>';
          }
        ?>
      </div>
    </div>
  </div>
</div>
