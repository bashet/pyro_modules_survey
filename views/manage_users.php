<div id="clients-container">

    {{ if user:group == 'manager' }}
    <h2><?php echo $client->name?></h2>
    {{ endif }}

    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#active_users">
                    <i class="green ace-icon icon-ok-sign bigger-120"></i>
                    Active users
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#non-active_users">
                    <i class="red ace-icon icon-remove-sign bigger-120"></i>
                    Non-active users
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="active_users" class="tab-pane fade in active">
                <table id="tbl_active_users" class="table table-bordered table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Email</th>
                        {{ if user:group == 'admin'}}
                        <th>Organisation</th>
                        {{ endif }}
                        <th>Cohort</th>
                        <th>Programme</th>
                        <th>Active</th>
                        <th>History</th>
                        <th>Last Login</th>
                    </tr>
                    </thead>

                </table>
            </div>
            <div id="non-active_users" class="tab-pane fade">
                <table id="tbl_non_active_users" class="table table-bordered table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Email</th>
                        {{ if user:group == 'admin'}}
                        <th>Organisation</th>
                        {{ endif }}
                        <th>Cohort</th>
                        <th>Programme</th>
                        <th>Active</th>
                        <th>History</th>
                        <th>Last Login</th>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
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