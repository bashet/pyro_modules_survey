<div id="report-container">
    <?php
    if($all_submitted){?>

        <h2 class="center">Personal Feedback Report</h2>

        <center><a href="{{ url:site }}survey/view_report/<?php echo $attempt->id;?>" target="_blank">{{ theme:image file="PDFIcon.png" width="120px" }}</a></center>

    <?php }elseif($self_submit){ ?>

        <div class="alert alert-info"><h2 class="center"> Report unavailable</h2></div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Report Status</h4>
                    </div>
                    <div class="modal-body">
                        Report will be eligible for publication once the self-assessment has been completed and a minimum of 3 evaluator contributions have been submitted.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    <?php }else{ ?>
        <div class="alert alert-info"><h2 class="center"> Report unavailable</h2></div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Report Status</h4>
                    </div>
                    <div class="modal-body">
                        Report will be eligible for publication once the self-assessment has been completed and a minimum of 3 evaluator contributions have been submitted.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script>
        $(function () {
            $('#myModal').modal('show');
        });
    </script>


</div>