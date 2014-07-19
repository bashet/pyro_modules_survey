<div id="questions-container">

    <div style="">
        <?php
        if($survey_id){
            echo '<a href="{{ url:site }}survey/add_new_question" class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }else{
            echo '<a class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }
        ?>
    </div>

    <table id="all_question" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th style="width: 8%">SN</th>
            <th style="width: 25%">Name</th>
            <th style="width: 35%">Description</th>
            <th style="width: 10%">Edit</th>
            <th style="width: 10%">Delete</th>
            <th style="width: 10%">Questions</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 1;
        if($survey_id){
            foreach($questions as $d){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$d->name.'</td>';
                echo '<td>'.$d->description.'</td>';
                echo '<td style="text-align: center"><a href="#" edit_question id="edit_question-'.$d->id.'" title="Edit '.$d->name.'"><i class="fa fa-pencil-square-o fa-lg"></i></a></td>';
                echo '<td style="text-align: center"><a href="#" delete_question id="del_question-'.$d->id.'" title="Delete '.$d->name.'"><i class="fa fa-trash-o fa-lg"></i></a></td>';
                echo '<td style="text-align: center"><a href="{{url:site}}question/questions/'.$d->id.'" title="Manage questions for '.$d->name.'"><i class="fa fa-list-alt fa-lg"></i></a></td>';
                echo '</tr>';
                $i++;
            }
        }else{
            echo '<span style="color: red">You did not chose any survey to manage questions. Please chose a survey from manage survey screen.</span>';
        }
        ?>
        </tbody>
    </table>

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