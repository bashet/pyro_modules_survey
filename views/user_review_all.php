<div id="user_review_all-container">
    <?php if($ex_ans->submitted){?>
        <h2>Your responses have now been submitted</h2>
        <p>Once your evaluators have submitted their responses you will be able to generate your report.</p>
    <?php }else{?>
    <h2>You have now given a response to each of the questions</h2>
    <p>The table below allows you to check your responses for each one. If you wish to check or edit any of your responses
        please select the appropriate edit button on the right side of the table.</p>
    <p>Once you are happy with your responses please select 'Submit' below.</p>
    <?php }?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>SN</th>
            <th>Question</th>
            <th>Answer</th>
            <?php
            if(! $ex_ans->submitted){
                echo '<th>Edit</th>';
            }
            ?>

        </tr>
        </thead>
        <?php
        $i = 1;
        if($questions){
            foreach($questions as $q){
                $answer = get_answers_by_q_id($q->id);
                $q_id = $q->id;
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$q->text1.'</td>';
                if(isset($my_answer->$q_id)){
                    if($my_answer->$q_id == 1){
                        echo '<td><strong>Level 1:</strong>&NonBreakingSpace;'.$answer->option_1_label.'</td>';
                    }elseif($my_answer->$q_id == 2){
                        echo '<td><strong>Level 2:</strong>&NonBreakingSpace;'.$answer->option_2_label.'</td>';
                    }elseif($my_answer->$q_id == 3){
                        echo '<td><strong>Level 3:</strong>&NonBreakingSpace;'.$answer->option_3_label.'</td>';
                    }elseif($my_answer->$q_id == 4){
                        echo '<td><strong>Level 4:</strong>&NonBreakingSpace;'.$answer->option_4_label.'</td>';
                    }else{
                        echo '<td></td>';
                    }
                }else{
                    echo '<td></td>';
                }
                if(! $ex_ans->submitted)
                echo '<td><a href="{{ url:site }}survey/user_review_single/'.$i.'/'.$q->id.'"><span class="glyphicon glyphicon-pencil"></span></a></td>';
                echo '</tr>';
                $i++;
            }
        }
        ?>
        <tbody>

        </tbody>
    </table>
    <?php if(! $ex_ans->submitted){?>
    <div style="float: right">
        <button class="btn btn-primary" id="submit_answer" <?php echo (! $ex_ans->finished)?'disabled':'';?>>Submit <span class="glyphicon glyphicon-circle-arrow-right"></span></button>
    </div>
    <?php }?>

</div>

<div id="dialog-confirm" class="hide">
    <div class="alert alert-info bigger-110">
        You are about to submit your response. This action can not be undo!
    </div>

    <div class="space-6"></div>

    <p class="bigger-110 bolder center grey">
        <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
        Are you sure?
    </p>
</div><!-- #dialog-confirm -->