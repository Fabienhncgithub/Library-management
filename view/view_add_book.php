<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Create Book</div>
       

        
        <div class="main">
            <form method="post" action="book/add_book">

                <table>
                    <tr>
                        <td>ISBN:</td>
                        <td><input id="isbn" name="isbn" type="text" value="<?php $isbn; ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>Title:</td>
                        <td><input id="title" name="title" type="text" value="<?php $title; ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>Author:</td>
                        <td><input id="author" name="author" type="text" value="<?php $author; ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>Editor:</td>
                        <td><input id="editor" name="editor" type="text" value="<?php $editor; ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>Picture:</td>
                        <td><input type='file' name='picture' accept="picture/x-png, picture/gif, picture/jpeg"></td>
                    </tr>
                </table>
                <input type="submit" name="save" value="Save">
                <input type="submit" name="cancel" value="Cancel">
            </form>
            <?php if (count($errors) != 0): ?>
                <div class='errors'>
                    <br><br><p>Please correct the following error(s) :</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>


