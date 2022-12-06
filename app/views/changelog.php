<?php
  use app\core\table\Table;
?>

<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Historia zmian</div>
      <div class="card-body">
        <?php
          if($changelogList) {
            Table::table($changelogList, ['id', 'fieldName', 'oldValue', 'newValue', 'userID', 'date']);
          } else {
            echo '<h4>Brak historii dla wybranego obiektu</h4>';
          }
        ?>
      </div>
    </div>
  </div>
</div>
