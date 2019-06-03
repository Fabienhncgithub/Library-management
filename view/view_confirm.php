<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Confirm</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        
                <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script>

        
        
        
    </head>
    <body>
        
        <script>
         function sendjs(){
            console.log($('#idtoDelete').val());
            console.log($('#confirm1').val());
            console.log($('#confrim0').val());
             $.post("book/confirm/",{idtoDelete:$('#idtoDelete').val()}, function(data){
                  console.log(data);
             });
        }
        </script>
        
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
            
            
            
            
           
<!--                <input id ="idtoDelete" type="text" name="idbook" value="<?php echo $books->id ?>" hidden>
               <input id="confirm1" type="radio"  name="confirm" value="1">
                <label>Confirm</label>
                <input id="confrim0" type="radio"  name="confirm" value="0">
                <label>Cancel</label>
                <br><br>
                <input type='submit' value="Sendjs" onclick="sendjs()">-->
            
        </div>
    </body>
</html>


