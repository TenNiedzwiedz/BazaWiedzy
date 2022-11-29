<?php

namespace app\core\table;

class Table
{
  public static function table($data =[], $attributes = [])
  {
    $className = $data[0];
    echo "
      <table class='table table-dark table-striped table-hover'>
        <thead>
          <tr>
      ";

    foreach ($attributes as $key => $attribute) {
      echo "<th scope='col'>";
      echo $className->getLabel($attribute);
      echo "</th>";
    }

    echo "
        </tr>
      </thead>
      <tbody>
      ";

    foreach ($data as $key => $object) {
      echo "<tr>";
      foreach ($attributes as $key => $attribute) {
        echo "<td>";
        echo ($object->$attribute) ?? '';
        echo "</td>";
      }
      echo "</tr>";
    }

    echo "
        </tbody>
      </table>
      ";

  }

  public static function tableClickable($path)
  {
    echo '
      <script>
        var row = document.getElementsByTagName(\'tr\');

        for(var i=1; i < row.length; i++) {
          var id = row[i].children[0].innerText;
          row[i].setAttribute("style", "transform: rotate(0);");
          row[i].children[0].innerHTML = "<a href=\''.$path.'?id="+id+"\' class=\'stretched-link text-reset text-decoration-none\'>"+id+"</a>";
        }

      </script>
      ';
  }

}
