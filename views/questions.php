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
        <div class="panel-group" id="accordion">
            <?php
            if($categories){
                foreach($categories as $cat){
                    echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading">';
                    echo '<h4 class="panel-title" data-toggle="collapse" data-target="#cat-'.$cat->id.'">'.$cat->name.'</h4>';
                    echo '</div>';
                    echo '<div id="cat-'.$cat->id.'" class="panel-collapse collapse">';
                    echo '<div class="panel-body">
// question will come here====================================================================================
                                Questions will come here.
// question end come here====================================================================================
                        </div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>

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