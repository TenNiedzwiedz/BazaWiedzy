<?php

namespace app\core\form;

use app\core\Model;

class Select
{
  public Model $model;
  public string $attribute;
  public array $options;

  public function __construct(Model $model, string $attribute, array $options)
  {
    $this->model = $model;
    $this->attribute = $attribute;
    $this->options = $options;
  }

  public function __toString()
  {
    $selectField = sprintf('
        <div class="mb-3">
          <label  class="form-label">%s</label>
          <select name="%s[]" id="%s" class="form-select" data-allow-clear="true" multiple>
      ',
        $this->model->getLabel($this->attribute),
        $this->attribute,
        $this->attribute
    );

    foreach($this->options as $option => $value)
    {
      $selectField .= sprintf('
          <option %s value="%s">%s</option>
        ',
          ($this->model->{$this->attribute} == $value) ? 'selected="selected"' : '',
          $value,
          $option
      );
    }

    $selectField .= '</select><div class="invalid-feedback">Wybierz poprawną wartość.</div></div>';
    return $selectField;
  }

}
