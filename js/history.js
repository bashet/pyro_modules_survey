$(function () {
    $('.report_publish').click(function (e) {
        e.preventDefault();
        var link = $(this).attr('href');
        swal({
                title: "Are you sure?",
                text: "You are about to conclude this survey and publish the associated report. Please note that no further evaluator contributions or amendments can be made to this survey if you proceed!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Proceed!",
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            },
            function(){
                window.location.href = link;
            });
    });
});