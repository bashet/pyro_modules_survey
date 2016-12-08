<div id="report-container">
    <?php
    if($all_submitted){?>

        <h2 class="center">Personal Feedback Report</h2>

        <center><a href="{{ url:site }}survey/view_report/<?php echo $attempt->id;?>" target="_blank">{{ theme:image file="DownloadPDF.gif" width="120px" }}</a></center>

    <?php }elseif($self_submit){ ?>

        <div class="alert alert-danger"><h2 class="center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Report unavailable</h2></div>

    <?php }else{ ?>
        <div class="alert alert-danger"><h2 class="center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Report unavailable</h2></div>
    <?php } ?>


</div>