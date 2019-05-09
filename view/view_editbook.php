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
       
        
        
                
                <?php if($user->isAdmin($user->username)){
                include('menuAdmin.html');
                }
              else{
                    include('menu.html');            
                  }
        ?>
        
        
        
        <div class="main">


            Please enter the book details :
            <br><br>
            <form action='book/edit_book' method="POST">

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
                        <?php if (strlen($books->picture) == 0): ?>
                            No picture loaded yet!
                        <?php else: ?>
                        <img src='upload/<?= $books->picture ?>'>  
                    <?php endif; ?>

                    <td><input type='file' name='picture' accept="picture/x-png, picture/gif, picture/jpeg"><br></td>

                    </tr>
                </table>


                <input type="text" name="id" value=<?php echo $books->id ?> hidden>
                <input type='submit' name = "id" value="<?php echo $id ?>" >
 <!--<input type='submit' value='edit'>-->
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