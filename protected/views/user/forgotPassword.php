<?php if(count($error) >0): ?>
<ul>
    <?php foreach($error as $e): ?>
        <li><?php echo $e; ?></li>
    <?php endforeach; ?>
</ul>
<?php elseif(Util::GetPost('email') != null): ?>
    An link has been sent to you, please check your mail.
<?php endif; ?>

<form method="POST">
    Email : <input type="text" name="email" />
    <input type="submit" value="Send me my reset-password link" />
</form>
