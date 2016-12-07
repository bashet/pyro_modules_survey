<h3>Organisation Details
<button id="btn_add_programme" class="btn btn-sm btn-purple pull-right">Add Programme</button>
</h3>
<div class="container-fluid">
    <table class="table table-bordered">
        <tr>
            <th width="20%">Name</th>
            <td width="80%"><?= $client->name ?></td>
        </tr>
        <tr>
            <th>Manager</th>
            <td><?=get_user_full_name($client->manager_uid)?></td>
        </tr>
        <tr>
            <th>Programmes</th>
            <td>
                <ul class="list-group">
                <?php
                foreach ($client_programmes as $programme){
                    echo '<li class="list-group-item">'.get_programme_name_by_id($programme->programme_id).' <button class="btn btn-xs btn-danger pull-right"> <i class="icon-remove"></i> </button>  </li>';
                }
                ?>
                </ul>
            </td>
        </tr>
    </table>
</div>

<div class="modal fade" id="mdlProgramme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Programme</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frm_add_programme" method="post" action="{{url:site}}survey/add_client_programme">
                    <div class="form-group">
                        <label for="programme_id" class="col-sm-4 control-label">Select Programme</label>
                        <div class="col-sm-8">
                            <select name="programme_id" id="programme_id" class="form-control" required="required">
                                <option value=""></option>
					            <?php
					            foreach($programmes as $programme){
					                $exist = 0;
					                foreach ($client_programmes as $cp){
					                    if($cp->programme_id == $programme->id){
					                        $exist = 1;
                                        }
                                    }
                                    if (! $exist){
	                                    echo '<option value="'.$programme->id.'">'.$programme->name.'</option>';
                                    }
					            }
					            ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="client_id" name="client_id" value="<?= $client->id ?>">
                    <input type="hidden" id="user_id" name="user_id" value="{{ user:id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn_update_client_programme" type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>