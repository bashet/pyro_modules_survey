<div id="evaluators-container">
    <h2>Evaluators</h2>
    <p>
        A minimum of 3 evaluators are required to initiate and complete a 360 Diagnostic.
    </p>
    <p>To get the most out of your Diagnostic, we recommend nominating at least 3 evaluators from each relationship category.</p>

    <div id="number_of_evaluators_warning" style="display: none" class="alert alert-danger role="alert">

    </div>

    <form id="frm_save_evaluators" method="post" action="{{ url:site }}survey/update_evaluators">
        <table id="tbl_evaluators" class="table table-bordered table-hover ui-responsive table-stroke" data-role="table">
            <thead>
            <tr>
                <th data-breakpoints="xs">Evaluator</th>
                <th>Name</th>
                <th>Email</th>
                <th data-breakpoints="xs sm md">Relationship</th>
                <th data-breakpoints="xs sm">Progress</th>
                <th data-breakpoints="xs sm">Email Sent</th>
                <th data-breakpoints="xs sm">Send Email</th>
                <th data-breakpoints="xs sm md">delete</th>
                <th data-breakpoints="xs sm md">Copy Link</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i = 0; $i <= $allowed_evaluators; $i++){
                if($i < $total_evaluators){
                    foreach($evaluators as $e){
                        $i++;
                        echo    '<tr>';
                        echo    '<td class="center">'.$i.'</td>';
                        echo    '<td>'.$e->name.'</td>';
                        echo    '<td>'.$e->email.'</td>';
                        echo    '<td class="center">'.$e->relation.'</td>';
                        if($e->start_date == 0){
                            echo    '<td class="center">Not started</td>';
                        }elseif($e->submitted){
                            echo    '<td class="center">Submitted</td>';
                        }elseif($e->finished){
                            echo    '<td class="center">'.get_evaluator_progress($e->id).', but not submitted </td>';
                        }else{
                            echo    '<td class="center">'.get_evaluator_progress($e->id).'</td>';
                        }

                        if($e->re_email_sent){
                            echo    '<td class="center" style="color: #428bca"><i class="fa fa-check"></i></td>';
                        }else{
                            echo    '<td class="center" style="color: #428bca"><i class="fa fa-times"></i></td>';
                        }
                        $link        = $this->config->base_url().'index.php/survey/evaluator_response/'.$e->link_md5;
                        echo    '<td class="center"><a href="{{ url:site }}survey/send_email_to_single_evaluator/'.$e->link_md5.'" class="btn btn-link" style="text-decoration: none"><i class="fa fa-envelope"></i></a></td>';
                        echo    '<td class="center"><button delete_evaluator type="button" '.(($e->start_date)?'disabled':'').' id="'.$e->id.'-'.$e->name.'" class="btn btn-link" style="text-decoration: none;"><i class="fa fa-trash-o" '.((!$e->start_date)?'style="color:red"':'').'></i></button></td>';
                        //echo    '<td style="text-align:center"><button type="button" copy_link id="copy_link-'.$e->id.'" class="btn btn-link z-clip" style="text-decoration: none"><span class="glyphicon glyphicon-link"></span></button></td>';
                        //echo    '<td style="text-align:center"><a style="text-decoration: none" copy_this href="'.$link.'"><span class="glyphicon glyphicon-link"></span></a></td>';
                        echo    '<td class="center"><button copy_this id="'.$e->link_md5.'" class="btn btn-sm" value="'.$link.'" data-toggle="popover" data-trigger="focus" data-content="Link copied to clipboard!"><span class="glyphicon glyphicon-link"></span></button></td>';
                        echo    '<input id="link-'.$e->id.'" type="hidden" value="'.$link.'">';
                        echo    '</tr>';
                    }
                }else{
                    echo    '<tr>';
                    echo    '<td class="center">'.$i.'</td>';
                    echo    '<td><input type="text" name="name_'.$i.'" id="evaluators_name-'.$i.'" class="form-control"></td>';
                    echo    '<td>
                                <div class="form-group" id="email-'.$i.'">
                                    <input type="text" name="email_'.$i.'" id="evaluators_email-'.$i.'" class="form-control">
                                </div>
                            </td>';
                    echo    '<td class="center">
                                <select name="relation_'.$i.'" id="relation_'.$i.'" class="form-control">
                                    <option value="">Please select</option>
                                    <option value="Line Manager">Line Manager</option>
                                    <option value="Peer">Peer</option>
                                    <option value="Team Members">Team Members</option>
                                </select>
                            </td>';
                    echo    '<td></td>';
                    echo    '<td></td>';
                    echo    '<td></td>';
                    echo    '<td></td>';
                    echo    '<td></td>';
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
                <p style="font-size: 1.5em"><i class="fa fa-exclamation-triangle"></i> <span id="modal_msg_body"></span></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="programme_popup_close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="delete_evaluator_dialog_confirm" class="hide">
    <div class="alert alert-info bigger-110">
        <span id="ev_info"></span> will be deleted permanently.
    </div>

    <div class="space-6"></div>

    <p class="bigger-110 bolder center grey">
        <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
        Are you sure?
    </p>
</div><!-- #dialog-confirm -->
