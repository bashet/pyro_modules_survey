
<div id="dpt-container">

    <div style="">
        <button class="btn btn-primary" data-toggle="modal" data-target="#update_dpt"><span class="icon-plus"></span> Add new department</button>
    </div>
    <table id="all_dpt" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th style="width: 8%">SN</th>
            <th style="width: 30%">Name</th>
            <th style="width: 40%">Description</th>
            <th style="width: 10%">Edit</th>
            <th style="width: 10%">Delete</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        foreach($dpt as $d){
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$d->name.'</td>';
            echo '<td>'.$d->description.'</td>';
            echo '<td style="text-align: center"><a class="" title="Edit this item" href="#"><span class="icon-edit icon-2x"></span></a></td>';
            echo '<td style="text-align: center"><a class="" title="Delete this item" href="#"><span class="icon-trash icon-2x"></span></a></td>';
            echo '</tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="update_dpt" tabindex="-1" role="dialog" aria-labelledby="update_dptLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="update_dptLabel">Update department information</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="man">
                        <div class="form-group">
                            <label for="dpt_name" class="col-sm-4 control-label">Depart Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="dpt_name" name="dpt_name" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dpt_description" class="col-sm-4 control-label">Depart Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="dpt_description" name="dpt_description" placeholder=""></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="dpt_id" name="dpt_id" value="">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_dpt">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>