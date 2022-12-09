<?php
  use app\core\table\Table;
?>

<style>
  .nav-pills .nav-link {
    color: #ffc107;
    border: 1px solid #ffc107;
  }

  .nav-pills .nav-link.active{
    background-color: #ffc107;
    color: black;
  }

</style>

<div class="row d-flex justify-content-evenly">
  <?php if($postByTagList) : ?>
    <div class="col-2">
      <div class="card text-bg-dark">
        <div class="">
          <div class="nav flex-column nav-pills m-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link m-1 active" id="v-pills-all-tab" data-bs-toggle="pill" data-bs-target="#v-pills-all" type="button" role="tab">Wszystkie</button>
            <?php foreach($postByTagList as $tag => $value) : ?>
              <button class="nav-link m-1" id="v-pills-<?= str_replace(' ', '', $tag) ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?= str_replace(' ', '', $tag) ?>" type="button" role="tab"><?= $tag ?></button>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-9">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Lista artykułów</div>
      <div class="card-body">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel">
            <?php
              if($postList) {
                Table::table($postList, ['id', 'title', 'views']);
                Table::tableClickable('/post');
              } else {
                echo '<h4>Brak wpisów dla wybranego produktu</h4>';
              }
            ?>
          </div>
          <?php 
            foreach($postByTagList as $tag => $posts) {
              echo '<div class="tab-pane fade" id="v-pills-'.str_replace(' ', '', $tag).'" role="tabpanel">';
              Table::table($posts, ['id', 'title', 'views']);
              Table::tableClickable('/post');
              echo '</div>';
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
