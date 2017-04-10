<div id="question_categories-container">

    <div style="">
        <button class="btn btn-primary" data-toggle="modal" data-target="#update_question_categories"><span class="icon-plus"></span> Add new category</button>
    </div>
    <table id="all_question_categories" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th data-class="expand">SN</th>
            <th>Name</th>
            <th data-hide="phone,tablet">Description</th>
            <th>Questions</th>
            <th data-hide="phone">Edit</th>
            <th data-hide="phone">Delete</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        foreach($question_categories as $d){
            $total_questions = count(json_decode($d->questions, true));
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$d->name.'</td>';
            echo '<td>'.$d->description.'</td>';
            echo '<td style="text-align: center"><a href="{{url:site}}survey/questions_in_category/'.$d->id.'" title="Manage questions for '.$d->name.'"><button>'.$total_questions .'</button></a></td>';
            echo '<td style="text-align: center"><button class="btn btn-link" edit_question_categories id="edit_question_categories-'.$d->id.'" title="Edit '.$d->name.'"><i class="fa fa-pencil-square-o fa-lg"></i></button></td>';
            echo '<td style="text-align: center"><button '.(($total_questions)?'disabled':'').' class="btn btn-link" delete_question_categories id="del_question_categories-'.$d->id.'" title="Delete '.$d->name.'"><i class="fa fa-trash-o fa-lg"></i></button></td>';
            echo '</tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="update_question_categories" tabindex="-1" role="dialog" aria-labelledby="update_question_categoriesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_question_categoriesLabel">Update category information</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="frm_manage_question_categories" method="post" action="{{url:site}}survey/save_question_categories">
                        <div class="form-group">
                            <label for="question_categories_name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="question_categories_name" name="question_categories_name" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="question_categories_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="question_categories_description" name="question_categories_description" placeholder=""></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="question_categories_id" name="question_categories_id" value="">
                        <input type="hidden" id="user_id" name="user_id" value="{{ user:id }}">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="question_categories_popup_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_question_categories">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="dialog-confirm" class="hide">
        <div class="alert alert-info bigger-110">
            <span id="item_name"></span> category will be permanently deleted and cannot be recovered.
        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
            <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
            Are you sure?
        </p>
    </div><!-- #dialog-confirm -->

</div>