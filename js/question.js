$(function(){
    $(document).ready(function() {
        $('#all_question').dataTable();
    } );
    $( "#question_categories" ).accordion({
        collapsible: true,
        active: false,
        heightStyle: "content"
    });

    $( "div[question]" ).accordion({
        collapsible: true,
        active: false,
        heightStyle: "content"
    });


    $('#submit_question_form').click(function(event){
        tinyMCE.triggerSave();
        $('#frm_save_question').submit();
    });
    $('#frm_save_question').on('submit', function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                var msg = jQuery.parseJSON( data );
                if(msg.validate == true){
                    window.location.href = base_url + 'index.php/survey/questions/' + msg.survey_id;
                }else{
                    $('#q_form_validate_popup').modal('show');
                }

            }
        });
        event.preventDefault();
    });

    $('#update_question_form').click(function(event){
        tinyMCE.triggerSave();
        $('#frm_update_question').submit();
    });

    $('#frm_update_question').on('submit', function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                var msg = jQuery.parseJSON( data );
                if(msg.validate == true){
                    window.location.href = base_url + 'index.php/survey/questions/' + msg.survey_id;
                }else{
                    $('#q_form_validate_popup').modal('show');
                }

            }
        });
        event.preventDefault();
    });


});