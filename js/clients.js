
$(function(){
    $(document).ready(function() {
        $('#all_clients').dataTable();
    } );

    $('#save_clients').button().click(function(){
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
                    $('#client_id').val(msg.id);

                    $('#update_clients').modal('show');
                }
                //window.location.href = base_url + 'index.php/clients/clients';
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
                //window.location.href = base_url + 'index.php/clients/clients';
            }
        });

    });

    $('#btn_update_manager').button().click(function(){
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

});
