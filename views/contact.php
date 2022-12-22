<?php
    /** @var $this \app\core\View */
    /** @var $model \app\models\ContactForm */

use app\core\form\Form;
use app\core\form\TextareaField;

$this->title = 'Contact';
?>
<h1 class="text-center">Send Us a Message</h1>
<?php $form = Form::begin('', 'post') ?>
    <?= $form->field($model, 'subject') ?>
    <?= $form->field($model, 'email') ?>
    <?= new TextareaField($model, 'body') ?>
    <button type="submit" class="btn btn-primary mt-3">Send</button>
<?php Form::end() ?>