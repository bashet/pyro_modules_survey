<div id="user_survey-container">
    <?php
    //var_dump($survey);
    if(($total_evaluators) && ($total_evaluators >= 3) && ( ! $attempt->report_ready)){
        $categories = json_decode($survey->q_cat);
        if($categories){
            $i = 1;
            foreach($categories as $cat_id){
                $cat = get_category_by_id($cat_id);
                if($cat){
                    if($cat->questions){
                        $cat_questions = json_decode($cat->questions);
                        foreach($cat_questions as $question_id){
                            $q = get_question_by_id($question_id);
                            if($q){
                                $answer = get_answers_by_q_id($q->id);
                                echo '<div id="q-'.$i.'" class="question">';
                                echo '<div class="q_header">';
                                echo '<span>'.$cat->name.'-'.$q->title.'</span>';
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
	                            $q_id = $q->id;
	                            $col1 = '<input answer type="radio" name="q_answer-'.$q->id.'" value="1" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 1)?'checked':'').'>';
	                            $col2 = '<input answer type="radio" name="q_answer-'.$q->id.'" value="2" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 2)?'checked':'').'>';
	                            $col3 = '<input answer type="radio" name="q_answer-'.$q->id.'" value="3" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 3)?'checked':'').'>';
	                            $col4 = '<input answer type="radio" name="q_answer-'.$q->id.'" value="4" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 4)?'checked':'').'>';
	                            $col5 = '<input answer type="radio" name="answer-'.$q->id.'" value="1" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 1)?'checked':'').'>';
	                            $col6 = '<input answer type="radio" name="answer-'.$q->id.'" value="2" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 2)?'checked':'').'>';
	                            $col7 = '<input answer type="radio" name="answer-'.$q->id.'" value="3" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 3)?'checked':'').'>';
	                            $col8 = '<input answer type="radio" name="answer-'.$q->id.'" value="4" '.(isset($my_answer->$q_id) && ($my_answer->$q_id == 4)?'checked':'').'>';
                                echo '<tr class="hidden-sm hidden-xs">';
                                echo '<td style="text-align:center" width="25%">'.$col1.'</td>';
                                echo '<td style="text-align:center" width="25%">'.$col2.'</td>';
                                echo '<td style="text-align:center" width="25%">'.$col3.'</td>';
                                echo '<td style="text-align:center" width="25%">'.$col4.'</td>';
                                echo '</tr>';
                                echo '<tr class="hidden-sm hidden-xs">';
                                echo '<td><strong>'.$answer->option_1_label.'</strong>'.$answer->option_1.'</td>';
                                echo '<td><strong>'.$answer->option_2_label.'</strong>'.$answer->option_2.'</td>';
                                echo '<td><strong>'.$answer->option_3_label.'</strong>'.$answer->option_3.'</td>';
                                echo '<td><strong>'.$answer->option_4_label.'</strong>'.$answer->option_4.'</td>';
                                echo '</tr>';

                                echo '<tr class="hidden-md hidden-lg">';
	                            echo '<td style="text-align:center" width="25%">'.$col5.'</td>';
	                            echo '<td><strong>'.$answer->option_1_label.'</strong>'.$answer->option_1.'</td>';
	                            echo '</tr>';
	                            echo '<tr class="hidden-md hidden-lg">';
	                            echo '<td style="text-align:center" width="25%">'.$col6.'</td>';
	                            echo '<td><strong>'.$answer->option_2_label.'</strong>'.$answer->option_2.'</td>';
	                            echo '</tr>';
	                            echo '<tr class="hidden-md hidden-lg">';
	                            echo '<td style="text-align:center" width="25%">'.$col7.'</td>';
	                            echo '<td><strong>'.$answer->option_3_label.'</strong>'.$answer->option_3.'</td>';
	                            echo '</tr>';
	                            echo '<tr class="hidden-md hidden-lg">';
	                            echo '<td style="text-align:center" width="25%">'.$col8.'</td>';
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
                    }
                }
            }
        }
    }else{
        echo    '<h2>You have not nominated enough evaluators</h2>
                <p>Once you have nominated at least 3 evaluators you will be able to complete the questions</p>';
    }
    ?>

</div>
