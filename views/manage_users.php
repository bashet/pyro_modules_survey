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
            <th>Programme</th>
            <th>Active</th>
            <th>History</th>
            <th>Last Login</th>
        </tr>
        </thead>

    </table>

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