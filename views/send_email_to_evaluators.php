<div id="send_email_to_evaluators-container container-fluid">
    <h2>Evaluator Invitation</h2>
    <!--<p>Your evaluators will now be notified that they have been nominated to contribute to your 360 diagnostic survey.
        Please find below the default text which will be sent to all of your nominated evaluators.
        To edit this message, please click in the box below prior to sending</p>-->
    <div class="">
        <form id="frm_send_email_evaluators" method="post" action="#">
            <textarea id="email_body" name="email_body" class="form-control">
                <p>I would be very grateful if you could complete the Leadership CoLab 360 Diagnostic survey for me.
                    This process forms an important part of my personal development. </p>
                <p>This process forms an important part of my personal development. A number of other evaluators have also been nominated to complete this survey on my behalf.
                    Please could I ask you to complete this survey by [DD/MM/YY].</p>
            </textarea>
        </form>
    </div>

    <br>
    <div class="" style="float: right">
        <button class="btn btn-primary" id="btn_send_email"><span class="glyphicon glyphicon-envelope"></span>  Send Email</button>
    </div>
</div>

<script>
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        height : 400,
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