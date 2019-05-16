
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
         <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script>
            var username, errPseudo, password, errPassword, passwordConfirm, errPasswordConfirm ;
            
            $(function(){
                    username = $("#username");
                    errPseudo = $("#errPseudo");
                    password = $("#password");
                    errPassword = $("#errPassword");
                    passwordConfirm = $("#passwordConfirm");
                    errPasswordConfirm = $("#errPasswordConfirm");
                    
                    $("input:text:first").focus();
                }
            );
            
            function checkPseudoExists(){
                $.get("user/user_exists_service/"+username.val(),
                      function(data){
                          if(data === "true"){
                              errPseudo.append("<p>Pseudo already exists.</p>");
                          }
                      }
                );
            }

            function checkPseudo(){
                var ok = true;
                errPseudo.html("");
                if(!(/^.{3,16}$/).test(username.val())){
                    errPseudo.append("<p>username length must be between 3 and 16.</p>");
                    ok = false;
                }
                if(username.val().length > 0 && !(/^[a-zA-Z][a-zA-Z0-9]*$/).test(username.val())){
                    errPseudo.append("<p>Pseudo must start by a letter and must contain only letters and numbers.</p>");  
                    ok = false;
                }
                return ok;
            }
            
            function checkPassword(){
                var ok = true;
                errPassword.html("");
                var hasUpperCase = /[A-Z]/.test(password.val());
                var hasNumbers = /\d/.test(password.val());
                var hasPunct = /['";:,.\/?\\-]/.test(password.val());
                if(!(hasUpperCase && hasNumbers && hasPunct)){
                    errPassword.append("<p>Password must contain one uppercase letter, one number and one punctuation mark.</p>");
                    ok = false;
                }
                if(!(/^.{8,16}$/).test(password.val())){
                    errPassword.append("<p>Password length must be between 8 and 16.</p>");
                    ok = false;
                }
                return ok;
            }
            
            function checkPasswords(){
                var ok = true;
                errPasswordConfirm.html("");
                if(password.val() !== passwordConfirm.val()){
                    errPasswordConfirm.append("<p>You have to enter twice the same password.</p>");
                    ok = false;
                }
                return ok;
            }
            
            function checkAll(){
                // les 3 lignes ci-dessous permettent d'éviter le shortcut
                // par rapport à checkPseudo()&&checkPassword()&&checkPasswords();
                var ok = checkPseudo();
                ok = checkPassword() && ok;
                ok = checkPasswords() && ok;
                return ok;
            }   
        
        </script>
    </head>
    <body>
        <div class="title">Sign Up</div>
        <div class="menu">
            <a href="index.php">Home</a>
        </div>
        <div class="main">
            Please enter your details to sign up :
            <br><br>
            <form id="signupForm" action="main/signup" method="post">
                <table>
                    <tr>
                    <td>Username:</td>
                        <td><input id="username" name="username" type="text" size="16" value="<?= $username ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input id="password" name="password" type="password" size="16" value="<?= $password ?>"></td>
                        <td class="errors" id="errPassword"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input id="passwordConfirm" name="password_confirm" size="16" type="password" value="<?= $password_confirm ?>"></td>
                        <td class="errors" id="errPasswordConfirm"></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td><input id="fullname" name="fullname" type="text" value="<?php echo $fullname; ?>"></td>
                        <td class="errors" id="errFullname"></td>

                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input id="email" name="email" type="email" value="<?php echo $email; ?>"></td>
                    </tr>
                    <tr>
                        <td>Birth Date:</td>
                        <td><input id="birthdate" name="birthdate" type="date" value="<?php echo $birthdate; ?>"></td>
                    </tr>
                </table>
                     <input id="btn" type="submit" value="Sign Up">
            </form>
            <?php if(count($errors)!=0): ?>
                <div class='errors'>
                    <br><br><p>Please correct the following error(s) :</p>
                    <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
