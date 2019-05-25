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


    </head>
    <body id="body">


        <script>
            var list;
            var actual;

            $(function () {
                $('#btnsearch').hide();
                $('#search').focus();


                list = $('.list').val();
                actual = $('#memberz').val();

                $('#search').keyup(function () {

                    console.log($('#memberz').val());
                    $.get("book/find_book/" + $('#search').val() + "/" + $('#memberz').val(), function (data) {
                        var DN = JSON.parse(data);
                        displayTable(DN);
                        console.log(actual);

                    });
                });
            });

            function displayTable(datas) {

                var html = "<tr>\n\
                        <th id='isbn' >ISBN</th>" +
                        "<th id='title'>Title</th>" +
                        "<th id='author' >Athor</th>" +
                        "<th id='editor' >Editor</th>" +
                        "<th id='action' >Action</th>\</tr>";


                for (var m = 0; m < datas.length; ++m) {
                    html += "<tr>";
                    html += "<td>" + datas[m].isbn + "</td>";
                    html += "<td>" + datas[m].title + "</td>";
                    html += "<td>" + datas[m].author + "</td>";
                    html += "<td>" + datas[m].editor + "</td>";

                    html += "<td> <form action='book/edit' method='post'><input name='edit' value=' " + datas[m].id + "' hidden><input class='submit' type='submit' value='" + "edit" + "'></form> </td>";
                    html += "<td> <form action='book/delete' method='post'><input name='edit' value=' " + datas[m].id + "' hidden><input class='submit' type='submit' value='" + "delete" + "'></form> </td>";
                    html += "<td> <form action='rental/selection' method='post'><input name='selection' value=' " + datas[m].id + "' hidden><input name='selections' value='" + actual + "' hidden><input class='submit' type='submit' value='" + "selection" + "'></form> </td>";
                    html += "</tr>";
                }
                $('#list').html(html);
            }

        </script>
        <div class="title">Welcome <?= $user->username ?></div>



        <?php
        if ($user->isAdmin($user->username)) {
            include('menuAdmin.html');
        } else {
            include('menu.html');
        }
        ?>
        <div class="list">
            <form action="book/search" method="post">
                <table >
                    <thead>
                        <tr>
                            <td>Filters</td>
                            <td><input  name="critere" type="text" id="search"  placeholder="text"></td>
                    <input type='hidden' id ="userconnect" name='member' value='<?= $smember->username ?>' >
                    <td ><input type="submit" name="search" id="btnsearch"></td>

                    </tr>
                    </thead>
                </table>
            </form><br>
            <table id="list">
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Editor</th>
                       <!--<th>image</th>-->
                        <th>action</th>
                    </tr>
                </thead>
                <?php foreach ($books as $book) : ?>
                    <tr>
                        <td><?= $book->isbn ?></td>
                        <td><?= $book->title ?></td>
                        <td><?= $book->author ?></td>
                        <td><?= $book->editor ?></td>

     <!--<td><img src="upload/<?= $book->picture ?>" style="width:30%; " /></td>-->

                        <td>
                            <?php if ($user->isAdmin($user->username)): ?>
                                <form  action='book/edit_prg' method='post'>
                                    <input type='hidden' name='edit' value='<?= $book->id ?>'>
                                    <input type='submit' value='edit'>
                                </form>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($user->isAdmin($user->username)): ?>
                                <form  action='book/delete_prg' method='post'>
                                    <input type='hidden' name='id_book' value='<?= $book->id ?>'>
                                    <input type='submit' value='delete'>
                                </form>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($user->isManager($user->username)): ?>
                                <form  action='book/details' method='post'>
                                    <input type='hidden' name='details' value='<?= $book->id ?>'>
                                    <input type='submit' value='details'>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form   action='rental/selection' method='post'>
                                <input type='hidden' name='selection' value='<?= $book->id ?>' >
                                <input type='hidden' name='selections' value='<?= $smember->id ?>' >
                                <input type='submit' value='selection'>
                            </form>
                        </td>

                    </tr>

                <?php endforeach; ?>
            </table>

            <?php if ($user->isAdmin($user->username)): ?>
                <form class="button" action="book/add_book" method="POST">
                    <input type="submit" value="Add Book"  name="new">
                </form>

            <?php endif; ?>

            <div class="title">Basket of  <?= $smember->username ?></div>



            Basket of books to rent
            <br>
            <table >
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Editor</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <!--            selection est un ensemble de pré-réservation
                                    en appuyant sur selection on ajoute au panier de l'utilisateur courant/séléctionné
                                    une pré-réservation pour un livre dont la date de début est null-->

                    <?php foreach ($selections as $selection): ?>

                        <tr>
                            <td><?= $selection->isbn ?></td>
                            <td><?= $selection->title ?></td>
                            <td><?= $selection->author ?></td>
                            <td><?= $selection->editor ?></td>
                            <td>
<!--                                <?php if ($user->isAdmin($user->username)): ?>
                                    <form  action='book/edit' method='post'>
                                        <input type='hidden' name='edit' value='<?= $selection->id ?>'>
                                        <input type='submit' value='edit'>
                                    </form>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($user->isAdmin($user->username)): ?>
                                    <form  action='book/delete' method='post'>
                                        <input type='hidden' name='id_book' value='<?= $selection->id ?>'>
                                        <input type='submit' value='delete'>
                                    </form>
                                    </form>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($user->isManager($user->username)): ?>
                                    <form  action='book/details' method='post'>
                                        <input type='hidden' name='details' value='<?= $selection->id ?>'>
                                        <input type='submit' value='details'>
                                    </form>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($user->isManager($user->username)): ?>
                                    <form  action='book/details' method='post'>
                                        <input type='hidden' name='details' value='<?= $selection->id ?>'>
                                        <input type='submit' value='details'>
                                    </form>
                                <?php endif; ?>
                            </td>-->
                            <td>
                                <form   action='rental/deselection' method='post'>
                                    <input type='hidden' name='deselection' value='<?= $selection->title ?>' >
                                    <input type='hidden' name='sdeselection' value='<?= $smember->username ?>' >
                                    <input type='submit' value='deselection'>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($user->isAdmin($user->username)): ?>

                <form class="button" action="rental/user_choice" method="POST">

                    <td>The basket is for:</td>
                    <td>                      
                        <select id="member" name="rental_select" value="rental_select" > 
                            <option value= '<?= $smember->id ?: '' ?>'id="memberz"><?= $smember->username ?></option>
                            <?php foreach ($members as $member): ?>
                                <option value=  '<?= $member->username ?: '' ?>'  ><?= $member->username ?></option>
                            <?php endforeach; ?>   
                    </td>
                    </select>
                    <input type="submit" value="Valider user"   name="new">
                </form>    


            <?php endif; ?><?php ?>


            <form class="button" action="rental/clear_basket" method="POST">
                <input type='hidden' name='memberclearbasket' value='<?= $smember->username ?>' >
                <input type="submit" value="Effacer rental"   name="new">
            </form>
            <form class="button" action="rental/confirm_basket2" method="POST">
                <input type='hidden' name='memberconfirmbasket' value='<?= $smember->username ?>' >
                <input type="submit" name="Save rental" value="Save rental" >
            </form> 



        </div>
    </body>
</html>