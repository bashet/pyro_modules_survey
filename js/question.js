$(function(){
    $(document).ready(function() {
        $('#all_question').dataTable();
    } );
    //$( "#categories" ).accordion({ collapsible: true, active: false });


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

    var active = true;

    $('#collapse-init').click(function () {
        if (active) {
            active = false;
            $('.panel-collapse').collapse('show');
            $('.panel-title').attr('data-toggle', '');
            $(this).text('Enable accordion behavior');
        } else {
            active = true;
            $('.panel-collapse').collapse('hide');
            $('.panel-title').attr('data-toggle', 'collapse');
            $(this).text('Disable accordion behavior');
        }
    });

    $('#accordion').on('show.bs.collapse', function () {
        if (active) $('#accordion .in').collapse('hide');
    });

});