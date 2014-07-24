$(function(){
    $(document).ready(function() {
        $('#all_users').dataTable();
    } );

    $('a[activate]').click(function(){
        $body = $("body");
        $body.addClass("loading");
    });
});