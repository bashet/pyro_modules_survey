
<div id="content">
    <?php if($found){?>
    <iframe width="100%" height="100%" frameborder="0" src="<?php echo $file ;?>" />
    <?php }else{?>
    <iframe width="100%" height="100%" frameborder="0" src="<?php echo $base_url . 'index.php/survey/view_report/'. $attempt_id ;?>" />
    <?php }?>
</div>
