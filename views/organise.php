<div id="organise-container">
    <h2>Please drag each item and drop to set the new position.</h2>
    <div class="well well-lg">
        <div class="dd">
            <ol class="dd-list">
                <?php
                if($survey->q_cat){
                    $categories = json_decode($survey->q_cat);
                    foreach($categories as $cat_key => $cat_value){
                        echo '<li class="dd-item" data-id="'.$cat_key.'">';
                        echo '<div class="dd-handle">'.get_q_cat_name($cat_value).'</div>';
                        $questions = get_questions_by_category($cat_value);
                        if($questions){
                            echo    '<ol class="dd-list">';
                            foreach($questions as $q){
                                echo '<li class="dd-item" data-id="'.$cat_key.'-'.$q->id.'">
                                            <div class="dd-handle">'.$q->title.'</div>
                                      </li>';
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