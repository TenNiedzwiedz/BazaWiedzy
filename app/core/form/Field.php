<?php

namespace app\core\form;

use app\core\Model;

class Field
{
  public const TYPE_TEXT = 'text';
  public const TYPE_TEXTAREA = 'textarea';
  public const TYPE_PASSWORD = 'password';
  public const TYPE_NUMBER = 'number';
  public const TYPE_HIDDEN = 'hidden';
  public const TYPE_CHECKSWITCH = 'checkswitch';

  public string $type;
  public Model $model;
  public string $attribute;

  public function __construct(Model $model, string $attribute) //TODO Przenieść errorLog z modelu do params
  {
    $this->type = self::TYPE_TEXT;
    $this->model = $model;
    $this->attribute = $attribute;
  }

  public function __toString()
  {
    switch($this->type)
    {
      case self::TYPE_HIDDEN:
        return sprintf('
          <input type="%s" name="%s" value="%s">
        ',
          $this->type,
          $this->attribute,
          $this->model->{$this->attribute}
        );
        break;
      case self::TYPE_TEXTAREA:
        return sprintf('
          <div class="mb-3">
            <label class="form-label">%s</label>
            <textarea class="form-control %s" name="%s" rows="4">%s</textarea>
            <div class="invalid-feedback">
              %s
            </div>
          </div>
        ',
          $this->model->getLabel($this->attribute),
          $this->model->hasError($this->attribute) ? 'is-invalid' : '',
          $this->attribute,
          $this->model->{$this->attribute},
          $this->model->getFirstError($this->attribute)
        );
        break;
      case self::TYPE_CHECKSWITCH:
        return sprintf('
          <div class="mb-3 form-check form-switch">
            <label class="form-check-label">%s</label>
            <input class="form-check-input" type="checkbox" name="%s" role="switch" value="true" %s>
          </div>
        ',
          $this->model->getLabel($this->attribute),
          $this->attribute,
          ($this->model->{$this->attribute} == true) ? 'checked' : ''
        );
        break;
      default:
        return sprintf('
          <div class="mb-3">
            <label class="form-label">%s</label>
            <input type="%s" name="%s" value="%s" class="form-control %s">
            <div class="invalid-feedback">
              %s
            </div>
          </div>
        ',
          ($this->type == self::TYPE_HIDDEN) ? '' : $this->model->getLabel($this->attribute),
          $this->type,
          $this->attribute,
          $this->model->{$this->attribute},
          $this->model->hasError($this->attribute) ? 'is-invalid' : '',
          $this->model->getFirstError($this->attribute)
        );
        break;
    }
  }

  public function passwordField()
  {
    $this->type = self::TYPE_PASSWORD;
    return $this;
  }

  public function hiddenField()
  {
    $this->type = self::TYPE_HIDDEN;
    return $this;
  }

  public function textareaField()
  {
    $this->type = self::TYPE_TEXTAREA;
    return $this;
  }

  public function checkSwitchField()
  {
    $this->type = self::TYPE_CHECKSWITCH;
    return $this;
  }

}
