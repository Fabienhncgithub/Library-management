<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>filter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title"><?php echo $user->fullname; ?>!</div>
           
       <?php if($user->isAdmin($user->username) || $user->isManager($user->username) ){
            include('menuAdmin.html');
        } else {
            include('menu.html');
        }
        ?>
        <div class="main">
            <form>
                <table>
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Editor</th>
                            <th>picture</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <?php foreach ($books as $book) : ?>
                        <tr>
                            <td><?= $book->isbn ?></td>
                            <td><?= $book->title ?></td>
                            <td><?= $book->author ?></td>
                            <td><?= $book->editor ?></td>
                            <td><?= $book->picture ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </div>
    </body>
</html>
        