$(function(){

    $('#frm_save_evaluators').on('submit', function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    if(msg.error){
                        var errors = msg.error;
                        var alert_box = $('#number_of_evaluators_warning');

                        errors.forEach(function(e){
                            var warning_alert = alert_box.html();
                            var field = '#email-' + e;
                            $(field).addClass('has-error');
                            var new_warning = 'Please enter a valid email address for evaluator no. ' + e;
                            alert_box.html(warning_alert + '<br>' + new_warning);

                        });
                    }

                    if(msg.evaluators < 3){
                        $('#number_of_evaluators_warning').css('display', 'block');
                        $('#modal_warning_evaluators').modal('show');
                    }

                }
                //window.location.href = base_url + 'index.php/survey/send_email_to_evaluators';
            }
        });
        event.preventDefault();
    });
});