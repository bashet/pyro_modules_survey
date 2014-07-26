$(function(){

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
                    var alert_box       = $('#number_of_evaluators_warning');
                    var modal_msg_body  = $('#modal_msg_body');

                    alert_box.html('');
                    modal_msg_body.html('');

                    if((msg.error) || (msg.evaluators < 3)){
                        if(msg.evaluators < 3){
                            modal_msg_body.html('Please enter minimum 3 evaluators or more.');
                            alert_box.html('<strong>Oh snap!</strong> Please submit minimum 3 evaluators or more.');
                        }

                        var errors = msg.error;

                        errors.forEach(function(e){
                            var field = '#email-' + e;
                            $(field).addClass('has-error');
                            var new_warning = 'Please enter a valid email address for evaluator no: ' + e;

                            if(alert_box.html() == ''){
                                alert_box.html(new_warning);
                                modal_msg_body.html(new_warning);
                            }else{
                                alert_box.html(alert_box.html() + '<br>' + new_warning);
                                modal_msg_body.html(modal_msg_body.html() + '<br>' + new_warning);
                            }

                            $body.removeClass("loading");
                            alert_box.css('display', 'block');
                            $('#modal_warning_evaluators').modal('show');

                        });
                    }else{
                        window.location.href = base_url + 'index.php/survey/send_email_to_evaluators';
                    }
                }
            }
        });
        event.preventDefault();
    });
});