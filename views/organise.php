<div id="organise-container">
    <h2>Please drag each item and drop to set the new position.</h2>
    <div class="well well-lg">
        <div class="dd" id="<?php echo 'survey-'.$survey_id;?>">
            <ol class="dd-list">
                <?php
                if($survey->q_cat){
                    $categories = json_decode($survey->q_cat);
                    foreach($categories as $cat_key => $cat_value){
                        echo '<li class="dd-item" data-id="'.$cat_value.'">';
                        echo '<div class="dd-handle">'.get_q_cat_name($cat_value).'</div>';
                        $category  = get_category_by_id($cat_value);
                        $sort_order = json_decode($category->questions);
                        $questions = get_questions_by_category($cat_value);
                        if($questions){
                            echo    '<ol class="dd-list">';
                            foreach($sort_order as $order){
                                foreach($questions as $q){
                                    if($order == $q->id){
                                        echo '<li class="dd-item" data-id="'.$cat_value.'-'.$q->id.'">
                                            <div class="dd-handle">'.$q->title.'</div>
                                      </li>';
                                    }
                                }
                            }
                            echo '</ol>';
                        }
                        echo '</li>';
                    }
                }
                ?>
            </ol>
        </div>
    </div>
</div>