<div id="clients-container">
    {{ if user:group == 'manager' }}
    <h2><?php echo $client->name?></h2>
    {{ endif }}
    <table id="all_users" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th>SN</th>
            <th>Name</th>
            <th>Email</th>
            {{ if user:group == 'admin'}}
            <th>Organisation</th>
            {{ endif }}
            <th>Cohort</th>
<!--            <th>Programme</th>-->
            <th>Active</th>
            <!--<th>Attempt Remaining</th>-->
            <th>History</th>
            <th>Last Login</th>
        </tr>
        </thead>
        <!--<tbody>
        <?php
/*        if($users){
            $i = 1;
            foreach($users as $user){
                $participation      = get_current_participation_by_user($user->id);
                $attempt_remaining  = $participation->allowed - get_total_attempts_by_user_n_programme($participation->uid, $participation->pid);
                $programme          = get_programme_by_id($participation->pid);
                echo '<tr>';
                echo '<td style="text-align: center">'.$i.'</td>';
                echo '<td>'.$user->display_name.'</td>';
                echo '<td>'.$user->email.'</td>';
                */?>{{ if user:group == 'admin'}}
                    <?php /*echo '<td>'.$user->org.'</td>';*/?>
                  {{ endif }}
                <?php
/*
                echo '<td>'.$user->cohort.'</td>';
                echo '<td>'.$programme->name.'</td>';

                if($user->active){
                    echo '<td style="text-align: center"><button activate id="activate_user-'.$user->id.'-0" class="btn btn-link"><span class="glyphicon glyphicon-ok"></span></button></td>';
                }else{
                    echo '<td style="text-align: center"><button activate id="activate_user-'.$user->id.'-1" class="btn btn-link"><span class="glyphicon glyphicon-remove"></span></button></td>';
                }
                echo '<td><input id="allow_attempt-'.$user->id.'" class="allow_attempt" value="'.$attempt_remaining.'" allow_attempt></td>';
                echo '<td style="text-align: center"><a href="{{ url:site }}survey/history/'.$user->id.'"><span class="glyphicon glyphicon-list-alt"></span></td>';
                echo '<td style="text-align: center">'.date('d/m/Y : h:i:s a', $user->last_login).'</td>';
                echo '</tr>';
                $i++;
            }
        }
        */?>
        </tbody>-->
    </table>

    <!--<table id="example" class="display table table-bordered table-hover" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Extn.</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
        </thead>
    </table>-->


</div>

<!-------------------------------------------------------------------------------------------------------->
<div id="dialog-confirm" class="hide">
    <div class="alert alert-info bigger-110">
        You are about to <span id="user_activation"></span> an user.
    </div>

    <div class="space-6"></div>

    <p class="bigger-110 bolder center grey">
        <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
        Are you sure?
    </p>
</div><!-- #dialog-confirm -->