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

    $('#client_programme').on('click', '.detach_programme', function () {
        var data = this.id;
        var dataArray = data.split('-');

        swal({
            title: "Are you sure?",
            text: "You are about to detach a programme from organisation!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, detach it!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            html: false
        }, function(){
            $.ajax({
                url: base_url + 'index.php/survey/detach_client_programme',
                type: "POST",
                data: {client_id: dataArray[0], programme_id: dataArray[1]}
            }).done(function (result) {
                setTimeout(function(){
                    swal('Successfully detached!', '', 'success');
                    window.location.reload();
                }, 2000);
            });
        });
    });
});