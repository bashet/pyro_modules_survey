<div id="questions-container">

    <form class="form-horizontal" role="form" id="save_question" method="post" action="{{ url:site }}survey/save_question">
        <legend>Add new question</legend>
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

        <legend>Add answer options</legend>
        <div id="question_options">
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary">Add an option</button>
                </div>
            </div>
        </div>
        <legend>Save changes</legend>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-inverse">Save</button>
            </div>
        </div>
    </form>

</div>