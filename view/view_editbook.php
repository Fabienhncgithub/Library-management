<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
                <title><?= $book->title ?></title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Edit Book</div>
          <?php include('menu.html'); ?>
        <div class="main">
                <table>                   
                     <form method='post' action='book/edit_book'>                         
                    <?php foreach ($books as $book) : ?>
                        <p>isbn : </p>
                        <input type='isbn' name='isbn' value='<?= $book->isbn ?>' >
                        <p>titre : </p>
                        <input type='titre' name='titre' value='<?= $book->title ?>' >
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
                Image: <input type='file' name='image' accept="image/x-png, image/gif, image/jpeg"><br><br>
               
            
                     <input type='submit' value='Save'>
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