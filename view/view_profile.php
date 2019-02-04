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
        <div class="title"><?= $user->username ?>'s Profile!</div>
        <?php include('menu.html'); ?>
        <div class="main">
            <?php if (strlen($user->username) == 0): ?>
                No profile string entered yet!
            <?php else: ?>
                <?= $user->username; ?>
            <?php endif; ?>
            <br><br>
            
            <br>
            <br>
            
        </div>
    </body>
</html>