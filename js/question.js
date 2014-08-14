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
        $body = $("body");
        $body.addClass("loading");

        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                var msg = jQuery.parseJSON( data );
                if(msg.validate == true){
                    window.location.href = base_url + 'index.php/survey/questions_in_category/' + msg.cat_id;
                }else{
                    $body = $("body");
                    $body.removeClass("loading");
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
        $body = $("body");
        $body.addClass("loading");
        var $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data,status) {
                var msg = jQuery.parseJSON( data );
                if(msg.validate == true){
                    window.location.href = base_url + 'index.php/survey/questions_in_category/' + msg.cat_id;
                }else{
                    $body = $("body");
                    $body.removeClass("loading");
                    $('#q_form_validate_popup').modal('show');
                }

            }
        });
        event.preventDefault();
    });

    $('a[delete_question]').button().click(function(){
        var button_id = this.id;
        var q_id_array = button_id.split('-');
        var q_id = q_id_array[1];

        $.ajax({
            url: base_url + 'index.php/survey/get_question_by_id/'+q_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#item_name').html(msg.title);

                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: true,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Delete Question?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete selected items",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    $body = $("body");
                                    $body.addClass("loading");
                                    window.location.href = base_url + 'index.php/survey/delete_question/'+ msg.cat_id + '/' + q_id;
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
                }
            }
        });
    });

    $('button[btn_remove_cat]').button().click(function(e){
        e.stopPropagation();
        var button_id   = this.id;
        var id_array    = button_id.split('-');
        var survey_id   = id_array[0];
        var cat_id      = id_array[1];

        $.ajax({
            url: base_url + 'index.php/survey/get_category_by_id/' + cat_id,

            success: function(data,status) {
                if(data){
                    var msg = jQuery.parseJSON( data );
                    $('#category_name').html(msg.name);

                    $( "#dialog-confirm" ).removeClass('hide').dialog({
                        resizable: true,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Un-link Category?</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Remove",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    $body = $("body");
                                    $body.addClass("loading");
                                    window.location.href = base_url + 'index.php/survey/remove_category/'+ survey_id + '/' + cat_id;
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
                }
            }
        });
    });


});