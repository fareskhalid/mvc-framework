<?php

namespace app\core\form;

class TextareaField extends BaseField
{

    public function renderInput(): string
    {
        $is_invalid = $this->model->hasError($this->attribute) ? 'is-invalid' : '';
        $attr = $this->attribute;
        $value = $this->model->{$this->attribute};
        return <<<INPUT
        <textarea name="$attr" class="form-control $is_invalid">$value</textarea>
INPUT;
    }
}