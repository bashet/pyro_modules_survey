<div id="user_survey-container">
    <?php
    if(($total_evaluators) && $total_evaluators >= 3){
        echo 'here is now showing questions to be answered';
        var_dump($survey);
    }else{
        echo    '<h2>You have not nominated enough evaluators</h2>
                <p>Once you have nominated at least 3 evaluators you will be able to complete the questions</p>';
    }
    ?>

</div>