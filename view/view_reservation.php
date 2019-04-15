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
        <div class="title"><?php echo $user->fullname; ?>!</div>
        <?php include('menu.html'); ?>
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
                                <input type='submit' value='selection'>
                            </form>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
                    
                    
                    
                    
                    
            </table>
            
            
            
            
            Basket of books to rent
            
            <br>
            <table>
                <tr>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Editor</th>
                    <th>action</th>

                </tr>
                
<!--            selection est un ensemble de pré-réservation
                en appuyant sur selection on ajoute au panier de l'utilisateur courant/séléctionné
                une pré-réservation pour un livre dont la date de début est null-->

                <?php foreach($selections as $selection): ?>
                
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
                                <input type='hidden' name='details' value='<?= $book->id ?>'>
                                <input type='submit' value='details'>
                            </form>
                          <?php endif; ?>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            </table>
            
 
        </div>
    </body>
</html>