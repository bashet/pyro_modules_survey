$(function(){
    $('.question').css('display', 'none');

    $(document).ready(function(){
        var question_no = '#q-' + q_no;
        $(question_no).css('display', 'block');
    });
});