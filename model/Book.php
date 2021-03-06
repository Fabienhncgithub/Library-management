<?php

//

require_once "framework/Model.php";
require_once "User.php";

//require_once "book.php";

class Book extends Model {

    public $id;
    public $isbn;
    public $title;
    public $author;
    public $editor;
    public $picture;

    public function __construct($id = 0, $isbn = 0, $title = 0, $author = 0, $editor = 0, $picture = 0) {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->title = $title;
        $this->author = $author;
        $this->editor = $editor;
        $this->picture = $picture;
    }

    public static function get_book_by_title($title) {
        $query = self::execute("SELECT * FROM book where title = :title", array("title" => $title));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
        }
    }

    public static function get_book_isbn($isbn) {
        $query = self::execute("SELECT * FROM book where isbn = :isbn", array("isbn" => $isbn));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
        }
    }

    public static function get_book_id($id) {
        $query = self::execute("SELECT * FROM book where id = :id", array("id" => $id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
        }
    }

    public static function get_book_by_all() {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book", array());
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_by_all_not_rental() {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where book.id !=: rental.book", array());
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_by_filter($search, $user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where(isbn LIKE :search OR title LIKE :search OR author LIKE :search OR editor LIKE :search) AND book.id NOT IN (select rental.book from rental where rental.user=:user)", array("search" => "%" . $search . "%", "user" => $user));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_by_details($title) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where title = :title", array("title" => $title));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_by_id($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where id =:id", array("id" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_member_by_object_id($id) {
        $query = self::execute("SELECT * FROM book where id = :id", array("id" => $id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
        }
    }

    public static function get_member_by_object_title($title) {
        $query = self::execute("SELECT * FROM book where title = :title", array("title" => $title));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
        }
    }

    public static function get_book_by_only_id($id) {
        $query = self::execute("SELECT * FROM book where id = :id", array("id" => $id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"]);
        }
    }

    public static function get_book_by_all_not_selected($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where id !=:id", array("id" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_by_ISBN($isbn) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where isbn = :isbn", array("isbn" => $isbn));
            $datas = $query->fetch();
            return $datas;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public function delete_Book() {
        try {
            self::execute("DELETE FROM rental where rental.book=:id", array('id' => $this->id));
            self::execute("DELETE FROM book where id=:id", array('id' => $this->id));


            return true;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            echo $exc->getMessage();
        }
    }

    //renvoie un tableau d'erreur(s) 
    //le tableau est vide s'il n'y a pas d'erreur.

    public static function validate_photo($file) {
        $errors = [];
        if (isset($file['name']) && $file['name'] != '') {
            if ($file['error'] == 0) {
                $valid_types = array("picture/gif", "picture/jpeg", "picture/png");
                if (!in_array($_FILES['picture']['type'], $valid_types)) {
                    $errors[] = "Unsupported image format : gif, jpg/jpeg or png.";
                }
            } else {
                $errors[] = "Error while uploading file.";
            }
        }
        return $errors;
    }

    public function updateBook() {
        if (empty($this->picture))
            $this->picture = null;
        if (self::get_book_by_id($this->id))
            self::execute("UPDATE book SET isbn=:isbn, title=:title, author=:author , editor=:editor, picture=:picture WHERE id=:id ", array("id" => $this->id, "isbn" => $this->isbn, "title" => $this->title, "author" => $this->author, "editor" => $this->editor, "picture" => $this->picture));
        else
            self::execute("INSERT INTO book (isbn,title,author,editor,picture) VALUES(:isbn,:title,:author,:editor,:picture)", array("isbn" => $this->isbn, "title" => $this->title, "author" => $this->author, "editor" => $this->editor, "picture" => $this->picture));
        return $this;
    }

    //pre : validate_photo($file) returns true
    public function generate_photo_name($file) {
        //note : time() est utilisé pour que la nouvelle image n'aie pas
        //       le meme nom afin d'éviter que le navigateur affiche
        //       une ancienne image présente dans le cache
        if ($_FILES['picture']['type'] == "picture/gif") {
            $saveTo = $this->title . time() . ".gif";
        } else if ($_FILES['picture']['type'] == "picture/jpeg") {
            $saveTo = $this->title . time() . ".jpg";
        } else if ($_FILES['picture']['type'] == "picture/png") {
            $saveTo = $this->title . time() . ".png";
        }
        return $saveTo;
    }

    public static function validate_unicity_isbn($isbn) {
        $errors = "";
        $user = self::get_book_by_ISBN($isbn);

        if ($user) {
            $errors = "This ISBN already exists.";
        }
        return $errors;
    }

    public static function validate_unicity_edit_isbn($isbn) {
        $user = self::get_book_by_ISBN($isbn);
        if ($user) {
            return false;
        }
        return true;
    }

    public static function validate_unicity_addbook($isbn, $title, $author, $editor) {
        $errors = [];
        if (strlen($isbn) !== 13)
            $errors[] = "Mettre isbn de 12 chiffres";
        if (($title) == "")
            $errors[] = "Mettre titre";
        if (($editor) == "")
            $errors[] = "Mettre editeur";
        if (($author) == "")
            $errors[] = "Mettre auteur";
        if (!self::validate_unicity_edit_isbn($isbn)) {
            $errors[] = "ISBN existe déjà pour un autre livre";
        }

        return $errors;
    }

    public static function unicity_edit_book($books, $isbn, $title, $editor, $author) {
        $errors = [];
        if (strlen($isbn) !== 13)
            $errors[] = "Mettre isbn de 12 chiffres";
        if (($title) == "")
            $errors[] = "Mettre titre";
        if (($editor) == "")
            $errors[] = "Mettre editeur";
        if (($author) == "")
            $errors[] = "Mettre auteur";

        if ($books->isbn != $isbn) {
            if (!Book::validate_unicity_edit_isbn($isbn)) {
                $errors[] = "ISBN existe déjà pour un autre livre";
            }
        }
        return $errors;
    }

    public static function validate_title($title) {
        $errors = [];
        if ($title == "") {
            $errors[] = "Title is required.";
        }
        return $errors;
    }

    public static function validate_author($author) {
        $errors = [];
        if ($author == "") {
            $errors[] = "Author is required.";
        }
        return $errors;
    }

    public static function get_book_not_rental_by_user($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book  where book.id not in (select rental.book from rental join user on rental.user=user.id where rental.user=user.id)", array("user" => $user));

            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_not_rental_by_member($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book  where book.id not in (select rental.book from rental join user on rental.user=user.id where rental.user=:user)", array("user" => $user));

            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_not_rental() {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where book.id not in (select rental.book from rental where rental.returndate is NULL)", array());

            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }


    public static function get_book_by_user_book($user, $book) {
        $query = self::execute("SELECT * FROM book join rental on book.id=rental.book join user on rental.user=user.id  WHERE rental.user =:user and rental.book =:book", array("user" => $user, "book" => $book));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
        }
    }

    public static function get_book_by_id_rental($id) {
        $query = self::execute("SELECT * FROM book join rental on book.id=rental.book WHERE rental.id =:id", array("id" => $id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
        }
    }

    public static function get_username_by_id($id) {
        $query = self::execute("SELECT title FROM book where id=:id", array("id" => $id));
        $data = $query->fetch();
        return $data[0];
    }
    
    
     public static function get_book_by_user_not_rented($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where book.id NOT IN (select rental.book from rental where rental.user=:user)", array("user" => $user));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

}
