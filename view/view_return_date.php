<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>Books</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title"><?php echo $user->fullname; ?>!</div>
        <?php
        if ($user->isAdmin($user->username)) {
            include('menuAdmin.html');
        } else {
            include('menu.html');
        }
        ?>
        <div class="main">
           <br>choisir une date de retour pour le livre:<br>
            <br><br>
        <?php echo $book->title; ?>
               <br><br>
                  <br><br>
            <form action="rental/insert_return_date" method="post">
                <input type="hidden" name="book" value="book">
                <table>
                            <td>Rental date: <input id="return_date" name="return_date" type="date"></td>
                                 <input type='hidden' name='return' value='<?= $returns->id ?>'>
                </table>
                <th><input type="submit" name="insert_return_date"></th>
                </tbody>
            </table>
        </div>
    </body>
</html>




               