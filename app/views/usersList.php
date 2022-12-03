<?php
  use app\core\table\Table;
?>

<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Użytkownicy</div>
      <div class="card-body">
        <?php
          if($userList) {
            Table::table($userList, ['id', 'firstname', 'lastname', 'email']);
          } else {
            echo '<h4>Brak użytkowników</h4>';
          }
        ?>
      </div>
    </div>
  </div>
</div>
