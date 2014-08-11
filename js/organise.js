$(function(){
    var categories = $('.dd');

    categories.nestable({
        maxDepth:2,
        group:1
    });

    categories.on('change', function(e) {
        //e.stopPropagation();
        var result = $('.dd').nestable('serialize');
        var mis_parent      = false;

        for(var i = 0; i < result.length; i++){
            var this_parent = result[i];
            var my_child = this_parent.children;
            for(var j = 0; j< my_child.length; j++){
                var this_child = my_child[j];
                var my_id = this_child.id;
                var my_id_array = my_id.split('-');
                if(my_id_array[0] != this_parent.id){
                    mis_parent = true;
                }
            }
        }



        if(mis_parent){
            alert('Please do not move questions between categories!');
            location.reload();
        }else{
            $.ajax({

            });
        }


    });
});