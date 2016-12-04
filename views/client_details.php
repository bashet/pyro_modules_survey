<h3>Organisation Details
<button class="btn btn-sm btn-purple pull-right">Add Programme</button>
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