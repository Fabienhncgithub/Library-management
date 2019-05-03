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
        <div class="title">Edit Book</div>
          <?php include('menu.html'); ?>
        <div class="main">
            
            
        Please enter the book details :
            <br><br>
                <form action='book/edit_book' method="POST">
                <input type="text" name="id" value="<?php echo $books->id ?>" hidden>
                <table> 
                    <tr>
                        <td>isbn:</td>
                        <td><input id="isbn" name="isbn" type="text" value="<?php echo $isbn; ?>"></td>
                    </tr>
                    <tr>
                        <td>titre:</td>
                        <td><input id="title" name="title" type="text" value="<?php echo $title; ?>"></td>
                    </tr>
                            <tr>
                    <tr>
                        <td>author:</td>
                        <td><input id="author" name="author" type="text" value="<?php echo $author; ?>"></td>
                    </tr>
                    <tr>
                        <td>editor:</td>
                        <td><input id="editor" name="editor" type="text" value="<?php echo $editor; ?>"></td>
                    </tr>
                    <tr>
                        <td>Picture:</td>
                        <td>                      
                            
                        </td>
                    </tr>
                </table>
                    
<!--                    
                    <?php foreach ($books as $book) : ?>
                        <p>isbn : </p>
                        <input type='isbn' name='isbn' value='<?= $book->isbn ?>' >
                        <p>titre : </p>
                        <input type='titre' name='title' value='<?= $book->title ?>' >
                        <p>Author : </p>
                        <input type='Author' name='author' value='<?= $book->author ?>' >
                        <p>Editor : </p>
                        <input type='editor' name='editor' value='<?= $book->editor ?>'>
                        <p>Picture : </p>
                        <?php if (strlen($book->picture) == 0): ?>
                            No picture loaded yet!
                        <?php else: ?>
                            <img src='upload/<?= $book->picture ?>'>  
                        <?php endif; ?>
                    <?php endforeach ?>   
                Image: <input type='file' name='picture' accept="picture/x-png, picture/gif, picture/jpeg"><br><br>
               -->
                  </table>

                     <input type='submit' name = "id" value="<?php  echo $id ?>" >
<!--                <input type="submit" name="save" value="<?php $id?>">-->
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