$(function(){
    $('.question').css('display', 'none');

    $(document).ready(function(){
        var question_no = '#q-' + q_no;
        $(question_no).css('display', 'block');
    });

    $('button[next]').button().click(function(){
        var this_id     = this.id;
        var id_array    = this_id.split('-');
        var id          = id_array[1];
        var next        = +id+1;
        var this_q      = '#q-' + id;
        var next_q      = '#q-' + next;

        $(this_q).css('display', 'none');
        $(next_q).css('display', 'block');

        $.ajax({
            type: 'post',
            url: base_url + 'index.php/survey/register_q_no_session',
            data: {'q_no':next},

            success: function(data) {

            }
        });

    });

    $('button[pre]').button().click(function(){
        var this_id     = this.id;
        var id_array    = this_id.split('-');
        var id          = id_array[1];
        var pre        = +id-1;
        var this_q      = '#q-' + id;
        var pre_q      = '#q-' + pre;

        $(this_q).css('display', 'none');
        $(pre_q).css('display', 'block');

        $.ajax({
            type: 'post',
            url: base_url + 'index.php/survey/register_q_no_session',
            data: {'q_no':pre},

            success: function(data) {

            }
        });

    });
    $('input[answer]').click(function(){
        var this_id     = this.name;
        var id_array    = this_id.split('-');
        var id          = id_array[1];
        var value       = this.value;
        $.ajax({
            type:   'post',
            url:    base_url + 'index.php/survey/update_evaluator_answer',
            data:   { q_id:id, value:value },
            success:function(data){}
        });
    });

    $('#submit_answer').button().click(function(){
        $( "#dialog-confirm" ).removeClass('hide').dialog({
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Submit your answer!</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='glyphicon glyphicon-ok'></i>&nbsp; Proceed",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                        $body = $("body");
                        $body.addClass("loading");
                        $.ajax({
                            url: base_url + 'index.php/survey/evaluator_survey_submit',
                            success: function(data) {
                                if(data){
                                    var msg = jQuery.parseJSON( data );
                                    if(msg.finished == false){

                                    }else{
                                        if(msg.updated == true){
                                            window.location.href = base_url + 'index.php/survey/successful';
                                        }
                                    }
                                }
                            }
                        });
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