<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Users</div>
        <?php include('menu.html'); ?>
        <div class="main">
            <table class="message_list">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Birth Date</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $usr) : ?>
                        <tr>
                        <td><?= $usr->username?></td>
                        <td><?= $usr->fullname ?></td>
                        <td><?= $usr->email?></td>
                        <td><?= $usr->birthdate?></td>
                        <td><?= $usr->role ?></td>
                        <td>
                            <form class="button" action="user/add_user" method="POST">
                                <input type="hidden" name="id" value="<?= $usr->id ?>">
                                <input type="submit" value="Edit">
                            </form>
                            <?php if ($usr->isAdmin() && $usr->id !== $user->id): ?>
                                <form class="button" action="user/delete_user" method="POST">
                                    <input type="hidden" name="id" value="<?= $usr->id ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            <?php endif; ?>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <form class="button" action="add_edit_user.php" method="GET">
                <input type="submit" value="New User">
            </form>
        </div>
    </body>
</html>