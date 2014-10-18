<div id="history-container">
    <div class="container-fluid">
        <h2>Diagnostics for <?php echo $user->first_name . ' ' . $user->last_name; ?></h2>
        <div style="float: right">Attempt Remaining: <input id="allow_attempt-<?php echo $user->user_id;?>" class="allow_attempt" value="<?php echo $attempt_remaining;?>" allow_attempt></div>
    </div>


    <div class="well well-sm">
        <p>Please find below all diagnostics for {{ if user:group == 'user' }}you {{ else }}<?php echo $user->first_name . ' ' . $user->last_name; ?>{{endif}}</p>

        <p><strong>NB: Please avoid opening multiple diagnostics simultaneously</strong></p>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SN</th>
                <th>Name of the diagnostic</th>
                <th>Start date</th>
                <th>Participant completed</th>
                <th>Participant submitted</th>
                <th>Completion date (user)</th>
                <th>Evaluators</th>
                <th>Report</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($user_history){
                $i = 1;
                foreach($user_history as $history){
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$history->programme_name.'</td>';
                    echo '<td>'.date('d/m/Y', $history->start_date).'</td>';
                    if($history->finished){
                        echo '<td style="text-align:center; color: #008000"><i class="fa fa-check"></i></td>';
                    }else{
                        echo '<td style="text-align:center; color: red"><i class="fa fa-times"></i></td>';
                    }

                    if($history->submitted){
                        echo '<td style="text-align:center; color: #008000"><i class="fa fa-check"></i></td>';
                    }else{
                        echo '<td style="text-align:center; color: red"><i class="fa fa-times"></i></td>';
                    }

                    echo '<td>'.(($history->submit_date)? date('d/m/Y', $history->submit_date):'').'</td>';
                    echo '<td>'.get_submitted_evaluators($history->id).'/'.get_total_evaluators_by_attempt_id($history->id).'</td>';
                    echo '<td>'.get_report_pdf($history).'</td>';
                    echo '</tr>';
                    $i++;
                }
            }
            ?>
            </tbody>
        </table>
    </div>

</div>
<!--<div id="targetDiv" style="width: 100%"></div>-->