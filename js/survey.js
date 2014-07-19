
$(function(){
    $(document).ready(function() {
        $('#all_survey').dataTable();
    } );

    $('#save_survey').button().click(function(){
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
                    $('#survey_name').val(msg[0].name);
                    $('#survey_description').val(msg[0].description);
                    $('#survey_id').val(msg[0].id);

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
                    $('#item_name').html(msg[0].name);

                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: false,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Delete Department?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete all items",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
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
});
