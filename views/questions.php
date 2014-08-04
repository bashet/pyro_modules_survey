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
                            <?php $options = get_option_by_question_id($q->id)?>
                            <div style="float: right">
                                <a href="{{url:site}}survey/edit_question/<?=$survey_id.'/'.$q->id?>" class="btn btn-warning" title="Edit"><span class="fa fa-edit fa-2x"></span></a>
                                <a delete_question id="delete_question-<?=$q->id?>" class="btn btn-danger" title="Delete"><span class="fa fa-trash-o fa-2x"></span></a>
                            </div>
                            <table class="table q_table">
                                <tr>
                                    <th>Description</th>
                                    <td><?=$q->description?></td>
                                </tr>
                                <tr>
                                    <th>Key Matters</th>
                                    <td><?=$q->matter?></td>
                                </tr>
                                <tr>
                                    <th>Text for 1st person</th>
                                    <td><?=$q->text1?></td>
                                </tr>
                                <tr>
                                    <th>Text for 3rd person</th>
                                    <td><?=$q->text2?></td>
                                </tr>
                                <tr>
                                    <th>Option 1</th>
                                    <td><?=$options->option_1_label .' - '.$options->option_1?></td>
                                </tr>
                                <tr>
                                    <th>Option 2</th>
                                    <td><?=$options->option_2_label .' - '.$options->option_2?></td>
                                </tr>
                                <tr>
                                    <th>Option 3</th>
                                    <td><?=$options->option_3_label .' - '.$options->option_3?></td>
                                </tr>
                                <tr>
                                    <th>Option 4</th>
                                    <td><?=$options->option_4_label .' - '.$options->option_4?></td>
                                </tr>
                            </table>
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