<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $books->title ?></title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script> 
        <script>
            $().ready(function () {
                $("#editbookJS").show();
                $("#btnEdit").hide();
                $("#editbookForm").validate({
                    rules: {
                        isbn: {
                            required: true,
                            number: true,
                            minlength: 13,
                            remote: {
                                    url: 'book/isbn_available_service_edit',
                                type: 'post',
                                data: {
                                    isbn: function () {
                                        return $("#isbn").val();
                                    },
                                    id: function () {
                                        return $("#idbook").val();
                                    }
                                }
                            },
                           
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
                            remote: 'this ISBN is already taken',
                            required: "ISBN required",
                            number: "Only numbers",
                            minlength: "ISBN is composed by 13 numbers",
                           
                        },
                        password: {
                            required: 'required',
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
                        $('#isbn').val($('#isbn').val() + $('#isbn13').val());
                        $('#isbn13').hide();
                    });
                });
                
                
            });
        </script>
        <div class="title">Edit Book</div>
        <div class="main">
            Please enter the book details :
            <br><br>
            <form id="editbookForm" action='book/edit_book' method="post">
                <input id ="idbook" type="hidden" name="id" value=<?= $books->id ?>>

                <table> 
                    <tr>
                        <td>isbn:</td>
                        <td><input id="isbn" name="isbn" type="text" value="<?php echo $books->isbn; ?>">
                           <input id="isbn13" name="isbn13" type="text" size="1" value="<?php echo $books->isbn; ?>" hidden></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>titre:</td>
                        <td><input id="title" name="title" type="text" value="<?php echo $books->title; ?>"></td>
                        <td class="errors" id="errTitle"></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>author:</td>
                        <td><input id="author" name="author" type="text" value="<?php echo $books->author; ?>"></td>
                        <td class="errors" id="errAuthor"></td>
                    </tr>
                    <tr>
                        <td>editor:</td>
                        <td><input id="editor" name="editor" type="text" value="<?php echo $books->editor; ?>"></td>
                        <td class="errors" id="errEditor"></td>
                    </tr>
                    <tr>
                        <td>Picture:</td>
                        <?php if (strlen($books->picture) == 0): ?>
                            No picture loaded yet!
                        <?php else: ?>
                        <img src='upload/<?= $books->picture ?>'>  
                    <?php endif; ?>
                    <td><input type='file' name='picture' accept="picture/x-png, picture/gif, picture/jpeg"><br></td>
                    </tr>
                </table>
                <!--<input id="idbook" type="hidden" name = "id" value="< ?= $books->id ?>" >-->
                <input id="" type='submit' value='edit'>
            </form>
            <form action='book/edit_book' method="POST">
                <input type="submit" name="cancel" value="cancel">
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