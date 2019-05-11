<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $user->username ?> Add User</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Add User</div>
       
        
          <?php include('menuAdmin.html'); ?>
    
        <div class="main">
            Please enter the user details :
            <br><br>
            <form id="adduser" action="user/adduser" method="post">
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
                        <td>Password:</td>
                        <td><input id="password" name="password" type="password" size="16" value="<?= $password ?>"></td>
                        <td class="errors" id="errPassword"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input id="passwordConfirm" name="password_confirm" size="16" type="password" value="<?php $password_confirm ?>"></td>
                        <td class="errors" id="errPasswordConfirm"></td>
                    </tr>
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
                                <option value="admin" >admin</option>
                                <option value="manager" >manager</option>
                                <option value="member" >member</option>
                        </td>
                    </tr>
                        
                        
                        
                </table>                    

                </table>
                <input type="submit" name="save" value="Save">
                <input type="submit" name="cancel" value="Cancel">
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




