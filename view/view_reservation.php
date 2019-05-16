<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">

        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>filter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Welcome <?= $user->username ?></div>



        <?php
        if ($user->isAdmin($user->username)) {
            include('menuAdmin.html');
        } else {
            include('menu.html');
        }
        ?>
        <div class="main">
            <form action="book/search" method="post">
                <table>
                    <thead>
                        <tr>
                            <td>Filters</td>
                            <td><input id="critere" name="critere" type="text" ></td>
                            <td><input type="submit" name="search"></td>
                        </tr>
                    </thead>
                </table>
            </form><br>
            <table>
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Editor</th>
                        <th>action</th>
                    </tr>
                </thead>
                <?php foreach ($books as $book) : ?>
                    <tr>
                        <td><?= $book->isbn ?></td>
                        <td><?= $book->title ?></td>
                        <td><?= $book->author ?></td>
                        <td><?= $book->editor ?></td>

                        <td>
                            <?php if ($user->isAdmin($user->username)): ?>
                                <form  action='book/edit' method='post'>
                                    <input type='hidden' name='edit' value='<?= $book->id ?>'>
                                    <input type='submit' value='edit'>
                                </form>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($user->isAdmin($user->username)): ?>
                                <form  action='book/delete' method='post'>
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
                                <input type='hidden' name='selections' value='<?= $smember->username ?>' >
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
            <table>
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
                                <?php if ($user->isAdmin($user->username)): ?>
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
                            </td>
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
                           <!--<option value=  <?= $user->username ?: '' ?>><?= $user->username ?></option>-->
                            <?php foreach ($members as $member): ?>
                                <option value=  <?= $member->username ?: '' ?>><?= $member->username ?></option>
                            <?php endforeach; ?>   
                    </td>
                    </select>
                    <input type="submit" value="Valider user"   name="new">
                </form>    


            <?php endif; ?>

            <form class="button" action="rental/clear_basket" method="POST">
                   <input type='hidden' name='memberclearbasket' value='<?= $smember->username ?>' >
                <input type="submit" value="Effacer rental"   name="new">
            </form>
            <form class="button" action="rental/confirm_basket" method="POST">
                   <input type='hidden' name='memberconfirmbasket' value='<?= $smember->username ?>' >
                <input type="submit" name="Save rental" value="Save rental" >
            </form> 



        </div>
    </body>
</html>