<?php if(count($error) >0): ?>
<ul>
    <?php foreach($error as $e): ?>
        <li><?php echo $e; ?></li>
    <?php endforeach; ?>
</ul>
<?php elseif(Util::GetPost('pwd') != null): ?>
    <p>Your password has been changed</p>
    <p>Go to <a href="/">frontpage</a> and press "Add project"</p>
<?php endif; ?>

<?php if($showForm): ?>
    <form method="POST">
        <input type="hidden" name="key" value="<?php echo Util::Get('key'); ?>"/>
        Password :<input type="password" name="pwd" />
        Same password again :<input type="password" name="cpwd" />
        <input type="submit" value="Change password" />
    </form>
<?php endif; ?>

    