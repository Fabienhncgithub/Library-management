<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>filter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script>


        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <script>

            $(function () {
                $('#member').change(function () {
                    var html = "<tr>";
                    console.log($('#member').val());
                    $.get("rental/getrentalJS/" + $('#member').val(), function (data) {
                        console.log(JSON.parse(data));
                        $('#table').html('');
                        var datas = JSON.parse(data);
                        
                        for (var i = 0; i < datas.length; ++i) {
                            html += "<td>" + datas[i].book + "</td>";
                            html += "<td>" + datas[i].id + "</td>";
                            html += "<td>" + datas[i].rentaldate + "</td>";
                            html += "<td>" + datas[i].returndate + "</td>";
                            html += "<input type='submit' id='deletes'>";
                        }
                        html += "</tr>";
                        $('#table').append(html);
                    });
                });

            });
            function test() {
                console.log("test");
                $.get("rental/deleteAllJS/"+$('#member').val(),function(data){
                    location.reload();
                });
                }
            


        </script>


        <div class="title"><?php echo $user->fullname; ?>!</div>

        <?php
        if ($user->isAdmin($user->username) || $user->isManager($user->username)) {
            include('menuAdmin.html');
        } else {
            include('menu.html');
        }
        ?>

        <div class="list">
            <table >
                <td>The basket is for:</td>
                <td>                      
                    <select id="member" name="rental_select" value="rental_select"> 
                        <?php foreach ($members as $member): ?>
                            <option value=  '<?= $member->username ?: '' ?>'  ><?= $member->username ?></option>
                        <?php endforeach; ?>   
                </td>
                </select>
                </form>  
            </table>
            <table id="table">
                Désirez-vous supprimer tout les rental de  <?= $selection->username ?>?
            </table>
            <input type="submit" id="deletes" value="supprimer tous les rentals" onclick="test()">
            </body>
            </html>



