
$(function(){
    $(document).ready(function() {
        $('#all_dpt').dataTable();
    } );

    $('#save_dpt').button().click(function(){
        $('#frm_manage_dpt').submit();
    });

    $('#frm_manage_dpt').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/dpt';
            }
        });
        event.preventDefault();
    });
});
