<div id="history-container">
    <h2>Previous diagnostic details for {{ user:display_name }}</h2>
    <div class="well well-sm">
        <p>Here is a list of all the diagnostic tools you have previously accessed during your courses. Additional diagnostics will be available through your learning schedule</p>

        <p><strong>NB: do not open multiple diagnostics simultaneously as this may cause errors</strong></p>
    </div>
    <table class="table table-bordered table-hove">
        <thead>
        <tr>
            <th>Name of the diagnostic</th>
            <th>Participant completed</th>
            <th>Participant submitted</th>
            <th>Report</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($user_history){
            foreach($user_history as $history){
                echo '<tr>';
                echo '<td>'.$history->survey_id.'</td>';
                echo '<td>'.(($history->finished)?'<i class="fa fa-check"></i>': '<i class="fa fa-times"></i>').'</td>';
                echo '<td>'.(($history->submitted)?'<i class="fa fa-check"></i>': '<i class="fa fa-times"></i>').'</td>';
                echo '<td></td>';
                echo '</tr>';
            }
        }
        ?>
        </tbody>
    </table>
</div>