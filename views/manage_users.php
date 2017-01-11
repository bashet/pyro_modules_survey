<div id="clients-container">

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
                <a data-toggle="tab" href="#active_users">
                    <i class="green ace-icon icon-ok-sign bigger-120"></i>
                    Active
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#non-active_users">
                    <i class="red ace-icon icon-remove-sign bigger-120"></i>
                    Registrations
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#archived_users">
                    <i class="gray ace-icon icon-archive bigger-120"></i>
                    Archive
                </a>
            </li>
        </ul>
        <div class="tab-content no-padding">
            <div id="active_users" class="tab-pane fade in active table-responsive">
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
            <div id="non-active_users" class="tab-pane fade table-responsive">
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

            <div id="archived_users" class="tab-pane fade table-responsive">
                <table id="table_archived_users" class="table table-bordered table-hover" style="width:100%">
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