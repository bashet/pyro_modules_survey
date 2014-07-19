<div id="questions-container">

    <form class="form-horizontal" role="form">
        <legend>Add new question</legend>
        <div class="form-group">
            <label for="question_text" class="col-sm-2 control-label">Question Text</label>
            <div class="col-sm-10">
                <!--<textarea class="form-control" id="question_text" name="question_text"></textarea>-->
                <input type="text" class="form-control" id="question_text" name="question_text">
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