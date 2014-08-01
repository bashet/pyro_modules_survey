<div id="send_email_to_evaluators-container">
    <h2>Send email notification to evaluators</h2>
    <p>This is some example text we may add here. But at this moment I don't have idea what to write. I will ask Mark to
        provide the appropriate text for this area. I hope this will look good as am writing many thinks which is probably cowshit.
        Alright, enough let's see how does it look like.. </p>
    <div class="row">
        <form>
            <textarea id="email_body" name="email_body" class="form-control">
                <p>Dear {{evaluator_name}}</p>

                <p>I would be very grateful if you could complete the National College Modular Curriculum online 360 diagnostic leadership for me.  This important process is part of my professional development as a school leader and will help shape my learning within the modular curriclulum. A number of other people will also be rating me on these important competencies. Please could you ensure that you have completed this process by {specify date DD/MM/YYY}.</p>

                <p>The link to provide your ratings is:</p>

                <p>{{ url:site }}</p>

                <p>Regards
                <br>
                {{user_name}}</p>
            </textarea>
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
        height : 600,
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