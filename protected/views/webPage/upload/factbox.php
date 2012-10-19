<?php

	if($upload->factboxType =="link") {
?>
		<div class="link">
			<?php echo $parser->transform($upload->text); ?>
		</div>

<?php
        } elseif($upload->factboxType =="file") {
?>
		<div class="file">
			<?php echo $parser->transform($upload->text); ?>
		</div>

<?php
        } elseif($upload->factboxType =="deadline") {
?>
		<div class="deadline">
			<?php echo $parser->transform($upload->text); ?>
		</div>

<?php
	} else {
?>
		<div class="block w5">
                <?php if($upload->title != "") { ?>
                    <a name="<?php echo Util::friendlify($upload->title); ?>"></a>
                <?php } ?>
                <?php if($upload->title != "") {?>
                    <?php if(substr($upload->title, 0, 1)=='#') { ?>
                        <?php echo $parser->transform($upload->title); ?>
                    <?php } else { ?>
			<h3><?php echo $upload->title; ?></h3>
                    <?php } ?>
                <?php } ?>
			<?php echo $parser->transform($upload->text); ?>
		</div>
<?php
	}
?>
