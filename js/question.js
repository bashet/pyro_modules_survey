
$(function(){
    $(document).ready(function() {
        $('#all_question').dataTable();
    } );

    $('#save_question').button().click(function(){
        $('#frm_manage_question').submit();
    });

    $('#frm_manage_question').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/question/question';
            }
        });
        event.preventDefault();
    });

    $('#question_popup_close').button().click(function(){
        $('#question_id').val('');
        $('#question_name').val('');
        $('#question_description').val('');
    });

    $('a[edit_question]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var question_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/question/get_question_by_id/'+question_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#question_name').val(msg[0].name);
                    $('#question_description').val(msg[0].description);
                    $('#question_id').val(msg[0].id);

                    $('#update_question').modal('show');
                }
                //window.location.href = base_url + 'index.php/question/question';
            }
        });

    });
    $('a[delete_question]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var question_id = button_id_array[1];

        $.ajax({
            url: base_url + 'index.php/question/get_question_by_id/'+question_id,

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
                                    window.location.href = base_url + 'index.php/question/delete_question/'+question_id;
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
