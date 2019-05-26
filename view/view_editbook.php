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
                                    idbook: function () {
                                        return $("#id").val();
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
            });
        </script>
        <div class="title">Edit Book</div>
        <div class="main">
            Please enter the book details :
            <br><br>
            <form id="editbookForm" action='book/edit_book' method="POST">
                <input id ="idbook" type="hidden" name="id" value=<?php echo $books->id ?>>

                <table> 
                    <tr>
                        <td>isbn:</td>
                        <td><input id="isbn" name="isbn" type="text" value="<?php echo $isbn; ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>titre:</td>
                        <td><input id="title" name="title" type="text" value="<?php echo $title; ?>"></td>
                        <td class="errors" id="errTitle"></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>author:</td>
                        <td><input id="author" name="author" type="text" value="<?php echo $author; ?>"></td>
                        <td class="errors" id="errAuthor"></td>
                    </tr>
                    <tr>
                        <td>editor:</td>
                        <td><input id="editor" name="editor" type="text" value="<?php echo $editor; ?>"></td>
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
                <input id="idbook" type="hidden" name = "id" value="<?php echo $id ?>" >
                <input type='submit' value='edit'>
            </form>
            <form action='book/edit_book' method="POST">
                <input type="submit" name="cancel" value="cancel">
            </form>
            <?php
            if (isset($errors) && count($errors) > 0) {
                echo "<div class='errors'>
                          <p>Please correct the following error(s) :</p>
                          <ul>";
                foreach ($errors as $error) {
                    echo "<li>" . $error . "</li>";
                }
                echo '</ul></div>';
            }
            ?>
        </div>
    </body>
</html>