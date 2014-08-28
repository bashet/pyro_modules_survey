<div id="programme_request-container">
    <p></p>
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

        <div class="tab-content">
            <div id="new_request" class="tab-pane fade in active">
                <table class="table table-bordered table-striped table-responsive">
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
                            echo '<td style="text-align: center"><button class="btn btn-xs btn-info"><i class="fa fa-check"></i></button></td>';
                            echo '</tr>';
                            $i++;
                        }

                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div id="approved_request" class="tab-pane fade">
                <table class="table table-bordered">
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

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>