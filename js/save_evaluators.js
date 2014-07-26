$(function(){
    $('#submit_evaluators').button().click(function(){

    });

    $('#frm_save_evaluators').on('submit', function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
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