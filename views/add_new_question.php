<div id="questions-container">

    <form class="form-horizontal" role="form" id="save_question" method="post" action="{{ url:site }}survey/save_question">
        <legend>Question Text</legend>
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
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary">Add an option</button>
                </div>
            </div>
        </div>

        <input type="hidden" name="survey_id" value="<?php echo $survey_id;?>">
        <input type="hidden" name="user_id" value="{{ user:id }}">


        <legend>Save Changes</legend>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-inverse">Save</button>
            </div>
        </div>
    </form>

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
        toolbar: "insertfile undo redo | styleselect | sizeselect | bold italic | fontselect |  fontsizeselect |alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
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