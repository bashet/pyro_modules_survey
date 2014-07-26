$(function(){

    $('#frm_save_evaluators').on('submit', function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                if(data){
                    var msg             = jQuery.parseJSON( data );
                    var alert_box       = $('#number_of_evaluators_warning');
                    var modal_msg_body  = $('#modal_msg_body');

                    alert_box.html('');
                    modal_msg_body.html('');

                    if(msg.error){
                        var errors = msg.error;

                        errors.forEach(function(e){
                            var warning_alert = alert_box.html();
                            var field = '#email-' + e;
                            $(field).addClass('has-error');
                            var new_warning = 'Please enter a valid email address for evaluator no. ' + e;
                            alert_box.html(warning_alert + '<br>' + new_warning);

                            var msg_body = modal_msg_body();
                            modal_msg_body.html(msg_body + '<br>' + new_warning);
                        });

                        alert_box.css('display', 'block');
                    }

                    if(msg.evaluators < 3){
                        if(alert_box.html() == ''){
                            alert_box.html('<strong>Oh snap!</strong> Please submit minimum 3 evaluators or more.');
                        }else{
                            alert_box.html(alert_box.html() + '<br>' + '<strong>Oh snap!</strong> Please submit minimum 3 evaluators or more.');
                        }

                        alert_box.css('display', 'block');

                        if(modal_msg_body.html() == ''){
                            modal_msg_body.html('Please enter minimum 3 evaluators or more.');
                        }else{
                            modal_msg_body.html(modal_msg_body.html() + '<br>' + 'Please enter minimum 3 evaluators or more.');
                        }

                        $('#modal_warning_evaluators').modal('show');
                    }

                }
                //window.location.href = base_url + 'index.php/survey/send_email_to_evaluators';
            }
        });
        event.preventDefault();
    });
});