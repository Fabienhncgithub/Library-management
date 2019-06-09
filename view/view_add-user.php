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
          
  <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script>
        <script>
            $.validator.addMethod("regex", function (value, element, pattern) {
                if (pattern instanceof Array) {
                    for(p of pattern) {
                        if (!p.test(value))
                            return false;
                    }
                    return true;
                } else {
                    return pattern.test(value);
                }
            }, "Please enter a valid input.");
            $(function(){
                $('#adduserForm').validate({
                    rules: {
                        username: {
                            remote: {
                                url: 'user/user_exists_service',
                                type: 'post',
                                data:  {
                                    username: function() { 
                                        return $("#username").val();
                                    }
                                }
                            },
                            required: true,
                            minlength: 3,
                            maxlength: 16,
                            regex: /^[a-zA-Z][a-zA-Z0-9]*$/,
                        },
                        password: {
                            required: true,
                            minlength: 8,
                            maxlength: 16,
                            regex: [/[A-Z]/, /\d/, /['";:,.\/?\\-]/],
                        },
                        password_confirm: {
                            required: true,
                            minlength: 8,
                            maxlength: 16,
                            equalTo: "#password",
                            regex: [/[A-Z]/, /\d/, /['";:,.\/?\\-]/],
                        },
                        fullname: {
                             required: true,
                        },
                        email: {
                               remote: {
                                url: 'user/email_exists_service',
                                type: 'post',
                                data:  {
                                    username: function() { 
                                        return $("#email").val();
                                    }
                                }
                            },
                             required: true,
                        }
                    },
                    messages: {
                        username: {
                            remote: 'this username is already taken',
                            required: 'required',
                            minlength: 'minimum 3 characters',
                            maxlength: 'maximum 16 characters',
                            regex: 'bad format for username',
                        },
                        password: {
                            required: 'required',
                            minlength: 'minimum 8 characters',
                            maxlength: 'maximum 16 characters',
                            regex: 'bad password format',
                        },
                        password_confirm: {
                            required: 'required',
                            minlength: 'minimum 8 characters',
                            maxlength: 'maximum 16 characters',
                            equalTo: 'must be identical to password above',
                            regex: 'bad password format',
                        },
                          fullname: {
                               required: 'required', 
                        },
                        email:{
                            remote: 'this email is already taken',
                            required: 'required', 
                        }
                    }
                });
                $("input:text:first").focus();
            });
        </script>
        <div class="title">Add User</div>
       
        
             
       <?php include('menuAdmin.html');?>
    
        <div class="main">
            Please enter the user details :
            <br><br>
            <form id="adduserForm" action="user/adduser" method="post">
                <table>
                    <tr>
                        <td>User Name:</td>
                        <td><input id="username" name="username" type="text" value="<?php echo $username; ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td><input id="fullname" name="fullname" type="text" value="<?php echo $fullname; ?>"></td>
                          <td class="errors" id="errPassword"></td>
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
                             <td class="errors" id="errEmail"></td>
                    </tr>
                    <tr>
                        <td>Birth Date:</td>
                        <td><input id="birthdate" name="birthdate" type="date" value="<?php echo $birthdate; ?>"></td>
                            <td class="errors" id="errBirthdate"></td>
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
                <input type="submit" name="save" value="Save">
            </form>
                <form action="user/adduser" method="post">
           <input type="submit" name="cancel" value="cancel">
            </form>
            
            
              <?php if (!empty($errors)): ?>
                <div class='errors'>
                    <br><br><p>Please correct the following error(s) :</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>




