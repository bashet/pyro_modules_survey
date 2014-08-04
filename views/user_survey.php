<div id="user_survey-container">
    <?php
    if(($total_evaluators) && $total_evaluators >= 3){
        if($questions){
            $i = 1;
            //var_dump($my_answer);
            foreach($questions as $q){
                $answer = get_answers_by_q_id($q->id);
                echo '<div id="q-'.$i.'" class="question">';
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
                echo '<td><strong>'.$answer->option_1_label.'</strong>'.$answer->option_1.'</td>';
                echo '<td><strong>'.$answer->option_2_label.'</strong>'.$answer->option_2.'</td>';
                echo '<td><strong>'.$answer->option_3_label.'</strong>'.$answer->option_3.'</td>';
                echo '<td><strong>'.$answer->option_4_label.'</strong>'.$answer->option_4.'</td>';
                echo '</tr>';
                echo '</table>';

                echo '<div class="q_button" style="float: right">';
                if($i > 1){
                    echo '<button pre class="btn btn-primary" id="btn_pre-'.$i.'"><span class="glyphicon glyphicon-circle-arrow-left"></span> Previous</button>';
                }

                echo '<span>&nbsp;&nbsp;&nbsp;Question '.$i.' of '.$total_questions.'&nbsp;&nbsp;&nbsp;</span>';
                if($i < $total_questions){
                    echo '<button next class="btn  btn-primary" id="btn_next-'.$i.'">Save <span class="glyphicon glyphicon-circle-arrow-right"></span></button>';
                }
                if($i == $total_questions){
                    echo '<a class="btn  btn-primary" href="{{ url:site }}survey/user_review_all">Save <span class="glyphicon glyphicon-circle-arrow-right"></span></a>';
                }

                echo '</div>';
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
