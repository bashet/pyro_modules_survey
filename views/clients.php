<div id="clients-container">

    <div style="">
        <button class="btn btn-primary" data-toggle="modal" data-target="#update_clients"><span class="icon-plus"></span> Add new clients</button>
    </div>
    <table id="all_clients" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th style="width: 8%">SN</th>
            <th>Name</th>
            <th style="width: 20%">Manager</th>
            <th style="width: 10%">Edit</th>
            <th style="width: 10%">Active</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        foreach($clients as $d){
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$d->name.'</td>';
            echo '<td style="text-align: center"><a href="#" assign_manager id="assign_manager-'.$d->id.'" title="Assign Manager" style="text-decoration:none"><i class="fa fa-sitemap fa-lg"></i>&nbsp;&nbsp; '.get_manager($d->manager_uid).'</a></td>';
            echo '<td style="text-align: center"><a href="#" edit_clients id="edit_clients-'.$d->id.'" title="Edit '.$d->name.'"><i class="fa fa-pencil-square-o fa-lg"></i></a></td>';
            if($d->active){
                echo '<td style="text-align: center"><a activate href="{{ url:site }}survey/update_client_status/'.$d->id.'" id="del_clients-'.$d->id.'" title="Click to de-activate '.$d->name.'"><span class="glyphicon glyphicon-ok"></span></a></td>';
            }else{
                echo '<td style="text-align: center"><a activate href="{{ url:site }}survey/update_client_status/'.$d->id.'" id="del_clients-'.$d->id.'" title="Click to activate '.$d->name.'"><span class="glyphicon glyphicon-remove"></span></a></td>';
            }
            echo '</tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="update_manager_modal" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_clientsLabel">Update clients information</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="frm_update_manager" method="post" action="{{url:site}}survey/update_manager">
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

    <div class="modal fade" id="update_clients" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_clientsLabel">Assign Manager</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="frm_manage_clients" method="post" action="{{url:site}}survey/save_clients">
                        <div class="form-group">
                            <label for="client_name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client_name" name="client_name" placeholder="">
                            </div>
                        </div>

                        <input type="hidden" id="client_id_to_edit" name="client_id" value="">
                        <input type="hidden" id="user_id" name="user_id" value="{{ user:id }}">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="clients_popup_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_clients">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>