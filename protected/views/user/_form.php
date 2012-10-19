<div class="yiiForm">

    <p>
        Fields with <span class="required">*</span> are required.
    </p>

    <?php echo CHtml::beginForm(); ?>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'email'); ?>
        <?php echo CHtml::activeTextField($model,'email',array('size'=>60,'maxlength'=>512)); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'password'); ?>
        <?php echo CHtml::activePasswordField($model,'password',array('size'=>60,'maxlength'=>512)); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'userId'); ?>
        <?php echo CHtml::activeTextField($model,'userId',array('size'=>60,'maxlength'=>256)); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'name'); ?>
        <?php echo CHtml::activeTextField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'year'); ?>
        <?php echo CHtml::activeTextField($model,'year'); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'friendlyName'); ?>
        <?php echo CHtml::activeTextField($model,'friendlyName'); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'graduated'); ?>
        <?php echo CHtml::activeCheckBox($model,'graduated'); ?>
    </div>


    <?php if($update): ?>
    <div class="simple">
            <?php echo CHtml::activeLabelEx($model,'active'); ?>
            <?php echo CHtml::activeCheckBox($model,'active'); ?>
    </div>
    <?php endif; ?>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'groupId'); ?>
        <?php $this->widget('application.components.ModelList',array(
            'model' => usergroup::model(),
            'formModel' => $model,
            'id' => 'groupId',
            'initialData' => array(),

        )); ?>
    </div>

    <div class="simple">
        Categories: <br/>
        <?php $this->widget('application.components.ModelList',array(
            'model' => category::model(),
            'formModel' => $model,
            'id' => 'categories',
            'condition' => 'parentId = 5',
            'view'=>'checkbox'
        )); ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("input[name='User\\[categories\\]\\[\\]']").change(function(){
                if($("input[name='User\\[categories\\]\\[\\]']:checked").length > 5)
                {
                    alert('only five categories are allowed');
                    this.checked = false;
                }
            })

        });
    </script>

    <div class="action">
        <?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->