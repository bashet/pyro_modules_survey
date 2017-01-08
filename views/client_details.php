<h3>Organisation Details

</h3>
<div class="btn-group pull-right" role="group">
    <button id="btn_add_programme" class="btn btn-sm btn-inverse">Add Programmes</button>
    <button id="btn_add_manager" class="btn btn-sm btn-inverse">Add Managers</button>
</div>
<div class="container-fluid">
    <table class="table table-bordered">
        <tr>
            <th width="20%">Name</th>
            <td width="80%"><?= $client->name ?></td>
        </tr>
        <tr>
            <th>Managers</th>
            <td>
                <ul id="client_manager" class="list-group">
		            <?php
		            foreach ($client_managers as $manager){
			            echo '<li class="list-group-item">'
			                 . get_user_full_name($manager->manager_id)
			                 . ' <button id="'.$manager->client_id.'-'.$manager->manager_id.'" class="btn btn-xs btn-danger pull-right detach_manager"> <i class="icon-remove"></i> </button>  </li>';
		            }
		            ?>
                </ul>
            </td>
        </tr>
        <tr>
            <th>Programmes</th>
            <td>
                <ul id="client_programme" class="list-group">
                <?php
                foreach ($client_programmes as $programme){
                    echo '<li class="list-group-item">'
                         . get_programme_name_by_id($programme->programme_id)
                         . ' <button id="'.$programme->client_id.'-'.$programme->programme_id.'" class="btn btn-xs btn-danger pull-right detach_programme"> <i class="icon-remove"></i> </button>  </li>';
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

<div class="modal fade" id="mdlManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Programme</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frm_add_manager" method="post" action="{{url:site}}survey/add_client_manager">
                    <div class="form-group">
                        <label for="manager_id" class="col-sm-4 control-label">Add Manager</label>
                        <div class="col-sm-8">
                            <select name="manager_id" id="manager_id" class="form-control" required="required">
                                <option value=""></option>
								<?php
								foreach($managers as $manager){
									$exist = 0;
									foreach ($client_managers as $cm){
										if($cm->manager_id == $manager->id){
											$exist = 1;
										}
									}
									if (! $exist){
										echo '<option value="'.$manager->id.'">'.$manager->name.'</option>';
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
                <button id="btn_update_client_manager" type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>