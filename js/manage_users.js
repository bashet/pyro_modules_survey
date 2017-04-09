function activate_user(user_id, active){
    $body = $("body");
    bootbox.dialog({
        message: "<h3>What do you want to do with the selected user?</h3>",
        title: "Manager User Account",
        buttons: {
            success: {
                label: (active == '1' ? "Activate" : "De-activate"),
                className: (active == '1' ? "btn-success" : "btn-danger"),
                callback: function() {
                    $.ajax({
                        url: base_url + 'index.php/survey/activate_user/' + user_id + '/' + active,
                        success:function(data,status){
                            window.location.reload();
                        }
                    });
                }
            },
            danger: {
                label: "Reject",
                className: (active == '1' ? "btn-danger" : "hide"),
                callback: function() {
                    $.ajax({
                        url: base_url + 'index.php/survey/reject_user/' + user_id,
                        success:function(data,status){
                            window.location.reload();
                        }
                    });
                }
            },
            cancel: {
                label: "Nothing",
                className: "btn-default",
                callback: function() {

                }
            }
        }
    });
    /*if(active == '1'){
        $('#user_activation').html('activate');
    }else{
        $('#user_activation').html('de-activate');
    }

    $( "#dialog-confirm" ).removeClass('hide').dialog({
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> User Activation!</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Proceed",
                "class" : "btn btn-danger btn-xs",
                click: function() {
                    $( this ).dialog( "close" );
                    $body = $("body");
                    $body.addClass("loading");
                    $.ajax({
                        url: base_url + 'index.php/survey/activate_user/' + user_id + '/' + active,
                        success:function(data,status){
                            var test = 'test';
                            var my_span = '#activate_span-'+user_id;

                            if(data == 1){
                                $(my_span).parent().get(0).onclick = function(){activate_user(user_id, 0)};
                                $(my_span).removeClass('glyphicon-remove' );
                                $(my_span).addClass('glyphicon-ok' );
                            }else{
                                $(my_span).parent().get(0).onclick = function(){activate_user(user_id, 1)};
                                $(my_span).removeClass('glyphicon-ok' );
                                $(my_span).addClass('glyphicon-remove' );
                            }
                            $body.removeClass("loading");
                        }
                    });

                }
            }
            ,
            {
                html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                "class" : "btn btn-xs",
                click: function() {
                    $( this ).dialog( "close" );
                }
            }
        ]
    });*/
}

$(function(){
    $(document).ready(function() {
        var responsiveHelper = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone : 480
        };
        var active_user = $('#tbl_active_users').dataTable({
            sPaginationType: 'bootstrap',
            oLanguage      : {
                sLengthMenu: '_MENU_ records per page'
            },
            "bStateSave": true,
            bAutoWidth     : false,
            "sAjaxSource": base_url+'index.php/survey/get_all_active_users_ajax',
            aoColumnDefs: [
                { sClass: "center", "aTargets": [ 0,4,5,6,7 ] },
                { "bSortable": false, "aTargets": [ 6,7 ] }
            ],
            fnPreDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper) {
                    responsiveHelper = new ResponsiveDatatablesHelper(this, breakpointDefinition);
                }
            },
            fnRowCallback  : function (nRow) {
                responsiveHelper.createExpandIcon(nRow);
            },
            fnDrawCallback : function (oSettings) {
                responsiveHelper.respond();
            }
        });

        var non_active_user = $('#tbl_non_active_users').dataTable({
            "bStateSave": true,
            "sAjaxSource": base_url+'index.php/survey/get_all_not_active_users_ajax',
            aoColumnDefs: [
                { sClass: "center", "aTargets": [ 0,4,5,6,7 ] },
                { "bSortable": false, "aTargets": [ 6,7 ] }
            ]
        });

        var archived_user = $('#table_archived_users').dataTable({
            "bStateSave": true,
            "sAjaxSource": base_url+'index.php/survey/get_all_archived_users_ajax',
            aoColumnDefs: [
                { sClass: "center", "aTargets": [ 0,4,5,6 ] },
                { "bSortable": false, "aTargets": [ 6 ] }
            ]
        });

        $('#tbl_active_request').dataTable();
        $('#tbl_approved_request').dataTable();

        $('#tbl_active_users tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                active_user.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#tbl_non_active_users tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                non_active_user.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#table_archived_users tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                archived_user.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

    } );

    $('button[approve]').button().click(function(){
        var btn_data        = this.id;
        var btn_data_array  = btn_data.split('-');
        var request_id      = btn_data_array[1];

        var user_name = '#user_name-' + request_id;
        var org_name = '#org_name-' + request_id;
        var pro_name = '#pro_name-' + request_id;

        $('#dialog_user_name').html($(user_name).val());
        $('#dialog_org_name').html($(org_name).val());
        $('#dialog_pro_name').html($(pro_name).val());

        $( "#dialog-confirm-request_approval" ).removeClass('hide').dialog({
            resizable: false,
            modal: true,
            width:400,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Approve new programme participation!</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Proceed",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                        $body = $("body");
                        $body.addClass("loading");
                        window.location.href = base_url + 'index.php/survey/approve_new_programme/' + request_id;
                    }
                }
                ,
                {
                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });

    });

    $('#switch_organisation').change(function () {
        $body = $("body");
        $body.addClass("loading");
        $.ajax({
            url: base_url + 'index.php/survey/switch_client/' + this.value,
            success:function(data,status){
                window.location.reload();
            }
        });
    });


});