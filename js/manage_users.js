$(function(){
    $(document).ready(function() {
        $('#all_users').dataTable();
    } );

    var allow_attempt = $( "input[allow_attempt]" ).spinner({
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

    $('button[activate]').button().click(function(){
        var button_id       = this.id;
        var button_id_array = button_id.split('-');
        var user_id         = button_id_array[1];
        var active          = button_id_array[2];

        if(active == '1'){
            $('#user_activation').html('activate');
        }else{
            $('#user_activation').html('de-activate');
        }

        $( "#dialog-confirm" ).removeClass('hide').dialog({
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> User Activation!</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Proceed",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                        $body = $("body");
                        $body.addClass("loading");
                        window.location.href = base_url + 'index.php/survey/activate_user/' + user_id + '/' + active;
                    }
                }
                ,
                {
                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });

    });
});