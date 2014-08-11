<div id="questions-container">

    <div style="padding-bottom: 10px">
        <?php
        if($survey_id){
            if($survey->q_cat){
                echo '<a href="{{ url:site }}survey/add_new_question/'.$survey_id.'" class="btn btn-primary" ><span class="icon-question"></span> Add new question</a>';
            }else{
                echo '<button class="btn btn-primary" data-toggle="modal" data-target="#no_category"><span class="icon-question"></span> Add new question</button>';
            }
            echo '<button class="btn btn-primary" data-toggle="modal" data-target="#add_category"><span class="icon-sitemap"></span> Add category</button>';
            echo '<a href="{{ url:site }}survey/organise/'.$survey_id.'" class="btn btn-primary" ><span class="icon-reorder"></span> Organise questions</a>';

        }else{
            echo '<button class="btn btn-primary" disabled><span class="icon-plus"></span> Add new question</button>';
            echo '<button class="btn btn-primary" disabled><span class="icon-plus"></span> Add category</button>';
            echo '<button class="btn btn-primary" disabled><span class="icon-reorder"></span> Organise questions</button>';
        }
        ?>

    </div>

    <div id="question_categories">
        <?php
        if($survey->q_cat){
            $my_categories = json_decode($survey->q_cat);
            foreach($my_categories as $My_cat){
                $cat = get_category_by_id($My_cat);
                echo '<h3>'.$cat->name.'</h3>';
                echo '<div>';
                echo '<div question id="q_cat-'.$cat->id.'">';
                $questions = get_questions_by_category($cat->id);
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
                                    <td><?='<strong>'.$options->option_1_label .'</strong>'.$options->option_1?></td>
                                </tr>
                                <tr>
                                    <th>Option 2</th>
                                    <td><?='<strong>'.$options->option_2_label .'</strong>'.$options->option_2?></td>
                                </tr>
                                <tr>
                                    <th>Option 3</th>
                                    <td><?='<strong>'.$options->option_3_label .'</strong>'.$options->option_3?></td>
                                </tr>
                                <tr>
                                    <th>Option 4</th>
                                    <td><?='<strong>'.$options->option_4_label .'</strong>'.$options->option_4?></td>
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
        /*
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
                                    <td><?='<strong>'.$options->option_1_label .'</strong>'.$options->option_1?></td>
                                </tr>
                                <tr>
                                    <th>Option 2</th>
                                    <td><?='<strong>'.$options->option_2_label .'</strong>'.$options->option_2?></td>
                                </tr>
                                <tr>
                                    <th>Option 3</th>
                                    <td><?='<strong>'.$options->option_3_label .'</strong>'.$options->option_3?></td>
                                </tr>
                                <tr>
                                    <th>Option 4</th>
                                    <td><?='<strong>'.$options->option_4_label .'</strong>'.$options->option_4?></td>
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
        }*/
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_clientsLabel">Add question category</h4>
                </div>

                <form class="form-horizontal" role="form" id="frm_update_manager" method="post" action="{{url:site}}survey/add_qCat_to_survey">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <select name="category" id="category" class="form-control" required="required">
                                    <option value=""></option>
                                    <?php
                                    foreach($categories as $cat){
                                        echo '<option value="'.$cat->id.'">'.$cat->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="survey_id" value="<?=$survey_id?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="clients_popup_close" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn_update_manager">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="no_category" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_clientsLabel">No category</h4>
                </div>

                <div class="modal-body">
                    <div class="alert alert-error">
                        <p>There is no category found in this survey. Please add question categories at first.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="clients_popup_close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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