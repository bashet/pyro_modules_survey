<div id="questions-container">

    <form class="form-horizontal" role="form" id="save_question" method="post" action="{{ url:site }}survey/update_options">

        <legend>Default Options</legend>
        <div id="question_options">
            <div class="form-group">
                <label for="option_1" class="col-sm-2 control-label">Option 1</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="option_1" name="option_1"><?php echo $options->option_1?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="option_2" class="col-sm-2 control-label">Option 2</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="option_2" name="option_2"><?php echo $options->option_2?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="option_3" class="col-sm-2 control-label">Option 3</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="option_3" name="option_3"><?php echo $options->option_3?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="option_4" class="col-sm-2 control-label">Option 4</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="option_4" name="option_4"><?php echo $options->option_4?></textarea>
                </div>
            </div>
        </div>

        <input type="hidden" name="user_id" value="{{ user:id }}">


        <legend>Save Changes</legend>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
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