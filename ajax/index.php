<!DOCTYPE html>
<html>
<head>
    <title>Ajax</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/main.css"/>
</head>
<body>
<div class="container p-3">
    <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>Manage MyGuestBook</h2>
    </div>
    <div class="card bg-dark text-white">
        <div class="card-body">
            <form id="theform">
                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input type="text" name="user" class="form-control" id="inputName">
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="text" name="email" class="form-control" id="inputEmail">
                </div>

                <div class="form-group">
                    <label for="inputComment">Comment</label>
                    <textarea name="comment" class="form-control" id="inputComment" rows="3"></textarea>
                </div>

                <input type="hidden" name="id">
                <button type="button" id="submit" class="btn btn-primary">Add a New Comment</button>
                <button type="button" id="update" class="btn btn-primary">Edit This Comment</button>
                <button type="button" id="cancel" class="btn btn-danger">Cancel</button>
                <button type="button" id="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>
    </div>
    <hr/>
    <h2>List of Comments</h2>
    <div id="listing"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        const url = 'http://lrgs.ftsm.ukm.my/users/a174652/week14lab'
        hideUpdateButtons();
        listing();

        $('#listing').on('click', '.delete', function () {
            $.ajax({
                type: 'DELETE',
                url: url + "/myguestbook_api/guestbook/" + $(this).val(),
                beforeSend: function (xhr) {
                    $("#listing").html("<img src='ajax.gif'>");
                },
                success: function (result) {
                    listing();
                },
                error: function (xhr, status) {
                    $("#listing").html(xhr.responseText);
                },
            });
        });

        $("#cancel").click(function () {
            hideUpdateButtons();
            resetForm($('#theform'));
        });

        $("#update").click(function () {
            var data = $('#theform').serialize();
            $.ajax({
                type: 'PUT',
                data: data,
                url: url + "/myguestbook_api/guestbook/" + $('[name=id]').val(),
                beforeSend: function (xhr) {
                    $("#listing").html("<img src='ajax.gif'>");
                },
                success: function (result) {
                    listing();
                    hideUpdateButtons();
                    resetForm($('#theform'));
                },
                error: function (xhr, status) {
                    $("#listing").html(xhr.responseText);
                },
            });
        });

        $('#listing').on('click', '.edit', function () {
            $.ajax({
                type: 'GET',
                url: url + "/myguestbook_api/guestbook/" + $(this).val(),
                success: function (result) {
                    $('[name=user]').val(result[0].user);
                    $('[name=email]').val(result[0].email);
                    $('[name=comment]').val(result[0].comment);
                    $('[name=id]').val(result[0].id);
                    $('#update').show();
                    $('#cancel').show();
                    $('#submit').hide();
                },
                error: function (xhr, status) {
                    $("#listing").html(xhr.responseText);
                },
            });
        });

        $("#submit").click(function () {
            var data = $('#theform').serialize();
            $.ajax({
                type: 'POST',
                data: data,
                url: url + "/myguestbook_api/guestbook/",
                beforeSend: function (xhr) {
                    $("#listing").html("<img src='ajax.gif'>");
                },
                success: function (result) {
                    listing();
                    resetForm($('#theform'));
                },
                error: function (xhr, status) {
                    $("#listing").html(xhr.responseText);
                },
            });
        });

        $("#reset").click(function () {
            resetForm($('#theform'));
        });

        function listing() {
            $.ajax({
                type: 'GET',
                cache: false,
                url: url + "/myguestbook_api/guestbooks/",
                beforeSend: function (xhr) {
                    $("#listing").html("<img src='ajax.gif'>");
                },
                success: function (result) {
                    let textToInsert = '';
                    let id = '';
                    const header = '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Comment</th><th>Date</th><th>Time</th><th>Action</th></tr></thead>';

                    $.each(result, function (row, rowdata) {
                        textToInsert += '<tr>';
                        $.each(rowdata, function (idx, eledata) {
                            if (idx === 'id') {
                                id = eledata;
                            }
                            textToInsert += '<td>' + eledata + '</td>';
                        });
                        textToInsert += '<td><button class="btn btn-info edit" value="' + id + '">Edit</button> <button value="' + id + '" class="btn btn-danger delete">Delete</button></td>';
                        textToInsert += '</tr>';
                    });

                    $("#listing").html('<table class="table table-bordered text-white" border=1>' + header + '<tbody>' + textToInsert + '</tbody></table>');
                },
                error: function (xhr, status) {
                    $("#listing").html(xhr.responseText);
                },
            });
        }

        function hideUpdateButtons() {
            $('#update').hide();
            $('#cancel').hide();
            $('#submit').show();
        }

        function resetForm($form) {
            $form.find('input:text, input:password, input:file, select, textarea').val('');
            $form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        }

    });

</script>
</body>
</html>
