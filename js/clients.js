
$(function(){
    $(document).ready(function() {
        var responsiveHelper = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone : 480
        };
        $('#all_clients').dataTable({
            sPaginationType: 'bootstrap',
            oLanguage      : {
                sLengthMenu: '_MENU_ records per page'
            },
            "bStateSave": true,
            bAutoWidth     : false,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 2,3 ] }
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

        $('button[set_logo]').tooltipster({
            contentAsHTML: true
        });
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

    $('button[edit_clients]').button().click(function(){
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
        var button_id       = this.id;
        var button_id_array = button_id.split('-');
        var client_id       = button_id_array[1];
        var active          = button_id_array[2];

        if(active == '0'){
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

    $('button[set_logo]').click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var clients_id = button_id_array[1];
        $('#client_id_to_set_logo').val(clients_id);
    });

    $('#folder_select').change(function(){
        $.ajax({
            type : 'GET',
            url:base_url + 'index.php/survey/ajax_select_folder/' + $(this).val(),
            dataType : 'json',
            success: function(data){
                if (data) {

                    // remove images from last selection
                    var image_list = $('#image_list');
                    image_list.empty();

                    image_list.append('<hr>');

                    if (data.images) {

                        $.each(data.images, function(i, image){
                            if((image.extension == '.jpg') || (image.extension == '.JPG')){
                                var my_image = '<img src="' + base_url + 'index.php/files/thumb/' + image.id + '" alt="' + image.name + '" title="Title: ' + image.name + '">';

                                $('#image_list').append(
                                    '<label>' +
                                        '<input type="radio" name="image" value="'+ image.id +'">' +
                                        my_image +
                                        '</label>'
                                );
                            }

                        });
                    }
                }
            }
        });
    });

    $('#save_clients_logo').button().click(function(){
        $body = $("body");
        $body.addClass("loading");
        $('#mdl_upload_logo').modal('hide');
        $('#frm_upload_logo').submit();
    });

    $('#all_clients').on('click', '.delete_clients', function () {
        var target = this.id;
        var targetArray = target.split('-');
        var client_id = targetArray[1];
        swal({
            title: "Are you sure?",
            text: "You are about to delete an organisation! This may cause serious data loss!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {
            $.ajax({
                type: 'POST',
                url:base_url + 'index.php/survey/ajax_delete_organisation',
                dataType: 'json',
                data: {client_id: client_id},
                success : function (msg) {
                    setTimeout(function(){
                        swal("Deleted!", "The selected organisation has been deleted.", "success");
                        window.location.reload();
                    }, 2000);

                }
            });
        })
    });


});
