<?php
  use app\core\table\Table;
?>

<div class="row d-flex justify-content-evenly">
  <div class="col-8">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Lista tagów</div>
      <div class="card-body">
        <?php
          if($tagList) {
            Table::table($tagList, ['id', 'name', 'visible']);
            Table::tableClickable('/edittag');
          } else {
            echo '<h4>Lista tagów jest pusta</h4>';
          }
        ?>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="card text-bg-dark">
      <div class="card-header h3 text-center">Dodaj nowy</div>
      <div class="card-body">
        <h5 class="card-title text-center"></h5>
        <p class="card-text">
          <?php $form = \app\core\form\Form::begin('/addtag', "post"); ?>
            <?= $form->field($tag, 'name'); ?>
            <?= $form->field($tag, 'visible')->checkSwitchField(); ?>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Dodaj tag</button>
            </div>
          <?= \app\core\form\Form::end(); ?>
        </p>
      </div>
    </div>
  </div>
</div>

<script>
  var rows = document.getElementsByTagName('tr');

  console.log('działa');
  console.log(rows);    
  for(var i=1; i < rows.length; i++) {
    console.log('cokolwiek');
    var visible = rows[i].children[2].innerText;
    console.log(visible);
    
    if(visible == '1') {
      rows[i].children[2].innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
      
    } else {
      rows[i].children[2].innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>';
    }
  }
</script>


