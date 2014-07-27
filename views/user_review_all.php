<div id="user_review_all-container">
    <h2>You have now given a response to each of the questions</h2>
    <p>The table below allows you to check your responses for each one. If you wish to check or edit any of your responses
        please select the appropriate edit button on the right side of the table.</p>
    <p>Once you are happy with your responses please select 'Submit' below.</p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>SN</th>
            <th>Question</th>
            <th>Answer</th>
            <th>Edit</th>
        </tr>
        </thead>
        <?php
        $i = 1;
        if($questions){
            foreach($questions as $q){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$q->text1.'</td>';
                echo '<td></td>';
                echo '<td><a href="{{ url:site }}user_review_single/'.$i.'/'.$q->id.'"><span class="glyphicon glyphicon-pencil"></span></a></td>';
                echo '</tr>';
            }
        }
        ?>
        <tbody>

        </tbody>
    </table>
    <div style="float: right">
        <button next class="btn btn-primary" id="submit_answer">Submit <span class="glyphicon glyphicon-circle-arrow-right"></span></button>
    </div>

</div>