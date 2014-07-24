<div id="clients-container">
    {{ if user:group == 'manager' }}
    <h2><?php echo $client->name?></h2>
    {{ endif }}
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
                echo '<td style="text-align: center">'.$i.'</td>';
                echo '<td>'.$user->display_name.'</td>';
                echo '<td>'.$user->email.'</td>';
                if($user->active){
                    echo '<td style="text-align: center">Yes</td>';
                }else{
                    echo '<td style="text-align: center">No</td>';
                }
                echo '<td style="text-align: center"><a href="{{ url:site }}survey/history/'.$user->id.'"><span class="glyphicon glyphicon-list-alt"></span></td>';
                echo '<td style="text-align: center">'.date('d/m/Y', $user->last_login).'</td>';
                echo '</tr>';
                $i++;
            }
        }
        ?>
        </tbody>
    </table>


</div>