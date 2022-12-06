<?php
  use app\core\table\Table;
?>

<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Lista ulubionych artykułów</div>
      <div class="card-body">
        <?php
          if($favouritePostList)
          {
            foreach($favouritePostList as $key => $postListByTag) {
              echo '<h5 class="text-center">Ulubione dla tagu: <span class="badge rounded-pill bg-primary me-1">'.$key.'</span></h5>';
              Table::table($postListByTag, ['id', 'title', 'views']);
              echo '<hr>';
            }
          }
          if($postList) {
            echo '<h5 class="text-center">Wszystkie ulubione</h5>';
            Table::table($postList, ['id', 'title', 'views']);
            Table::tableClickable('/post');
          } else {
            echo '<h4>Brak wpisów dla wybranego produktu</h4>';
          }
        ?>
      </div>
    </div>
  </div>
</div>
