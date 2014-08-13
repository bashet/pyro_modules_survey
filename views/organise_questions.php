<div id="organise-container">
    <h2>Please drag each item and drop to set the new position.</h2>
    <div class="well well-lg">
        <div class="dd" id="<?=$cat->id?>">
            <ol class="dd-list">
                <?php
                    $sort_order = json_decode($cat->questions);
                    if($questions){
                        $i = 1;
                        foreach($sort_order as $order){
                            foreach($questions as $q){
                                if($order == $q->id){
                                    echo '<li class="dd-item" data-id="'.$q->id.'">
                                        <div class="dd-handle">'.$i.' - '.$q->title.'</div>
                                  </li>';
                                }
                            }
                            $i++;
                        }
                    }
                ?>
            </ol>
        </div>
        <?php
        if( ! $questions){
            echo 'No questions found to organise';
        }
        ?>
    </div>
</div>