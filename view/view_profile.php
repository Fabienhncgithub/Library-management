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
     
        
                <?php if($user->isAdmin($user->username) || $user->isManager($user->username) ){
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
            
            
            <tr>There are your currently rented books. Don't forget to return them in time!</tr>

            
            <table>
                <tr>
                    <th>Rental Date/Time</th>
                    <th>Book</th>
                    <th>To be returned on</th>
                </tr>
        </thead>
        <tbody>
            
                <?php foreach ($rentals as $rental):?>
                <tr>
                    <td><?= $rental->rentaldate ?></td>
                    <td><?= $rental->book ?></td>
                    <td><?= $rental->returndate ?></td>
                </tr>
             
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>