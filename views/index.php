<div id="survey-container">

    <div style="">
        <button class="btn btn-primary" data-toggle="modal" data-target="#update_survey"><span class="icon-plus"></span> Add new survey</button>
    </div>
    <table id="all_survey" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th style="width: 8%">SN</th>
            <th style="width: 30%">Name</th>
            <th style="width: 40%">Description</th>
            <th style="width: 10%">Edit</th>
            <th style="width: 10%">Delete</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        foreach($survey as $d){
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$d->name.'</td>';
            echo '<td>'.$d->description.'</td>';
            echo '<td style="text-align: center"><button edit_survey id="edit_survey-'.$d->id.'" title="Edit this item"><i class="fa fa-pencil-square-o fa-lg"></i></button></td>';
            echo '<td style="text-align: center"><button delete_survey id="del_survey-'.$d->id.'" title="Delete this item"><i class="fa fa-trash-o fa-lg"></i></button></td>';
            echo '</tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="update_survey" tabindex="-1" role="dialog" aria-labelledby="update_surveyLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_surveyLabel">Update survey information</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="frm_manage_survey" method="post" action="{{url:site}}survey/save_survey">
                        <div class="form-group">
                            <label for="survey_name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="survey_name" name="survey_name" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="survey_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="survey_description" name="survey_description" placeholder=""></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="survey_id" name="survey_id" value="">
                        <input type="hidden" id="user_id" name="user_id" value="{{ user:id }}">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="survey_popup_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_survey">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="dialog-confirm" class="hide">
        <div class="alert alert-info bigger-110">
            These items will be permanently deleted and cannot be recovered.
        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
            <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
            Are you sure?
        </p>
    </div><!-- #dialog-confirm -->

</div>