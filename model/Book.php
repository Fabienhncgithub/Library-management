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

    public function __construct($id=0, $isbn=0, $title=0, $author=0, $editor=0, $picture=0) {
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

    public static function get_book_by_filter($search) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book where title LIKE :search OR author LIKE :search OR editor LIKE :search", array(":search" => "%" . $search . "%"));
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

//    public static function get_book_by_selection() {
//        $result = [];
//        try {
//            $query = self::execute("SELECT * FROM book where title = :title", array("title" => $title));
//            $datas = $query->fetch();
//            foreach ($datas as $data) {
//                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
//            }return $result;
//        } catch (Exception $ex) {
//            $ex->getMessage();
//        }
//    }
    //       public static function get_book_id_title($) {
//        $result = [];
//        try {
//            $query = self::execute("SELECT * FROM book where id =:id", array("id" => $id));
//            $datas = $query->fetch();
//            foreach ($datas as $data) {
//                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
//            }return $result;
//        } catch (Exception $ex) {
//            $ex->getMessage();
//        }
//    }
//    

    
    
    
    
        public function delete_Book() {
        try {

            $query = self::execute("DELETE FROM book where id=:id", array("id" => $this->id));
            return true;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            echo $exc->getMessage();
        }
    }
    
    
    
        public function deleteBoook() {
        self::execute("delete from book where book=:book", array('book' => $this->id));
     
    }
    
        //renvoie un tableau d'erreur(s) 
    //le tableau est vide s'il n'y a pas d'erreur.
    public static function validate_photo($file) {
        $errors = [];
        if (isset($file['name']) && $file['name'] != '') {
            if ($file['error'] == 0) {
                $valid_types = array("image/gif", "image/jpeg", "image/png");
                if (!in_array($_FILES['image']['type'], $valid_types)) {
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
        if(self::get_book_by_id($this->id))
                      
            self::execute("UPDATE book SET isbn=:isbn, title=:title, author=:author , editor=:editor, picture=:picture WHERE title=:title ", 
                          array("isbn"=>$this->isbn, "title"=>$this->title, "author"=>$this->author, "editor"=>$this->editor, "picture"=>$this->picture));
        else
            self::execute("INSERT INTO book (isbn,title,author,editor,picture) VALUES(:isbn,:title,:author,:editor,:picture)", 
                          array("isbn"=>$this->isbn, "title"=>$this->title, "author"=>$this->author, "editor"=>$this->editor, "picture"=>$this->picture));
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
    
   
    
    
//        public function createbook() {
//            self::execute("INSERT INTO book (isbn,title, author, editor, picture) VALUES(:isbn,:title,:author,:editor,:picture)", array("isbn" => $this->isbn, "title" => $this->title, "author" => $this->author, "editor" => $this->editor, "picture" => $this->picture));
//        return $this;
//        }
    
}
