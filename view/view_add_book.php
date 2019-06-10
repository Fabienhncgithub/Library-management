<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script> 
        <script>
            $().ready(function () {
                $("#createbookForm").validate({
                    rules: {
                        isbn: {
                            required: true,
                            number: true,
                            minlength: 12,
                            maxlength: 14,
                            remote: {
                                url: 'book/isbn_available_service',
                                type: 'post',
                                data: {
                                    isbn: function () {
                                        return $("#isbn").val();
                                    }
                                }
                            },
                            required: true,
                        },
                        title: {
                            required: true,
                        },
                        author: {
                            required: true,
                        },
                        editor: {
                            required: true,
                        }
                    },
                    messages: {
                        isbn: {
                            required: "ISBN required",
                            number: "Only numbers",
                            minlength: "ISBN is composed by 13 numbers",
                            remote: "This isbn exists",
                        },
                        title: {
                            required: 'required',
                        },
                        author: {
                            required: 'required',
                        },
                        editor: {
                            required: 'required',
                        }
                    }
                });
                $("input:text:first").focus();
                $('#isbn13').show();
                $('#isbn').keyup(function () {
                    $.get("book/JSIsbn/" + $('#isbn').val(), function (data) {
                        $('#isbn13').val(JSON.parse(data));
                    });
                });
                $('#isbn').focusout(function () {
                    $.get("book/JSIsbnformat/" + $('#isbn').val(), function (data) {
                        $('#isbn').val($('#isbn').val());
                        $('#isbn13').hide();
                    });
                });
            });

        </script>
        <div class="title">Create Book</div>

        <?php include('menuAdmin.html'); ?>

        <div class="main">
            <form id="createbookForm" method="post" action="book/add_book">
                <table>
                    <tr>
                        <td>ISBN:</td>
                        <td><input id="isbn" name="isbn" type="text" value="<?php $isbn; ?>">
                            <input id="isbn13" name="isbn13" type="text" size="1" value="<?php $isbn13; ?>" hidden></td>
                        <td class="errors" id="errPseudo"></td> 
                    </tr>
                    <tr>
                        <td>Title:</td>
                        <td><input id="title" name="title" type="text" value="<?php $title; ?>"></td>
                        <td class="errors" id="errTitle"></td>
                    </tr>
                    <tr>
                        <td>Author:</td>
                        <td><input id="author" name="author" type="text" value="<?php $author; ?>"></td>
                        <td class="errors" id="errAuthor"></td>
                    </tr>
                    <tr>
                        <td>Editor:</td>
                        <td><input id="editor" name="editor" type="text" value="<?php $editor; ?>"></td>
                        <td class="errors" id="errEditor"></td>
                    </tr>
                    <tr>
                        <td>Picture:</td>
                        <td><input type='file' name='picture' accept="picture/x-png, picture/gif, picture/jpeg"></td>
                    </tr>
                </table>
                <input type="submit" name="save" value="Save">
            </form>
            <form method="post" action="book/add_book">
                <input type="submit" name="cancel" value="Cancel">
            </form>
        </div>
              <?php if (!empty($errors)): ?>
                <div class='errors'>
                    <br><br><p>Please correct the following error(s) :</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
    </body>
</html>


