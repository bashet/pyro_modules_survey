<div id="clients-container">

    <table id="all_users" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th style="width: 8%">SN</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active</th>
            <th>History</th>
            <th>Last Login</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($users){
            $i = 1;
            foreach($users as $user){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$user->display_name.'</td>';
                echo '<td>'.$user->email.'</td>';
                echo '<td>'.($user->active)?'Yes':'No'.'</td>';
                echo '<td><a href="{{ url:site }}survey/history/'.$user->id.'"><i class="fa fa-cubes"></i></a></td>';
                echo '<td>'.date('d/m/Y', $user->last_login).'</td>';
                echo '</tr>';
                $i++;
            }
        }
        ?>
        </tbody>
    </table>


</div>