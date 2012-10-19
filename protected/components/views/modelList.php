<?php
// the view of the ModelList widget
?>

<?php if($view == 'dropdown'): ?>
    <?php echo CHtml::activeDropDownList($model,$id, $list, $options  ); ?>
<?php endif; ?>

<?php if($view == 'simpleDropdown'): ?>
    <?php echo CHtml::dropDownList($id, $defaultSelected, $list, $options  ); ?>
<?php endif; ?>

<?php if($view == 'simpleList'): ?>
    <?php echo CHtml::listBox($id, $defaultSelected, $list, $options ); ?>
<?php endif; ?>

<?php if($view == 'checkbox'): ?>
    <?php echo CHtml::activeCheckBoxList($model, $id, $list, $options ); ?>
<?php endif; ?>

<?php if($view == 'simpleCheckbox'): ?>
    <?php echo CHtml::checkBoxList($id, $defaultSelected, $list, $options ); ?>
<?php endif; ?>