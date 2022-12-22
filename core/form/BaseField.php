<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    abstract public function renderInput(): string;
    public function __toString(): string
    {
        $input = $this->renderInput();
        $attr = $this->attribute;
        $label = $this->model->getLabel($this->attribute);
        return <<<INPUT
        <div class="form-group">
            <label for="$attr">$label</label>
            $input
            <div class="invalid-feedback">
                {$this->model->getFirstError($attr)}
            </div>
        </div>
INPUT;
    }
}