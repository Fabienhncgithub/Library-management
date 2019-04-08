<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Confirm</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Confirm</div>
        <?php echo $user->username; ?>
        
        <div class="confirm">

<!--            <form class="button" action='book/confirm_delete' method="POST">
             <input  type="hidden" name="idbook" value="<?php $books->id ?>">-->
                        <form action='book/confirm_delete' method="POST">
                <input type="text" name="idbook" value="<?php echo $books->id ?>" hidden>
             
             
             
               <input type="radio"  name="confirm" value="1">
                <label>Confirm</label>
                <input type="radio"  name="confirm" value="0">
                <label>Cancel</label>
                <br>
                <input type='submit' value="Send">
            </form>
        </div>
    </body>
</html>


