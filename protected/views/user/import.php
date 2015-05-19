<h2>Import / Update students</h2>

<div class="actionBar simple">
    [<?php echo CHtml::link('User List',array('list')); ?>]
    [<?php echo CHtml::link('New User',array('create')); ?>]
    [<?php echo CHtml::link('Manage User',array('admin')); ?>]
    [<?php echo CHtml::link('Import/Update Students',array('import')); ?>]
</div>

<?php if(isset($result)): ?>
    <h3>Import finished!</h3>
    <table class="simple">
        <tr><td>Number of students in file</td><td><?php echo $result['total']; ?></td></tr>
        <tr><td>Newly imported students</td><td><?php echo $result['inserted']; ?></td></tr>
        <tr><td>Updated students</td><td><?php echo $result['updated']; ?></td></tr>
        <tr><td>Skipped students (master students)</td><td><?php echo $result['skipped']; ?></td></tr>
        <tr><td>Errors</td><td><?php echo count($result['errors']); ?></td></tr>
    </table>
    <?php if (!empty($result['errors'])) : ?>
        <h3 class="simple">Errors</h3>
        <table class="simple">
            <tr>
                <th>Row</th>
                <th>Message</th>
                <th>Student</th>
            </tr>
        <?php foreach ($result['errors'] as $error) : ?>
            <tr>
                <td><?php echo $error['row']; ?></td>
                <td><?php echo $error['msg']; ?></td>
                <td><?php echo $error["name"]; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <div class="simple">
        <?php echo CHtml::link('Back to form',array('import')); ?>
    </div>
<?php else: ?>
    <h3 class="simple">Upload Excel file</h3>
    <?php echo CHtml::form('','post', array('enctype'=>'multipart/form-data')); ?>
    <div class="simple">
        <?php echo CHtml::label('Graduation year','gradyear'); ?>
        <?php echo CHtml::textField("gradyear"); ?>
    </div>
    <div class="simple">
            <?php echo CHtml::label('Upload file','filePath'); ?>
            <?php echo CHtml::fileField("filePath"); ?>
    </div>
    <?php echo CHtml::submitButton('Upload'); ?>
    <?php echo CHtml::endForm(); ?>
<?php endif; ?>
