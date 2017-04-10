
$(function(){
    $(document).ready(function() {
        var responsiveHelper = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone : 480
        };
        $('#all_survey').dataTable({
            sPaginationType: 'bootstrap',
            oLanguage      : {
                sLengthMenu: '_MENU_ records per page'
            },
            "bStateSave": true,
            bAutoWidth     : false,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 3,4] }
            ],
            fnPreDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper) {
                    responsiveHelper = new ResponsiveDatatablesHelper(this, breakpointDefinition);
                }
            },
            fnRowCallback  : function (nRow) {
                responsiveHelper.createExpandIcon(nRow);
            },
            fnDrawCallback : function (oSettings) {
                responsiveHelper.respond();
            }
        });
    } );

    $('#save_survey').button().click(function(){
        $('#update_survey').modal('hide');
        $body = $("body");
        $body.addClass("loading");
        $('#frm_manage_survey').submit();
    });

    $('#frm_manage_survey').on('submit',function(event){
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                window.location.href = base_url + 'index.php/survey/survey';
            }
        });
        event.preventDefault();
    });

    $('#survey_popup_close').button().click(function(){
        $('#survey_id').val('');
        $('#survey_name').val('');
        $('#survey_description').val('');
    });

    $('#all_survey').on('click', '.edit_survey', function (e) {
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var survey_id = button_id_array[1];
        $.ajax({
            url: base_url + 'index.php/survey/get_survey_by_id/'+survey_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#survey_name').val(msg.name);
                    $('#survey_description').val(msg.description);
                    $('#survey_id').val(msg.id);

                    $('#update_survey').modal('show');
                }
                //window.location.href = base_url + 'index.php/survey/survey';
            }
        });
    });

    $('#all_survey').on('click', '.delete_survey', function (e) {
        var button_id = this.id;
        var button_id_array = button_id.split('-');
        var survey_id = button_id_array[1];

        $.ajax({
            url: base_url + 'index.php/survey/get_survey_by_id/'+survey_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    swal({
                            title: "Are you sure?",
                            text: 'Survey "'+ msg.name +'" will be permanently deleted and cannot be recovered!',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, delete it!",
                            showLoaderOnConfirm: true,
                            closeOnConfirm: false
                        },
                        function(){
                            $body = $("body");
                            $body.addClass("loading");
                            window.location.href = base_url + 'index.php/survey/delete_survey/'+survey_id;
                        });
                }
            }
        });
    });


    $('#btn_apply_new_programme').button().click(function(){
        var new_programme_id = $('#new_programme_id').val();
        if(new_programme_id != '0'){
            $('#apply_new_programme_modal').modal('hide');
            $body = $("body");
            $body.addClass("loading");
            $('#frm_new_programme_application').submit();
        }
    });

    $( "input[allow_attempt]" ).spinner({
        create: function( event, ui ) {
            //add custom classes and icons
            $(this)
                .next().addClass('btn btn-success').html('<i class="ace-icon fa fa-plus"></i>')
                .next().addClass('btn btn-danger').html('<i class="ace-icon fa fa-minus"></i>')

            //larger buttons on touch devices
            if('touchstart' in document.documentElement)
                $(this).closest('.ui-spinner').addClass('ui-spinner-touch');
        },
        min: 0,
        change: function( event, ui ) {
            $.ajax({
                type:   'post',
                url:    base_url + 'index.php/survey/update_attempt_allowed',
                data:   {user_data:this.id,value:this.value},
                success: function(data, status){
                    //alert(data);
                }
            });
        }
    });
});
