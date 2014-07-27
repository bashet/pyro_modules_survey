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

    });
});