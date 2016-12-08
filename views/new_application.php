<div id="new_application-container">
    <br><br>
    <div class="well well-lg">
        <?php if($application){ ?>
            <div class="alert alert-danger">
                <p>You have already submitted an application for a new programme. You are not allowed to make another application until current one has been approved.</p>
                <p>Please contact your organisation manager to approve your current application.</p>
            </div>

        <?php }else{ ?>
        <p>I agree that in applying for a new 360 Diagnostic programme,
            any active surveys will be closed and that any completed Diagnostic surveys will be archived but accessible in the Overview section</p>

        <button class="btn btn-large btn-purple" data-toggle="modal" data-target="#apply_new_programme_modal">Apply for new programme</button>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="apply_new_programme_modal" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="update_clientsLabel">Apply for new programme</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frm_new_programme_application" method="post" action="{{url:site}}survey/new_programme_application">

                    <div class="form-group">
                        <label for="new_programme_id" class="col-sm-4 control-label">Select programme</label>
                        <div class="col-sm-8">
                            <select name="programme_id" id="new_programme_id" class="form-control">
                                <option value="0"></option>
                                <?php
                                foreach($programmes as $p){
                                    if( ! is_programme_used($p->programme_id, $participation)){
                                        echo '<option value="'.$p->programme_id.'">'.get_programme_name_by_id($p->programme_id).'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="client_id" value="<?=$client->id?>">
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="popup_close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_apply_new_programme">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php //var_dump($participation, $programmes);?>

