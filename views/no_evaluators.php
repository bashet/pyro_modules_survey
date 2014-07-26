<div id="evaluators-container">
    <h2>Evaluators</h2>
    <p>
        In order to complete the diagnostic and access your report, at least three raters will need to have
        submitted a response for each of the sixteen competencies.
        To get the most out of your report we would recommend trying to nominate at least 3 raters in each category.
    </p>
    <form id="save_evaluators" method="post" action="{{ url:site }}survey/save_evaluators">
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
            for($i = 1; $i <= 20; $i++){
                echo    '<tr>';
                echo    '<td style="text-align:center">'.$i.'</td>';
                echo    '<td><input type="text" name="evaluators_name-'.$i.'" id="evaluators_name-'.$i.'" class="form-control"></td>';
                echo    '<td><input type="email" name="evaluators_email-'.$i.'" id="evaluators_email-'.$i.'" class="form-control"></td>';
                echo    '<td style="text-align:center">
                            <select name="relationship'.$i.'" id="relationship'.$i.'" class="form-control">
                                <option value="0">Please select</option>
                                    <option value="1">Direct Report</option>
                                    <option value="2">Peer</option>
                                    <option value="3">Other</option>
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
</div>