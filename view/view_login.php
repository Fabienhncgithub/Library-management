<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log In</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>

        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script>
        <script>
            $().ready(function () {
                $("#loginForm").validate({
                    rules: {
                        username: 'required',
                        password: {
                            required: true,
                            minlength: 8,
                            maxlength: 16,
                        }
                    },
                    messages: {
                        username: 'required',
                    password: {
                            required: 'required',
                            minlength: 'minimum 8 characters',
                        }
                    }
                });
            });
        </script>
    </head>
    <body>
        <div class="title">Log In</div>
        <div class="menu">
            <a href="main/index">Home</a>
            <a href="main/signup">Sign Up</a>
        </div>
        <div class="main">
            <form id="loginForm" action="main/login" method="post">
                <table>
                    <tr>
                        <td>Username</td>
                        <td><input id="username" name="username" type="text" value="<?= $username ?>"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input id="password" name="password" type="password" value="<?= $password ?>"></td>
                    </tr>
                </table>
                <input type="submit" value="Log In">
            </form>
            <?php if (count($errors) != 0): ?>
                <div class='errors'>
                    <p>Please correct the following error(s) :</p>
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
