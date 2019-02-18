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
            <form action="book/search_rental" method="post">
                <table>
                    <thead>
                        <tr>
                            <td>Filters: </td>
                            <td>Member: <input id="member" name="member" type="text" ></td>
                            <td>Book: <input id="book" name="book" type="text"></td>
                            <td>Rental date: <input id="rental_date" name="rental_date" type="date"></td>
                            <td>State:
                                <th><input id="state_open" name="state_open" type="radio"></th>
                                <th><input id="state_returned" name="state_returned" type="radio"></th>
                                <th><input id="state_all" name="state_all" type="radio"></th>
                            </td>
                            <th><input type="submit" name="search"></th>
                        </tr>
                </table>
            </form>
            
            <form action="book/confirm" method="post">
             <input type="hidden" name="book" value="<?php $books->id ?>">
            
                <input type="radio"  name="confirm" value="1">
                <label>Confirm</label>
                <input type="radio"  name="confirm" value="0">
                <label>Cancel</label>
                <br>
                <input type='submit' value="Send">
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
        </div>
    </body>
</html>
