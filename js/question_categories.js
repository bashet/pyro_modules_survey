
$(function(){
    $(document).ready(function() {
        $('#all_question_categories').dataTable();
    } );

    $('#save_question_categories').button().click(function(){
        $('#update_question_categories').modal('hide');
        $body = $("body");
        $body.addClass("loading");
        $('#frm_manage_question_categories').submit();
    });

    $('#frm_manage_question_categories').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/question_categories';
            }
        });
        event.preventDefault();
    });

    $('#question_categories_popup_close').button().click(function(){
        $('#question_categories_id').val('');
        $('#question_categories_name').val('');
        $('#question_categories_description').val('');
    });

    $('button[edit_question_categories]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var question_categories_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_question_categories_by_id/'+question_categories_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#question_categories_name').val(msg[0].name);
                    $('#question_categories_description').val(msg[0].description);
                    $('#question_categories_id').val(msg[0].id);

                    $('#update_question_categories').modal('show');
                }
                //window.location.href = base_url + 'index.php/survey/question_categories';
            }
        });

    });
    $('button[delete_question_categories]').button().click(function(){
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var question_categories_id = button_id_array[1];

        $.ajax({
            url: base_url + 'index.php/survey/get_question_categories_by_id/'+question_categories_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#item_name').html(msg[0].name);


                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: false,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Delete question category?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete selected items",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    $body = $("body");
                                    $body.addClass("loading");
                                    window.location.href = base_url + 'index.php/survey/delete_question_categories/'+question_categories_id;
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
                //window.location.href = base_url + 'index.php/survey/question_categories';
            }
        });


    });
});
