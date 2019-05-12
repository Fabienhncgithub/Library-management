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
      <div class="title">Confirmation page <?= $user->username ?></div>
         <br>Désirez vous vraiment supprimer ce livre?<br>
            <br><br>
        <?php echo $books->title; ?>
      <br><br>
        <div class="confirm">
            <form action='book/confirm_delete' method="POST">
                <input type="text" name="idbook" value="<?php echo $books->id ?>" hidden>
               <input type="radio"  name="confirm" value="1">
                <label>Confirm</label>
                <input type="radio"  name="confirm" value="0">
                <label>Cancel</label>
                <br><br>
                <input type='submit' value="Send">
            </form>
        </div>
    </body>
</html>


