
$(function(){
    $(document).ready(function() {
        $('#all_clients').dataTable();
    } );

    $('#save_clients').button().click(function(){
        $('#update_clients').modal('hide');
        $body = $("body");
        $body.addClass("loading");
        $('#frm_manage_clients').submit();
    });

    $('#frm_manage_clients').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/clients';
            }
        });
        event.preventDefault();
    });

    $('#clients_popup_close').button().click(function(){
        $('#client_id').val('');
        $('#client_id_to_edit').val('');
        $('#client_name').val('');
    });

    $('a[edit_clients]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var clients_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_client_by_id/'+clients_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#client_name').val(msg.name);
                    $('#client_id_to_edit').val(msg.id);

                    $('#update_clients').modal('show');
                }
            }
        });

    });

    $('a[assign_manager]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var clients_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_client_by_id/'+clients_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#manager_id').val(msg.name);
                    $('#client_id').val(msg.id);

                    $('#update_manager_modal').modal('show');
                }
            }
        });

    });

    $('#btn_update_manager').button().click(function(){
        $body = $("body");
        $('#update_manager_modal').modal('hide');
        $body.addClass("loading");
        $('#frm_update_manager').submit();
    });

    $('#frm_update_manager').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/clients';
            }
        });
        event.preventDefault();
    });

    $('button[activate]').button().click(function(){
        $body = $("body");
        $body.addClass("loading");

        var button_id       = this.id;
        var button_id_array = button_id.split('-');
        var client_id       = button_id_array[1];
        var active          = button_id_array[2];

        if(active == '1'){
            $('#client_activation').html('activate');
        }else{
            $('#client_activation').html('de-activate');
        }

        $( "#dialog-confirm" ).removeClass('hide').dialog({
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Institute Activation!</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='glyphicon glyphicon-ok'></i>&nbsp; Proceed",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                        $body = $("body");
                        $body.addClass("loading");
                        window.location.href = base_url + 'index.php/survey/update_client_status/' + client_id + '/' + active;
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
