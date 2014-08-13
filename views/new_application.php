<div id="new_application-container">
    <br><br>
    <div class="well well-lg">
        <p>by applying for new application, you are going to end your current programme. so be careful for what you are doing! more text more text more text
        blah blah blah more text more text more text more text more text more text more text more text more text more text more text more text
            more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text
            more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text</p>

        <button class="btn btn-large btn-purple" data-toggle="modal" data-target="#apply_new_programme_modal">I agree and apply for new programme</button>
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
                <form class="form-horizontal" role="form" id="frm_link_programme" method="post" action="{{url:site}}survey/new_programme_application">

                    <div class="form-group">
                        <label for="survey_id" class="col-sm-4 control-label">Select programme</label>
                        <div class="col-sm-8">
                            <select name="survey_id" id="survey_id" class="form-control">
                                <option value="0"></option>
                                <?php
                                foreach($programmes as $p){
                                    if( ! is_programme_used($p->id, $participation)){
                                        echo '<option value="'.$p->id.'">'.$p->name.'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
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

