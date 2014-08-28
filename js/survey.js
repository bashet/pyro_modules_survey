
$(function(){
    $(document).ready(function() {
        $('#all_survey').dataTable();
    } );

    $('#save_survey').button().click(function(){
        $('#update_survey').modal('hide');
        $body = $("body");
        $body.addClass("loading");
        $('#frm_manage_survey').submit();
    });

    $('#frm_manage_survey').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/survey';
            }
        });
        event.preventDefault();
    });

    $('#survey_popup_close').button().click(function(){
        $('#survey_id').val('');
        $('#survey_name').val('');
        $('#survey_description').val('');
    });

    $('a[edit_survey]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var survey_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_survey_by_id/'+survey_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#survey_name').val(msg.name);
                    $('#survey_description').val(msg.description);
                    $('#survey_id').val(msg.id);

                    $('#update_survey').modal('show');
                }
                //window.location.href = base_url + 'index.php/survey/survey';
            }
        });

    });
    $('a[delete_survey]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var survey_id = button_id_array[1];

        $.ajax({
            url: base_url + 'index.php/survey/get_survey_by_id/'+survey_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#item_name').html(msg.name);

                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: false,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Delete Survey?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete selected items",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    $body = $("body");
                                    $body.addClass("loading");
                                    window.location.href = base_url + 'index.php/survey/delete_survey/'+survey_id;
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
            }
        });
    });

    $('#btn_apply_new_programme').button().click(function(){
        var new_programme_id = $('#new_programme_id').val();
        if(new_programme_id != '0'){
            $('#frm_new_programme_application').submit();
        }
    });
});
