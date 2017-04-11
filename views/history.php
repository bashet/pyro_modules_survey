<div id="history-container">
    <div class="container-fluid no-padding">
        <h2><?php echo $user->first_name . ' ' . $user->last_name; ?>
            {{ if user:group == 'admin' || user:group == 'manager'}}
            <a href="<?php echo site_url().'/survey/login/'.$user->id; ?>" class="btn btn-white pull-right"><i class="fa fa-power-off"></i> Login As</a>
            {{ endif }}
        </h2>
        {{ if user:group != 'user'}}
        <div style="float: right">Attempt Remaining: <input id="allow_attempt-<?php echo $user->user_id;?>" class="allow_attempt" value="<?php echo $attempt_remaining;?>" allow_attempt></div>
        {{ endif }}
    </div>


    <div class="alert alert-block alert-info">
        <p><strong>NB: Please avoid opening multiple diagnostics simultaneously</strong></p>
    </div>
    <div id="no-more-tables" class="">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SN</th>
                <th>Programme</th>
                <th>Organisation</th>
                <th>Reg Request</th>
                <th>Reg Approved</th>
                <th>Self-Assessment</th>
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
                    echo '<td data-title="SN">'.$i.'</td>';
                    echo '<td data-title="Programme">'.$history->programme_name.'</td>';
	                echo '<td data-title="Organisation">'.$org->name.'</td>';
	                echo '<td data-title="Reg Request">'. date('d/m/Y', $history->reg_date) .'</td>';
	                echo '<td data-title="Reg Approved">'.get_reg_approval_date($history->user_id, $history->programme_id).'</td>';
                    echo '<td data-title="Self-Assessment">'.(($history->submit_date)? date('d/m/Y', $history->submit_date):'').'</td>';
                    echo '<td data-title="Evaluators">'.get_submitted_evaluators($history->id).'/'.get_total_evaluators_by_attempt_id($history->id).'</td>';
                    echo '<td data-title="Report">'.get_report_pdf($history).'</td>';
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