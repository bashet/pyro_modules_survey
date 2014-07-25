<div class="programme-container">

    <table id="programme" class="table table-bordered table-hover" cellspacing="0" width="100%" border="1">
        <thead>
        <tr>
            <th width="10">SN</th>
            <th>Name</th>
            <th>Description</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        foreach($programme as $d){
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$d->name.'</td>';
            echo '<td>'.$d->description.'</td>';
            echo '<td><a href="#" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a></td>';
            echo '<td><a href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>';
            echo '</tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>



</div>