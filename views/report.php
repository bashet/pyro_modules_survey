<div id="report-container">
    <?php
    if($all_submitted){?>

        <h2>Your report</h2>
        <p>Your report is now available.</p>
        <center><a href="{{ url:site }}survey/view_report/<?php echo $attempt->id;?>" target="_blank">{{ theme:image file="DownloadPDF.gif" width="120px" }}</a></center>

    <?php }elseif($self_submit){ ?>

        <h2>Generate report</h2>

        <p>Not enough of your nominated evaluators have submitted their responses for you to be able to generate your report.
            You need to have at least 3 evaluators to have submitted their responses.</p>

        <p>You can select the 'Evaluator' link above to find out the status of all of your evaluators. On that page you can also
            send an email to prompt any evaluators who may not yet have submitted their responses.
        Before you generate you report you must first submit your responses.</p>

    <?php }else{ ?>
        <h2>Generate report</h2>

        <p>You haven't submitted your response.</p>

        <p>Before you generate you report you must first submit your responses.</p>
    <?php } ?>


</div>