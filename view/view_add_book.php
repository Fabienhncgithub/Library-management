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
        <?php include('menu.html'); ?>
        <div class="main">
            <form method="post" action="book/add_book">

                <table>
                    <tr>
                        <td>ISBN:</td>
                        <td><input id="isbn" name="isbn" type="text" value="<?php  $isbn; ?>"></td>
                    </tr>
                    <tr>
                        <td>Title:</td>
                        <td><input id="title" name="title" type="text" value="<?php  $title; ?>"></td>
                    </tr>
                    <tr>
                        <td>Author:</td>
                        <td><input id="author" name="author" type="text" value="<?php  $author; ?>"></td>
                    </tr>
                    <tr>
                        <td>Editor:</td>
                        <td><input id="editor" name="editor" type="text" value="<?php  $editor; ?>"></td>
                    </tr>
                    <tr>
                        <td>Picture:</td>
                      <td><input type='file' name='picture' accept="picture/x-png, picture/gif, picture/jpeg"></td>
                    </tr>
                </table>
                <input type="submit" name="save" value="Save">
                <input type="submit" name="cancel" value="Cancel">
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