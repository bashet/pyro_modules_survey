<div id="history-container">
    <h2>Previous diagnostic details for <?php echo $user->first_name . ' ' . $user->last_name; ?></h2>
    <div class="well well-sm">
        <p>Here is a list of all the diagnostic tools {{ if user:group == 'user' }}you have {{ else }}<?php echo $user->first_name . ' ' . $user->last_name; ?> has {{endif}} previously accessed during your courses. Additional diagnostics will be available through your learning schedule</p>

        <p><strong>NB: do not open multiple diagnostics simultaneously as this may cause errors</strong></p>
    </div>
    <table class="table table-bordered table-hove">
        <thead>
        <tr>
            <th>SN</th>
            <th>Name of the diagnostic</th>
            <th>Start date</th>
            <th>Participant completed</th>
            <th>Participant submitted</th>
            <th>Completion date</th>
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
                echo '<td>'.get_report_pdf($history).'</td>';
                echo '</tr>';
                $i++;
            }
        }
        ?>
        </tbody>
    </table>
</div>