<?php
    /** @var $model \app\models\User*/
    $this->title = 'MVC Framework | Login';
?>
<h1 class="text-center m-3">Login to your account</h1>
<div class="login">
    <?php $form = \app\core\form\Form::begin('', "post") ?>
    <?= $form->field($model, 'email')->email() ?>
    <?= $form->field($model, 'password')->password() ?>
    <button type="submit" class="btn btn-primary mt-3">Login</button>
    <?php \app\core\form\Form::end() ?>
</div>