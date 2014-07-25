
$(function(){
    $(document).ready(function() {
        $('#all_programme').dataTable();
    } );

    $('#save_programme').button().click(function(){
        $('#update_programme').modal('hide');
        $body = $("body");
        $body.addClass("loading");
        $('#frm_manage_programme').submit();
    });

    $('#frm_manage_programme').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/programme';
            }
        });
        event.preventDefault();
    });

    $('#programme_popup_close').button().click(function(){
        $('#programme_id').val('');
        $('#programme_name').val('');
        $('#programme_description').val('');
    });

    $('button[edit_programme]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var programme_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_programme_by_id/'+programme_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#programme_name').val(msg.name);
                    $('#programme_description').val(msg.description);
                    $('#programme_id').val(msg.id);

                    $('#update_programme').modal('show');
                }
                //window.location.href = base_url + 'index.php/survey/programme';
            }
        });

    });

    $('button[edit_survey]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var programme_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_programme_by_id/'+programme_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#programme_id').val(msg.id);
                    $('#programme_name_modal').html(msg.name);

                    $('#update_survey_modal').modal('show');
                }
                //window.location.href = base_url + 'index.php/survey/programme';
            }
        });

    });

    $('#btn_update_survey').button().click(function(){
        $('#update_survey_modal').modal('hide');
        $body = $("body");
        $body.addClass("loading");
        $('#frm_link_programme').submit();
    });


    $('button[delete_programme]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var programme_id = button_id_array[1];

        $.ajax({
            url: base_url + 'index.php/survey/get_programme_by_id/'+programme_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#item_name').html(msg.name + ' programme will be permanently deleted and cannot be recovered.');


                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: false,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Delete programme?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete programme",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    $body = $("body");
                                    $body.addClass("loading");
                                    window.location.href = base_url + 'index.php/survey/delete_programme/'+programme_id;
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
                //window.location.href = base_url + 'index.php/survey/programme';
            }
        });


    });

    $('button[activate]').button().click(function(){
        var button_id       = this.id;
        var button_id_array = button_id.split('-');
        var programme_id    = button_id_array[1];
        var active          = button_id_array[2];

        $.ajax({
            url: base_url + 'index.php/survey/get_programme_by_id/'+programme_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    if(msg.active == '1'){
                        $('#item_name').html(msg.name + ' programme will be de-activated.');
                    }else{
                        $('#item_name').html(msg.name + ' programme will be activated.');
                    }


                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: false,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Programme Activation!</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='glyphicon glyphicon-ok'></i>&nbsp; Proceed",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    $body = $("body");
                                    $body.addClass("loading");
                                    window.location.href = base_url + 'index.php/survey/update_programme_status/' + msg.id + '/' + msg.active;
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
                //window.location.href = base_url + 'index.php/survey/programme';
            }
        });


    });
});
