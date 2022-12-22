<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public string $type;


    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function password()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function email()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function number()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    public function renderInput(): string
    {
        $is_invalid = $this->model->hasError($this->attribute) ? 'is-invalid' : '';
        $attr = $this->attribute;
        $type = $this->type;
        $value = $this->model->{$this->attribute};
        return <<<INPUT
        <input type="$type" name="$attr" id="$attr" value="$value" class="form-control $is_invalid">
INPUT;
    }
}