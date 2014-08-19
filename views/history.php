<div id="history-container">
    <h2>Diagnostics for <?php echo $user->first_name . ' ' . $user->last_name; ?></h2>
    <div class="well well-sm">
        <p>Please find below all diagnostics for {{ if user:group == 'user' }}you {{ else }}<?php echo $user->first_name . ' ' . $user->last_name; ?>{{endif}}</p>

        <p><strong>NB: Please avoid opening multiple diagnostics simultaneously</strong></p>
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