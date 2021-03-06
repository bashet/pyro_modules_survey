<div id="evaluators-container">
    <h2>Evaluators</h2>
    <p>
        In order to complete the diagnostic and access your report, at least three evaluators will need to have
        submitted a response for each of the competencies.
        To get the most out of your report we would recommend trying to nominate at least 3 evaluators in each category.
    </p>
    <div id="number_of_evaluators_warning" style="display: none" class="alert alert-danger role="alert">

    </div>
<?php if($attempt_remaining){?>
    <form id="frm_save_evaluators" method="post" action="{{ url:site }}survey/save_evaluators">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th style="width: 10%">Evaluator</th>
                <th>Name</th>
                <th>Email</th>
                <th style="width: 15%">Relationship</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i = 1; $i <= $allowed_evaluators; $i++){
                echo    '<tr>';
                echo    '<td style="text-align:center">'.$i.'</td>';
                echo    '<td><input type="text" name="name_'.$i.'" id="evaluators_name-'.$i.'" class="form-control"></td>';
                echo    '<td>
                            <div class="form-group" id="email-'.$i.'">
                                <input type="text" name="email_'.$i.'" id="evaluators_email-'.$i.'" class="form-control">
                            </div>
                        </td>';
                echo    '<td style="text-align:center">
                            <select name="relation_'.$i.'" id="relation_'.$i.'" class="form-control">
                                <option value="">Please select</option>
                                <option value="Line Manager">Line Manager</option>
                                <option value="Peer">Peer</option>
                                <option value="Team Members">Team Members</option>
                            </select>
                        </td>';
                echo    '</tr>';
            }
            ?>
            </tbody>
        </table>

        <div style="float: right">
            <button
                type="submit"
                name="submit_evaluators"
                id="submit_evaluators"
                class="btn btn-primary">
                Save <i class="fa fa-angle-double-right"></i>
            </button>
        </div>
    </form>
<?php }else{?>
    <div class="alert alert-danger">
        <p>Unfortunately you have completed all the number of attempts allocated to you. Please contact your organisation manager if you wish to do more attempt for this programme.</p>
    </div>
<?php } ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_warning_evaluators" tabindex="-1" role="dialog" aria-labelledby="update_programmeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="update_programmeLabel">Warning Message</h4>
            </div>

            <div class="modal-body" style="color: red">
                <p style="font-size: 1.5em"><i class="fa fa-exclamation-triangle"></i> <span id="modal_msg_body"></span></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="programme_popup_close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>