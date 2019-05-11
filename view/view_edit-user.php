<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $users->username ?>'s Profile</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Edit User</div>



 //       <?php
 //       if ($user->isAdmin($user->username)) {
 //           include('menuAdmin.html');
 //       } else {
 //           include('menu.html');
 //       }
   //     ?>


        <div class="main">
            Please enter the user details :
            <br><br>
            <form action='user/save_user' method="POST">
                <input type="text" name="id" value="<?php echo $users->id ?>" hidden>
                <table>
                    <tr>
                        <td>User Name:</td>
                        <td><input id="username" name="username" type="text" value="<?php echo $username; ?>"></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td><input id="fullname" name="fullname" type="text" value="<?php echo $fullname; ?>"></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>Email:</td>
                        <td><input id="email" name="email" type="email" value="<?php echo $email; ?>"></td>
                    </tr>
                    <tr>
                        <td>Birth Date:</td>
                        <td><input id="birthdate" name="birthdate" type="date" value="<?php echo $birthdate; ?>"></td>
                    </tr>
                    <tr>
                        <td>Role:</td>
                        <td>                      
                            <select id="role" name="role" >                  
                                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>admin</option>
                                <option value="manager" <?= $role === 'manager' ? 'selected' : '' ?>>manager</option>
                                <option value="member" <?= $role === 'member' ? 'selected' : '' ?>>member</option>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo $id ?>" >
                <input type='submit' value='edit'>
                <input type="submit" name="cancel" value="cancel">
            </form>


            <?php
            if (isset($errors) && count($errors) > 0) {
                echo "<div class='errors'>
                          <p>Please correct the following error(s) :</p>
                          <ul>";
                foreach ($errors as $error) {
                    echo "<li>" . $error . "</li>";
                }
                echo '</ul></div>';
            }
            ?>
        </div>
    </body>
</html>
