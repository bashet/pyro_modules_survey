function activate_user(user_id, active){
    if(active == '1'){
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
    });
}

$(function(){
    $(document).ready(function() {
        $('#all_users').dataTable({

            "sAjaxSource": base_url+'index.php/survey/get_all_users_ajax'
        });

        $('#tbl_active_request').dataTable();
        $('#tbl_approved_request').dataTable();

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


});