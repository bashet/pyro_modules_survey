<div id="questions-container">

    <div style="">
        <?php
        if($survey_id){
            echo '<a href="{{ url:site }}survey/add_new_question/'.$survey_id.'" class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }else{
            echo '<a class="btn btn-primary" ><span class="icon-plus"></span> Add new question</a>';
        }
        ?>
    </div>
    <div id="questions">
        <?php
        if($survey_id){
            if($questions){
                foreach($questions as $q){
                    var_dump($q);
                }
            }else{
                echo 'There is no question available to show!';
            }
        }else{
            echo 'There is no question available to show!';
        }
        ?>
    </div>

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