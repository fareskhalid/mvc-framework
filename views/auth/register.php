<?php
/** @var $model \app\models\User */
    $this->title = 'MVC Framework | Register';

?>
<h1 class="text-center m-3">Create a new account</h1>
<div class="register">
    <?php $form = \app\core\form\Form::begin('', "post") ?>
        <?php echo $form->field($model, 'name') ?>
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'email')->email() ?>
        <?php echo $form->field($model, 'password')->password() ?>
        <?php echo $form->field($model, 'passwordConfirm')->password() ?>
        <button type="submit" class="btn btn-success mt-3">Register</button>
    <?php \app\core\form\Form::end() ?>
</div>