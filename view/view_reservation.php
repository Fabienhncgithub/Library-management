<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>Books</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title"><?php echo $user->fullname; ?>!</div>
        <?php include('menu.html'); ?>
        <div class="main">
            <form action="book/search" method="post">
                <table>
                    <thead>
                        <tr>
                            <td>Filters: </td>
                            <td><input id="critere" name="critere" type="text" ></td>
                            <th><input type="submit" name="search"></th>
                        </tr>
                </table>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Editor</th>
                        <th>picture</th>
                        <th>action</th>
                    </tr>
                </thead><br>
                <?php foreach($books as $book): ?>
                    <tr>
                        <td><?= $book->isbn ?></td>
                        <td><?= $book->title ?></td>
                        <td><?= $book->author ?></td>
                        <td><?= $book->editor ?></td>
                        <td><?= $book->picture ?></td>
                        <td>
                            <form  action='book/details' method='post'>
                                <input type='hidden' name='details' value='<?= $book->id ?>'>
                                <input type='submit' value='details'>
                            </form>
                        </td>
                        <td>
                            <form action='book/selection' method='post'>
                                <input type='hidden' name='selection' value='<?= $book->id ?>' >
                                <input type='submit' value='selection'>
                            </form>
                        </td>
                    </tr>       
                    </tr>       
                <?php endforeach; ?>
            </table><br>
            <table>
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Editor</th>
                        <th>picture</th>
                        <th>action</th>
                    </tr>
                </thead><br>
                <?php foreach($selections as $selection): ?>
                    <tr>
                        <td><?= $selection->isbn ?></td>
                        <td><?= $selection->title ?></td>
                        <td><?= $selection->author ?></td>
                        <td><?= $selection->editor ?></td>
                        <td><?= $selection->picture ?></td>
                        <td>
                            <form  action='book/details' method='post'>
                                <input type='hidden' name='details' value='<?= $selection->id ?>'>
                                <input type='submit' value='details'>
                            </form>
                        </td>
                        <td>
                            <form action='book/book_selection' method='post'>
                                <input type='hidden' name='selection' value='<?= $selection->id ?>' >
                                <input type='submit' value='selection'>
                            </form>
                        </td>
                    </tr>       
                <?php endforeach; ?>
            </table>
            <table>
                <td>
                    <form action="rental/rent" method="post">
                        <input type="submit" name="Valider" value="rent">
                    </form>
                </td>
                <td>
                    <form action="rental/cancel" method="post">
                        <input type="submit" name="Annuler" value="cancel">
                    </form>
                </td>
            </table>
            
        </div>
    </body>
</html>
