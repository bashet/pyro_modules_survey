<div id="questions-container">

    <div style="padding-bottom: 10px">
        <?php
            echo '<a href="{{ url:site }}survey/add_new_question/'.$cat->id.'" class="btn btn-primary" ><span class="icon-question"></span> Add new question</a>';
            echo '<a href="{{ url:site }}survey/organise_questions/'.$cat->id.'" class="btn btn-primary" ><span class="icon-reorder"></span> Organise questions</a>';
        ?>
    </div>

    <h2>Showing questions for <strong><?=$cat->name?></strong>:</h2>

    <?php
    $sort_order = json_decode($cat->questions);
    if($questions){
        echo '<div id="question_categories">';
        $i = 1;
        foreach($sort_order as $order){
            foreach($questions as $q){
                if($order == $q->id){
                    $options = get_option_by_question_id($q->id);

                    echo '<h3>'.$i.' - '.$q->title.'</h3>';
                    echo '<div>';
                    ?>

                    <div style="float: right">
                        <a href="{{url:site}}survey/edit_question/<?=$cat->id.'/'.$q->id?>" class="btn btn-warning" title="Edit"><span class="fa fa-edit fa-2x"></span></a>
                        <a delete_question id="delete_question-<?=$q->id?>" class="btn btn-danger" title="Delete"><span class="fa fa-trash-o fa-2x"></span></a>
                    </div>
                    <table class="table q_table">
                        <tr>
                            <th>Description</th>
                            <td><?=$q->description?></td>
                        </tr>
                        <tr>
                            <th>Key Matters</th>
                            <td><?=$q->matter?></td>
                        </tr>
                        <tr>
                            <th>Text for 1st person</th>
                            <td><?=$q->text1?></td>
                        </tr>
                        <tr>
                            <th>Text for 3rd person</th>
                            <td><?=$q->text2?></td>
                        </tr>
                        <tr>
                            <th>Option 1</th>
                            <td><?='<strong>'.$options->option_1_label .'</strong>'.$options->option_1?></td>
                        </tr>
                        <tr>
                            <th>Option 2</th>
                            <td><?='<strong>'.$options->option_2_label .'</strong>'.$options->option_2?></td>
                        </tr>
                        <tr>
                            <th>Option 3</th>
                            <td><?='<strong>'.$options->option_3_label .'</strong>'.$options->option_3?></td>
                        </tr>
                        <tr>
                            <th>Option 4</th>
                            <td><?='<strong>'.$options->option_4_label .'</strong>'.$options->option_4?></td>
                        </tr>
                    </table>
                    <?php
                    echo '</div>';
                    $i++;
                }
            }
        }
        echo '</div>';
    }else{
        echo '<div class="well well-lg">No questions found in this category!</div>';
    }
    ?>



    <div id="dialog-confirm" class="hide">
        <div class="alert alert-info bigger-110">
            question "<span id="item_name"></span>" will be permanently deleted and cannot be recovered.
        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
            <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
            Are you sure?
        </p>
    </div><!-- #dialog-confirm -->

</div>