<div id="evaluators-container">
    <h2>Evaluators</h2>
    <p>
        In order to complete the diagnostic and access your report, at least three evaluators will need to have
        submitted a response for each of the sixteen competencies.
        To get the most out of your report we would recommend trying to nominate at least 3 evaluators in each category.
    </p>

    <div id="number_of_evaluators_warning" style="display: none" class="alert alert-danger role="alert">

    </div>

    <form id="frm_save_evaluators" method="post" action="{{ url:site }}survey/save_evaluators">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th style="width: 10%">Evaluator</th>
                <th>Name</th>
                <th>Email</th>
                <th style="width: 15%">Relationship</th>
                <th>Progress</th>
                <th>Email Sent</th>
                <th>Send Email</th>
                <th>delete</th>
                <th>Copy Link</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i = 0; $i <= $allowed_evaluators; $i++){
                if($i < $total_evaluators){
                    foreach($evaluators as $e){
                        $i++;
                        echo    '<tr>';
                        echo    '<td style="text-align:center">'.$i.'</td>';
                        echo    '<td>'.$e->name.'</td>';
                        echo    '<td>'.$e->email.'</td>';
                        echo    '<td style="text-align:center">'.$e->relation.'</td>';
                        echo    '<td></td>';
                        echo    '<td></td>';
                        echo    '<td></td>';
                        echo    '<td></td>';
                        echo    '<td></td>';
                        echo    '</tr>';
                    }
                }else{
                    echo    '<tr>';
                    echo    '<td style="text-align:center">'.$i.'</td>';
                    echo    '<td><input type="text" name="evaluators_name-'.$i.'" id="evaluators_name-'.$i.'" class="form-control"></td>';
                    echo    '<td>
                            <div class="form-group" id="email-'.$i.'">
                                <input type="text" name="evaluators_email-'.$i.'" id="evaluators_email-'.$i.'" class="form-control">
                            </div>
                        </td>';
                    echo    '<td style="text-align:center">
                            <select name="relationship'.$i.'" id="relationship'.$i.'" class="form-control">
                                <option value="">Please select</option>
                                    <option value="Direct Report">Direct Report</option>
                                    <option value="Evaluator">Evaluator</option>
                                    <option value="Other">Other</option>
                            </select>
                        </td>';
                    echo    '</tr>';
                }


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
                <p style="font-size: 1.5em"><i class="fa fa-exclamation-triangle"></i></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="programme_popup_close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>