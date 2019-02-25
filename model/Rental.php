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
        $this->rentaldate = $rentaldate;//date de location
        $this->returndate = $returndate;//date de retour
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
    
    public static function get_rental_by_user($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM rental where user =:user", array("user" => $user->id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public static function get_title_by_id($id){
        $result = [];
        try{
            $query = self::execute("SELECT title FROM book, rental WHERE book.id = rental.id AND rental.user = 1", array("id" => $id));
            $datas = $query = fetchAll();
            foreach ($datas as $$data) {
                $result[] = new Book($data["id"], $data["isbn"], $title, $author, $editor, $picture);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

        public function rent(){
        $book = "";
        $user = "";
        $rentaldate = NULL;
        $returndate = $rentaldate + 7;
        
        self::execute("INSERT INTO Members(pseudo,password,profile,picture_path) VALUES(:book,:user,:rentaldate,:returndate)", 
                          array("pseudo"=>$this->pseudo, "password"=>$this->hashed_password, "picture_path"=>$this->picture_path, "profile"=>$this->profile));
    }

}