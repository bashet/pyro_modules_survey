<div id="clients-container">

    <div style="">
        <button class="btn btn-primary" data-toggle="modal" data-target="#update_clients"><span class="icon-plus"></span> Add new organisation</button>
    </div>
    <table id="all_clients" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th data-class="expand" class="center">SN</th>
            <th>Name</th>
            <th data-hide="phone">Logo</th>
            <th data-hide="phone" class="center"></th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        foreach($clients as $d){

            echo '<tr>';
            echo '<td class="center">'.$i.'</td>';
            echo '<td><a href="{{url:site}}survey/client/'.$d->id.'">'.$d->name.'</a></td>';
            echo '<td class="center">
                        <button set_logo
                            id="set_logo-'.$d->id.'"
                            style="text-decoration:none"
                            class="btn btn-link btn-xs"
                            data-toggle="modal"
                            data-target="#mdl_upload_logo"
                            title="'.(($d->logo)?'&lt;img src=&quot;'.$this->config->base_url().'index.php/files/thumb/'.$d->logo.'&quot; /&gt;':'Default logo used').'">
                                <span class="glyphicon glyphicon-picture" '.(($d->logo) ? '' : 'style="color:red"' ).'></span>
                        </button>
                </td>';

            echo '<td class="center"><div class="btn-group" role="group" aria-label="...">';
            echo '<button type="button" class="btn btn-warning btn-xs" edit_clients id="edit_clients-'.$d->id.'" title="Edit '.$d->name.'"><i class="fa fa-pencil-square-o fa-lg"></i></button>';
	        echo '<button type="button" class="delete_clients btn btn-danger btn-xs" id="delete_clients-'.$d->id.'" title="Delete '.$d->name.'"><i class="fa fa-trash-o fa-lg"></i></button>';
            if($d->active){
                echo '<button type="button" activate class="btn btn-primary btn-xs" id="client-'.$d->id.'-'.$d->active.'" title="Click to de-activate '.$d->name.'"><span class="glyphicon glyphicon-ok"></span></button>';
            }else{
                echo '<button type="button" activate class="btn btn-primary btn-xs" id="client-'.$d->id.'-'.$d->active.'" title="Click to activate '.$d->name.'"><span class="glyphicon glyphicon-remove red"></span></button>';
            }
            echo '<a href="'.$this->config->base_url().'index.php/survey/export_user/'.$d->id.'" class="btn btn-purple btn-xs"><span class="glyphicon glyphicon-export"></span></a>';
            echo '</div>';

            echo '</td>';
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
                    <h4 class="modal-title" id="update_clientsLabel">Assign Manager</h4>
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
                                        if(is_valid_manager($man->id)){
                                            echo '<option value="'.$man->id.'">'.$man->display_name.'</option>';
                                        }
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
                    <h4 class="modal-title" id="update_clientsLabel">Update organisation information</h4>
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


<!-------------------------------------------------------------------------------------------------------->
<div id="dialog-confirm" class="hide">
    <div class="alert alert-info bigger-110">
        You are about to <span id="client_activation"></span> an institute.
    </div>

    <div class="space-6"></div>

    <p class="bigger-110 bolder center grey">
        <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
        Are you sure?
    </p>
</div><!-- #dialog-confirm -->

<div class="modal fade" id="mdl_upload_logo" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="update_clientsLabel">Update organisation logo</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frm_upload_logo" method="post" action="{{url:site}}survey/set_logo">
                    <?php //print_r($folders_tree)?>
                    <div class="form-group">
                        <label for="client_name" class="col-sm-4 control-label">Select Logo</label>
                        <div class="col-sm-8">
                            <select id="folder_select" class="form-control" name="folder">
                                <option value=""></option>
                                <?php
                                foreach($file_folders as $folder){
                                    $indent = repeater('&raquo; ', $folder->depth);
                                    echo '<option value="'.$folder->id.'">'.$indent.$folder->name.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form_inputs" id="survey-folder">
                        <h3>Images</h3>
                        <fieldset>
                            <div id="image_list">

                            </div>
                        </fieldset>
                        <hr>
                        <label><input type="radio" name="image" value="default">Set default</label>
                    </div>

                    <input type="hidden" id="client_id_to_set_logo" name="client_id" value="">
                    <input type="hidden" id="user_id" name="user_id" value="{{ user:id }}">
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="clients_popup_logo_close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_clients_logo">Save changes</button>
            </div>
        </div>
    </div>
</div>