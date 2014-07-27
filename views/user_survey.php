<div id="user_survey-container">
    <?php
    if(($total_evaluators) && $total_evaluators >= 3){
        if($questions){
            $i = 1;
            foreach($questions as $q){
                $answer = get_answers_by_q_id($q->id);
                echo '<div id="q-'.$q->id.'" class="question">';
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
                echo '<td style="text-align:center"><input type="radio" name="q_answer-'.$q->id.'" value="1"></td>';
                echo '<td style="text-align:center"><input type="radio" name="q_answer-'.$q->id.'" value="2"></td>';
                echo '<td style="text-align:center"><input type="radio" name="q_answer-'.$q->id.'" value="3"></td>';
                echo '<td style="text-align:center"><input type="radio" name="q_answer-'.$q->id.'" value="4"></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>'.$answer->option_1.'</td>';
                echo '<td>'.$answer->option_2.'</td>';
                echo '<td>'.$answer->option_3.'</td>';
                echo '<td>'.$answer->option_4.'</td>';
                echo '</tr>';
                echo '</table>';

                echo '<div class="q_button" style="float: right">';
                echo '<button><i class="fa fa-angle-double-left"></i> Previous</button>';
                echo '<span>Question '.$i.' of '.$total_questions.'</span>';
                echo '<button>Save <i class="fa fa-angle-double-right"></i></button>';
                echo '</dive>';
                echo '</div>';
                $i++;
            }
        }
    }else{
        echo '<h2>You have not nominated enough evaluators</h2>
<p>Once you have nominated at least 3 evaluators you will be able to complete the questions</p>';
    }
    ?>

</div>