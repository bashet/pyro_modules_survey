/**
 * Created by Bashet on 06/12/2016.
 */
$(function () {
    $('#btn_add_programme').click(function (e) {
        e.preventDefault();
        $('#mdlProgramme').modal('show');
    });

    $('#frm_add_programme').validate({
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('#btn_update_client_programme').click(function () {
        //e.preventDefault();
        if($('#frm_add_programme').valid()){
            $('#mdlProgramme').modal('hide');
            $('#frm_add_programme').submit();
       }
    });
});