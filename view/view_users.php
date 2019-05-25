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
       <div class="title"><?php echo $user->fullname; ?>!</div>

               
                 <?php if($user->isAdmin($user->username) || $user->isManager($user->username) ){
                include('menuAdmin.html');
                }
              else{
                    include('menu.html');            
                  }
        ?>
       
       
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
                   <?php if ($user->isAdmin() || $user->isManager()): ?>
                            <form  class="button" action="user/edit_user_prg" method="POST">
                                <input type="hidden" name="id" value="<?= $usr->id ?>">
                                <input type="submit" value="Edit">
                            </form>
                             <?php endif; ?>
                   <?php if ($usr->id != $user->id && $user->isAdmin()): ?>
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
            <?php if ($user->isAdmin()): ?>
            <form class="button" action="user/adduser" method="POST">
                  <input type="hidden" name="id" value="<?= $usr->id ?>">
                <input type="submit" value="New User"  name="new">
            </form>
                <?php endif; ?>
        </div>
    </body>
</html>