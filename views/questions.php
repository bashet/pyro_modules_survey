<div id="questions-container">

    <div style="padding-bottom: 10px">
        <?php
        if($survey_id){
            echo '<a href="{{ url:site }}survey/add_new_question/'.$survey_id.'" class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }else{
            echo '<a class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }
        ?>
        <button id="collapse-init" class="btn btn-primary">Disable accordion behavior</button>
    </div>

    <div id="question_categories">
        <?php
        if($categories){
            foreach($categories as $cat){
                echo '<h3>'.$cat->name.'</h3>';
                echo '<div><p>';
                echo '<div question id="q_cat-'.$cat->id.'">';
                if($questions){
                    foreach($questions as $q){
                        if($cat->id == $q->cat_id){
                            echo '<h3>'.$q->title.'</h3>';
                            echo '<div>';
                            echo $q->text1;
                            echo '</div>';
                        }else{

                        }
                    }
                }
                echo '</div>';
                echo '</p></div>';
            }
        }
        ?>
    </div>

    <div id="questions">
        <?php
        if($survey_id){
            if($questions){
                foreach($questions as $q){
                    //var_dump($q);
                }
            }else{
                echo 'There is no question available to show!';
            }
        }else{
            echo 'There is no question available to show!';
        }
        ?>
    </div>

    <div id="dialog-confirm" class="hide">
        <div class="alert alert-info bigger-110">
            question "<span id="item_name"></span>" will be permanently deleted and cannot be recovered.
        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
            <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
            Are you sure?
        </p>
    </div><!-- #dialog-confirm -->

</div>