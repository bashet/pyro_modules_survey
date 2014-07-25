
<div id="programme-container">

    <div style="">
        <button class="btn btn-primary" data-toggle="modal" data-target="#update_programme"><span class="icon-plus"></span> Add new programme</button>
    </div>
    <table id="all_programme" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th style="width: 8%">SN</th>
            <th style="width: 20%">Name</th>
            <th>Description</th>
            <th style="width: 15%">Survey</th>
            <th style="width: 8%">Edit</th>
            <th style="width: 8%">Delete</th>
            <th style="width: 8%">Active</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        foreach($programme as $d){
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$d->name.'</td>';
            echo '<td>'.$d->description.'</td>';
            echo '<td style="text-align: center"><button edit_survey id="edit_survey-'.$d->id.'" title="Change Survey"><i class="fa fa-comments"></i>'.get_survey_name_by_id($d->survey).'</button></td>';
            echo '<td style="text-align: center"><button edit_programme id="edit_programme-'.$d->id.'" title="Edit '.$d->name.'"><i class="fa fa-pencil-square-o fa-lg"></i></button></td>';
            echo '<td style="text-align: center"><button delete_programme id="del_programme-'.$d->id.'" title="Delete '.$d->name.'"><i class="fa fa-trash-o fa-lg"></i></button></td>';
            if($d->active){
                echo '<td style="text-align: center"><button activate id="active_programme-'.$d->id.'/'.$d->active.'" title="Click to de-activate '.$d->name.'"><span class="glyphicon glyphicon-ok"></span></button></td>';
            }else{
                echo '<td style="text-align: center"><button activate id="active_programme-'.$d->id.'/'.$d->active.'" title="Click to activate '.$d->name.'"><span class="glyphicon glyphicon-remove"></span></button></td>';
            }
            echo '</tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="update_survey_modal" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_clientsLabel">Link programme between survey</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="frm_link_level" method="post" action="{{url:site}}survey/link_level">
                        <div class="form-group">
                            <label for="manager_id" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <select name="manager_id" id="manager_id" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $managers = get_all_manager();
                                    foreach($managers as $man){
                                        echo '<option value="'.$man->id.'">'.$man->display_name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="client_id" name="client_id" value="">
                        <input type="hidden" id="user_id" name="user_id" value="{{ user:id }}">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="clients_popup_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_update_manager">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="update_programme" tabindex="-1" role="dialog" aria-labelledby="update_programmeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_programmeLabel">Update programme information</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="frm_manage_programme" method="post" action="{{url:site}}survey/save_programme">
                        <div class="form-group">
                            <label for="programme_name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="programme_name" name="programme_name" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="programme_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="programme_description" name="programme_description" placeholder=""></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="programme_id" name="programme_id" value="">
                        <input type="hidden" id="user_id" name="user_id" value="{{ user:id }}">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="programme_popup_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_programme">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="dialog-confirm" class="hide">
        <div class="alert alert-info bigger-110">
            <span id="item_name"></span>
        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
            <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
            Are you sure?
        </p>
    </div><!-- #dialog-confirm -->

</div>