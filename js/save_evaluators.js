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
                }
                //window.location.href = base_url + 'index.php/survey/send_email_to_evaluators';
            }
        });
        event.preventDefault();
    });
});