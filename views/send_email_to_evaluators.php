<div id="send_email_to_evaluators-container">
    <h2>Send email notification to evaluators</h2>
    <p>This is some example text we may add here. But at this moment I don't have idea what to write. I will ask Mark to
        provide the appropriate text for this area. I hope this will look good as am writing many thinks which is probably cowshit.
        Alright, enough let's see how does it look like.. </p>
    <div class="row">
        <form>
            <textarea id="email_body" name="email_body" class="form-control"></textarea>
        </form>
    </div>

    <br>
    <div class="row" style="float: right">
        <button class="btn btn-primary" id="btn_send_email"><span class="glyphicon glyphicon-envelope"></span>  Send Email</button>
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