$(function(){

    $('#tbl_evaluators').footable();

    $('button[copy_this]').click(function(e){
        e.preventDefault();
        var id = this.id;
        var this_element = '#'+id;
        clipboard.copy({
            'text/plain': this.value,
            'text/html': this.value
        }).then(
            function(){$(this_element).popover('show');},
            function(err){alert('Could not copy this link location! Please report this to the administrator');}
        );
    });

    /*$("button[copy_link]").on('click', function (e) {
        e.preventDefault();
    }).zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function () {
            var button_id = this.id;
            var button_id_array = button_id.split('-');
            var element = '#link-' + button_id_array[1];
            return $(element).val();
        }
    });*/


    $('#frm_save_evaluators').on('submit', function(event){
        $body = $("body");
        $body.addClass("loading");

        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                if(data){
                    var msg             = jQuery.parseJSON( data );

                    if(msg.success == true){
                        window.location.href = base_url + 'index.php/survey/send_email_to_evaluators';
                    }else{
                        var modal_msg_body  = $('#modal_msg_body');

                        modal_msg_body.html('');

                        if(msg.all_empty == true){
                            modal_msg_body.html('You have not entered any thing!');
                        }else if(msg.evaluators < 3){
                            modal_msg_body.html('Please enter minimum 3 evaluators or more.');
                        }else if(msg.missing_fields == true ){
                            modal_msg_body.html('You have missed one or more fields.');
                        }else if(msg.duplicate_entry != ''){
                            modal_msg_body.html(msg.duplicate_entry);
                        }else if(msg.data_exist != ''){
                            modal_msg_body.html(msg.data_exist);
                        }else{
                            var errors = msg.error;

                            errors.forEach(function(e){
                                var field = '#email-' + e;
                                $(field).addClass('has-error');
                                var new_warning = 'Please enter a valid email address for evaluator no: ' + e;

                                if(modal_msg_body.html() == ''){
                                    modal_msg_body.html(new_warning);
                                }else{
                                    modal_msg_body.html(modal_msg_body.html() + '<br>' + new_warning);
                                }
                            });
                        }
                        $body.removeClass("loading");
                        $('#modal_warning_evaluators').modal('show');
                    }
                }
            }
        });
        event.preventDefault();
    });

    $('button[delete_evaluator]').button().click(function(){
        var data        = this.id;
        var data_array  = data.split('-');
        var ev_id       = data_array[0];
        var ev_name     = data_array[1];

        $('#ev_info').html(ev_name);

        $.ajax({
            url: base_url + 'index.php/survey/get_total_evaluators',
            success: function(data,status) {
                if(data <= 3){
                    swal('A minimum of 3 evaluators are required', '', 'error');
                }else{
                    $( "#delete_evaluator_dialog_confirm" ).removeClass('hide').dialog({
                        resizable: false,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Delete Evaluator?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete Evaluator",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    $body = $("body");
                                    $body.addClass("loading");
                                    window.location.href = base_url + 'index.php/survey/delete_evaluator/'+ev_id;
                                }
                            }
                            ,
                            {
                                html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                                "class" : "btn btn-xs",
                                click: function() {
                                    $body = $("body");
                                    $body.removeClass("loading");
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