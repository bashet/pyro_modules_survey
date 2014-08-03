<div id="questions-container">

    <form class="form-horizontal" role="form" id="frm_save_question" method="post" action="{{ url:site }}survey/save_question">
        <legend>General Information About Question</legend>
        <div class="form-group">
            <label for="question_category" class="col-sm-2 control-label">Question category</label>
            <div class="col-sm-10">
                <select class="form-control" id="question_category" name="question_category">
                    <option value="">Select category</option>
                    <?php
                    foreach($question_categories as $cat){
                        echo '<option value="'.$cat->id.'">'.$cat->name.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="question_title" class="col-sm-2 control-label">Question title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="question_title" name="question_title">
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Question description</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="matter" class="col-sm-2 control-label">Why it matters</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="matter" name="matter"></textarea>
            </div>
        </div>

        <legend>Key question</legend>
        <div class="form-group">
            <label for="question_text1" class="col-sm-2 control-label">Question text for 1st person</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="question_text1" name="question_text1"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="question_text2" class="col-sm-2 control-label">Question text for 3rd person</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="question_text2" name="question_text2"></textarea>
            </div>
        </div>

        <legend>Answer Options</legend>
        <div id="question_options">
            <div class="form-group">
                <label for="option_1" class="col-sm-2 control-label">Option 1</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control option_label" name="option_1_label" value="Requires development">
                    <textarea class="form-control" id="option_1" name="option_1"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="option_2" class="col-sm-2 control-label">Option 2</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control option_label" name="option_2_label" value="Emergent">
                    <textarea class="form-control" id="option_2" name="option_2"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="option_3" class="col-sm-2 control-label">Option 3</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control option_label" name="option_3_label" value="Effective">
                    <textarea class="form-control" id="option_3" name="option_3"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="option_4" class="col-sm-2 control-label">Option 4</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control option_label" name="option_4_label" value="Strength">
                    <textarea class="form-control" id="option_4" name="option_4"></textarea>
                </div>
            </div>
        </div>

        <input type="hidden" name="survey_id" value="<?php echo $survey_id;?>">
        <input type="hidden" name="user_id" value="{{ user:id }}">


        <legend>Save Changes</legend>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" id="submit_question_form" class="btn btn-primary btn-block">Save</button>
            </div>
        </div>
    </form>

</div>

<!-- Modal -->
<div class="modal fade" id="q_form_validate_popup" tabindex="-1" role="dialog" aria-labelledby="update_programmeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="update_programmeLabel">Validation message</h4>
            </div>

            <div class="modal-body">
                <span style="color: red"><i class="fa fa-warning fa-3x"></i>  Please check again, all the fields are required to input correctly.</span>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        plugins: [
            "advlist autolink link image lists charmap hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "undo redo | styleselect | sizeselect | bold italic | fontsizeselect |alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        content_css : base_url + "addons/shared_addons/themes/magic/css/style.css"
    });
</script>