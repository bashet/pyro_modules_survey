<div id="questions-container">

    <div style="padding-bottom: 10px">
        <?php
        if($survey_id){
            echo '<a href="{{ url:site }}survey/add_new_question/'.$survey_id.'" class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }else{
            echo '<a class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }
        ?>

    </div>

    <div id="question_categories">
        <?php
        if($categories){
            foreach($categories as $cat){
                echo '<h3>'.$cat->name.'</h3>';
                echo '<div>';
                echo '<div question id="q_cat-'.$cat->id.'">';
                if($questions){
                    $i = 1;
                    foreach($questions as $q){
                        if($cat->id == $q->cat_id){
                            echo '<h3>'.$i.' - '.$q->title.'</h3>';
                            echo '<div>';
                            ?>
                            <div class="row">
                                <div class="col-sm-2">Description</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$q->description?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">Key Matters</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$q->matter?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">Text for 1st person</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$q->text1?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">Text for 3rd person</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$q->text2?></p></div>
                            </div>
                            <?php $options = get_option_by_question_id($q->id)?>
                            <div class="row">
                                <div class="col-sm-2">Option 1</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$options->option_1?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">Option 2</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$options->option_2?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">Option 3</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$options->option_3?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">Option 4</div>
                                <div class="col-sm-10"><p class="form-control-static"><?=$options->option_4?></p></div>
                            </div>
                            <?php
                            echo '</div>';
                            $i++;
                        }else{

                        }
                    }
                }
                echo '</div>';
                echo '</div>';
            }
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