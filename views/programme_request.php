<div id="programme_request-container">
    <p></p>
    {{ if user:group == 'manager' }}
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $client->name?></h2>
        </div>
	    <?php if(count($clients) > 1){ ?>
        <div class="col-md-6">
            <div class="form-group">
                <select id="switch_organisation" class="pull-right">
                    <option value="<?=$client->id?>"><?=$client->name?></option>
					<?php
					foreach ($clients  as $c){
						if($client->id != $c->client_id){
							echo '<option value="'. $c->client_id .'">'. get_client_name($c->client_id) .'</option>';
						}
					}
					?>
                </select>
            </div>
        </div>
	    <?php } ?>
    </div>
    <hr>
    {{ endif }}
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#new_request">
                    <i class="green ace-icon  glyphicon glyphicon-envelope bigger-120"></i>
                    New Request
                    <span class="badge badge-danger"><?=count($active_request)?></span>
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#approved_request">
                    <i class="green ace-icon glyphicon glyphicon-check bigger-120"></i>
                    Approved Request
                </a>
            </li>


        </ul>

        <div class="tab-content no-padding">
            <div id="new_request" class="tab-pane fade in active table-responsive">
                <table id="tbl_active_request" class="table table-bordered table-striped ">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        {{ if user:group == 'admin'}}
                        <th>Organisation</th>
                        {{ endif }}
                        <th>Current Programme</th>
                        <th>New Programme</th>
                        <th>History</th>
                        <th>Date Applied</th>
                        <th>Approve</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($active_request){
                        $i = 1;
                        foreach($active_request as $request){
                            $current_participation  = get_current_participation_by_user($request->user_id);
                            $programme              = get_programme_by_id($current_participation->pid);

                            echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.$request->name.'</td>';
                            echo '<td>'.$request->org_name.'</td>';
                            if($this->current_user->group == 'admin'){
                                echo '<td>'.$programme->name.'</td>';
                            }
                            echo '<td>'.$request->new_prog_name.'</td>';
                            echo '<td style="text-align: center"><a href="{{ url:site }}survey/history/'.$request->user_id.'" target="_blank"><span class="glyphicon glyphicon-list-alt"></span></td>';
                            echo '<td style="text-align: center">'.date('d/m/Y', $request->date_applied).'</td>';
                            echo '<td style="text-align: center"><button approve id="approve-'.$request->id.'" class="btn btn-xs btn-info"><i class="fa fa-check"></i></button>';
                            echo '<input type="hidden" id="user_name-'.$request->id.'" value="'.$request->name.'">';
                            echo '<input type="hidden" id="org_name-'.$request->id.'" value="'.$request->org_name.'">';
                            echo '<input type="hidden" id="pro_name-'.$request->id.'" value="'.$request->new_prog_name.'">';
                            echo '</td>';
                            echo '</tr>';



                            $i++;
                        }

                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div id="approved_request" class="tab-pane fade table-responsive">
                <table id="tbl_approved_request" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        {{ if user:group == 'admin'}}
                        <th>Organisation</th>
                        {{ endif }}
                        <th>Current Programme</th>
                        <th>New Programme</th>
                        <th>History</th>
                        <th>Date Applied</th>
                        <th>Approval Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($approved_request){
                        $i = 1;
                        foreach($approved_request as $request){
                            $current_participation  = get_current_participation_by_user($request->user_id);
                            $programme              = get_programme_by_id($current_participation->pid);

                            echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.$request->name.'</td>';
                            echo '<td>'.$request->org_name.'</td>';
                            if($this->current_user->group == 'admin'){
                                echo '<td>'.$programme->name.'</td>';
                            }
                            echo '<td>'.$request->new_prog_name.'</td>';
                            echo '<td style="text-align: center"><a href="{{ url:site }}survey/history/'.$request->user_id.'" target="_blank"><span class="glyphicon glyphicon-list-alt"></span></td>';
                            echo '<td style="text-align: center">'.date('d/m/Y', $request->date_applied).'</td>';
                            echo '<td style="text-align: center">'.date('d/m/Y', $request->approval_date).'</td>';
                            echo '</tr>';

                            $i++;
                        }

                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-------------------------------------------------------------------------------------------------------->
<div id="dialog-confirm-request_approval" class="hide">
    <div class="alert alert-info bigger-110">
        You are about to approve <strong><span id="dialog_user_name"></span></strong> from <span id="dialog_org_name"></span> to participate in <span id="dialog_pro_name"></span> !
    </div>

    <div class="space-6"></div>

    <p class="bigger-110 bolder center grey">
        <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
        Are you sure?
    </p>
</div><!-- #dialog-confirm -->