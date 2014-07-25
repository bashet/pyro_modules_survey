
$(function(){
    $(document).ready(function() {
        $('#all_dpt').dataTable();
    } );

    $('#save_dpt').button().click(function(){
        $('#frm_manage_dpt').submit();
    });

    $('#frm_manage_dpt').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/dpt';
            }
        });
        event.preventDefault();
    });

    $('#dpt_popup_close').button().click(function(){
        $('#dpt_id').val('');
        $('#dpt_name').val('');
        $('#dpt_description').val('');
    });

    $('button[edit_dpt]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var dpt_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_dpt_by_id/'+dpt_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#dpt_name').val(msg[0].name);
                    $('#dpt_description').val(msg[0].description);
                    $('#dpt_id').val(msg[0].id);

                    $('#update_dpt').modal('show');
                }
                //window.location.href = base_url + 'index.php/survey/dpt';
            }
        });

    });
    $('button[delete_dpt]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var dpt_id = button_id_array[1];

        $.ajax({
            url: base_url + 'index.php/survey/get_dpt_by_id/'+dpt_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#item_name').html(msg[0].name);


                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: false,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Delete Level?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete all items",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    window.location.href = base_url + 'index.php/survey/delete_dpt/'+dpt_id;
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
                //window.location.href = base_url + 'index.php/survey/dpt';
            }
        });


    });
});
