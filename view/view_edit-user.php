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

        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script>
        <script>
            $.validator.addMethod("regex", function (value, element, pattern) {
                if (pattern instanceof Array) {
                    for (p of pattern) {
                        if (!p.test(value))
                            return false;
                    }
                    return true;
                } else {
                    return pattern.test(value);
                }
            }, "Please enter a valid input.");
            $(function () {
                $('#edituserForm').validate({
                    rules: {
                        username: {
                            remote: {
                                url: 'user/user_exists_service_edit',
                                type: 'post',
                                data: {
                                    username: function () {
                                        return $("#username").val();

                                    },
                                    iduser: function () {
                                        return $("#id").val();
                                    }

                                }
                            },
                            required: true,
                            minlength: 3,
                            maxlength: 16,
                            regex: /^[a-zA-Z][a-zA-Z0-9]*$/,
                        },

                        fullname: {
                            required: true,
                        },
                        email: {
                            remote: {
                                url: 'user/email_exists_service_edit',
                                type: 'post',
                                data: {
                                    username: function () {
                                        return $("#email").val();
                                    },
                                    iduser: function () {
                                        return $("#id").val();
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

                        fullname: {
                            required: 'required',
                        },
                        email: {
                            remote: 'this email is already taken',
                            required: 'required',
                        }
                    }
                });
                $("input:text:first").focus();
            });
        </script> 
        <div class="title">Edit User</div>
        <div class="main">
            Please enter the user details :
            <br><br>
            <form id="edituserForm"action='user/save_user' method="POST">
                <input id ='iduser'type="text" name="id" value="<?php echo $users->id ?>" hidden>
                <table>
                    <tr>
                        <td>User Name:</td>
                        <td><input id="username" name="username" type="text" value="<?php echo $username; ?>"></td>
                        <td class="errors" id="errPseudo"></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td><input id="fullname" name="fullname" type="text" value="<?php echo $fullname; ?>"></td>
                        <td class="errors" id="errFullname"></td>
                    </tr>
                    <tr>
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
                                <?php if ($users->isAdmin($users->username)): ?>
                        <td>Role:</td>
                        <td>                      
                            <select id="role" name="role" >                  
                                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>admin</option>
                                <option value="manager" <?= $role === 'manager' ? 'selected' : '' ?>>manager</option>
                                <option value="member" <?= $role === 'member' ? 'selected' : '' ?>>member</option>
                            </td>
                              <?php endif; ?>
                    </tr>
                                <tr>
                                <?php if ($users->isManager($users->username)): ?>
                        <td>Role:</td>
                        <td>                      
                            <select id="role" name="role" >                  
                                <option value="manager" <?= $role === 'manager' ? 'selected' : '' ?>>manager</option>
                                <option value="member" <?= $role === 'member' ? 'selected' : '' ?>>member</option>
                            </td>
                              <?php endif; ?>
                    </tr>
                    
                </table>
                <input id="id" type="hidden" name="id" value="<?php echo $id ?>" >
                <input type='submit' value='edit'>
            </form>
            <form action='user/save_user' method="POST">
           <input type="submit" name="cancel" value="cancel">
            </form>
        </div>
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
