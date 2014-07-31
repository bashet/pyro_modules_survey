<div id="user_survey-container">
    <?php
    if(($total_evaluators) && $total_evaluators >= 3){
        if($q){
            //var_dump($my_answer);
            $answer = get_answers_by_q_id($q->id);
            echo '<div id="q-'.$q_no.'" class="question">';
                echo '<div class="q_header">';
                echo '<span>'.get_q_cat_name($q->cat_id).'-'.$q->title.'</span>';
                echo '</div>';

                echo '<div class="q_description">';
                echo '<p>'.$q->description.'</p>';
                echo '</div>';

                echo '<div class="q_matters">';
                echo '<p><strong>Why it matters</strong></p>';
                echo '<p>'.$q->matter.'</p>';
                echo '</div>';

                echo '<div class="q_key_question">';
                echo '<p><strong>Key Question:</strong>'.$q->text1.'</p>';
                echo '</div>';

                echo '<table class="table table-bordered">';
                echo '<tr>';
                $q_id = $q->id;
                echo '<td style="text-align:center"><input answer type="radio" name="q_answer-'.$q->id.'" value="1" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 1)?'checked':'').'></td>';
                echo '<td style="text-align:center"><input answer type="radio" name="q_answer-'.$q->id.'" value="2" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 2)?'checked':'').'></td>';
                echo '<td style="text-align:center"><input answer type="radio" name="q_answer-'.$q->id.'" value="3" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 3)?'checked':'').'></td>';
                echo '<td style="text-align:center"><input answer type="radio" name="q_answer-'.$q->id.'" value="4" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 4)?'checked':'').'></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>'.$answer->option_1.'</td>';
                echo '<td>'.$answer->option_2.'</td>';
                echo '<td>'.$answer->option_3.'</td>';
                echo '<td>'.$answer->option_4.'</td>';
                echo '</tr>';
                echo '</table>';
                echo '<div class="q_button" style="float: right">';
                    echo '<span>&nbsp;&nbsp;&nbsp;Question '.$q_no.' of '.$total_questions.'&nbsp;&nbsp;&nbsp;</span>';
                    echo '<a class="btn  btn-primary" href="{{ url:site }}survey/user_review_all">Save <span class="glyphicon glyphicon-circle-arrow-right"></span></a>';
                echo '</div>';
            echo '</div>';
        }
    }else{
        echo '<h2>You have not nominated enough evaluators</h2>
<p>Once you have nominated at least 3 evaluators you will be able to complete the questions</p>';
    }
    ?>

</div>
