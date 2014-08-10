<div id="questions-container">

    <div style="padding-bottom: 10px">
        <?php
        if($survey_id){
            if($survey->q_cat){
                echo '<a href="{{ url:site }}survey/add_new_question/'.$survey_id.'" class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
            }else{
                echo '<button class="btn btn-info" data-toggle="modal" data-target="#no_category"><span class="icon-plus"></span> Add new question</button>';
            }
            echo '<button class="btn btn-info" data-toggle="modal" data-target="#add_category"><span class="icon-plus"></span> Add category</button>';

        }else{
            echo '<a class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
            echo '<button class="btn btn-info"><span class="icon-plus"></span> Add category</button>';
        }
        ?>

    </div>

    <div id="question_categories">
        <?php
        $cat = json_decode($survey->q_cat);
        if($cat){
            foreach($cat as $c){

            }
        }else{
            echo 'Please add question categories at first.';
        }

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