$(function(){
    var categories = $('.dd');

    categories.nestable({
        maxDepth:1
    });

    categories.on('change', function(e) {
        e.stopPropagation();
        var cat_id = this.id;
        var result = $('.dd').nestable('serialize');

        $.ajax({
            type:   'post',
            url:    base_url + 'index.php/survey/update_position_in_category',
            data:   {cat_id:cat_id,results:result},
            success: function(data, status){
                //alert(data);
            }
        });


    });
});