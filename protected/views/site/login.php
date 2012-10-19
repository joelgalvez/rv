<?php $this->pageTitle=Yii::app()->name . ' - Login'; ?>

<div class="loginform">
<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($form); ?>

<div class="simple">
<?php echo CHtml::activeLabel($form,'email'); ?>
<?php echo CHtml::activeTextField($form,'username') ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabel($form,'password'); ?>
<?php echo CHtml::activePasswordField($form,'password') ?>
</div>

<div class="action">
<?php echo CHtml::activeCheckBox($form,'rememberMe'); ?>
<?php echo CHtml::activeLabel($form,'rememberMe'); ?>

<?php echo CHtml::submitButton('Login'); ?>
</div>


<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->

