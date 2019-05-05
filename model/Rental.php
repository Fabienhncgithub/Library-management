<?php

require_once "framework/Model.php";
require_once "Book.php";

class Rental extends Model {

    public $id;
    public $user;
    public $book;
    public $rentaldate;
    public $returndate;

    function __construct($id, $user, $book, $rentaldate = null, $returndate = null) {
        $this->id = $id;
        $this->user = $user;
        $this->book = $book;
        $this->rentaldate = $rentaldate; //date de location
        $this->returndate = $returndate; //date de retour
    }

//    public function returndate($date){
//        if($returndate > $rentaldate){
//            $returndate = $date;
//        }
//        else
//            $returndate = null;
//    }
//    
//    public function rentaldate($date){
//        if($rentaldate = null){
//            $rentaldate = $date;
//        }
//        else
//            $rentaldate = null;
//    }
//    
//    public function deleterental(){
//        
//    }

    public static function get_rental_by_id($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM rental where id =:id", array("id" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["book"], $data["user"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_rental_by_user($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM rental where user =:user", array("user" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_rental_by_book($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM rental where book =:book", array("book" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_by_id($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book, rental WHERE book.id = rental.book", array("id" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_id_from_book_to_rental($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM rental, book WHERE rental.book = book.id", array("id" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_id_from_book_to_rental2($id) {
        $query = self::execute("SELECT * FROM rental, book WHERE rental.book = book.id", array("id" => $id));
        $data = $query->fetchAll(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
        }
    }

    public function Select() {
        if (empty($this->rentaldate))
            $this->rentaldate = null;
        if (empty($this->returndate))
            $this->returndate = null;
        self::execute("INSERT INTO rental (user,book,rentaldate,returndate) VALUES(:user,:book,:rentaldate,:returndate)", array("user" => $this->user, "book" => $this->book, "rentaldate" => $this->rentaldate, "returndate" => $this->returndate));
        return $this;
    }

    public function Deselect($id) {
            $query = self::execute("DELETE FROM rental where id=:id", array('id' => $this->id));
    }

    public function rent() {
        $book = "";
        $user = "";
        $rentaldate = NULL;
        $returndate = $rentaldate + 7;
        self::execute("INSERT INTO rental (user,book,rentaldate,returndate) VALUES(:id,:user,:book,:rentaldate,:returndate)", array("user" => $this->user, "book" => $this->book));
    }

    public  function clear($id) {
        self::execute("DELETE FROM rental where id=:id", array('id' => $id));
    }

//    
//      public static function get_book_by_id($id) {
//        $result = [];
//        try {
//            $query = self::execute("SELECT * FROM book, rental WHERE book.id = rental.id AND rental.user = 1", array("id" => $id));
//            $datas = $query = fetchAll();
//            foreach ($datas as $$data) {
//                $result[] = new Book($data["id"], $data["isbn"], $title, $author, $editor, $picture);
//            }return $result;
//        } catch (Exception $ex) {
//            $ex->getMessage();
//        }
//    }
}
