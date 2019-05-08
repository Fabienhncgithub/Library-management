<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $user->username ?>'s Profile!</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Welcome <?= $user->username ?></div>
     
        
                <?php if($user->isAdmin($user->username)){
                include('menuAdmin.html');
                }
              else{
                    include('menu.html');            
                  }
        ?>
        
        
        <div class="main">
            <?php if (strlen($user->username) == 0): ?>
                No profile string entered yet!
            <?php else: ?>
                <?= $user->username; ?>
            <?php endif; ?>
            <br><br>
            <table>
                <tr>There are your currently rented books. Don't forget to return them in time!</tr>
                <br>
                <tr>
                    <td>Rental Date/Time</td>
                    <td>Book</td>
                    <td>To be returned on</td>
                </tr>
                <br>
                <?php foreach ($rentals as $rental):?>
                <tr>
                    <td><?php $rental -> rentaldate ?></td>
                    <td><?php $rental -> book ?></td>
                    <td><?php $rental -> returndate ?></td>
                </tr>
                <?php var_dump($rentals) ?>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>