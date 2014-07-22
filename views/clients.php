<div id="clients-container">

    <div style="">
        <button class="btn btn-primary" data-toggle="modal" data-target="#update_clients"><span class="icon-plus"></span> Add new clients</button>
    </div>
    <table id="all_clients" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th style="width: 8%">SN</th>
            <th>Name</th>
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
            echo '<td style="text-align: center"><a href="#" edit_clients id="edit_clients-'.$d->id.'" title="Edit '.$d->name.'"><i class="fa fa-pencil-square-o fa-lg"></i></a></td>';
            if($d->active){
                echo '<td style="text-align: center"><a href="{{ url:site }}survey/update_client_status/'.$d->id.'" id="del_clients-'.$d->id.'" title="Delete '.$d->name.'"><i class="fa fa-thumbs-up fa-lg"></i></a></td>';
            }else{
                echo '<td style="text-align: center"><a href="{{ url:site }}survey/update_client_status/'.$d->id.'" id="del_clients-'.$d->id.'" title="Delete '.$d->name.'"><i class="fa fa-thumbs-down fa-lg"></i></a></td>';
            }
            echo '</tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="update_clients" tabindex="-1" role="dialog" aria-labelledby="update_clientsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_clientsLabel">Update clients information</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="frm_manage_clients" method="post" action="{{url:site}}survey/save_clients">
                        <div class="form-group">
                            <label for="client_name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client_name" name="client_name" placeholder="">
                            </div>
                        </div>

                        <input type="hidden" id="client_id" name="client_id" value="">
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