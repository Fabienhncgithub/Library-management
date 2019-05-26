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

    public static function get_all_rental() {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM rental", array());
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["book"], $data["user"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    


    public static function get_rental_all() {
        $result = [];
        try {
            $query = self::execute("SELECT rental.id, user.username, book.title,rental.rentaldate,rental. returndate "
                    . "FROM rental join book on rental.book = book.id join user on user.id =rental.user "
                    . "where rental.rentaldate is not null", array());
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["username"], $data["title"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_rental_by_id_objet($id) {
        $query = self::execute("SELECT * FROM rental where id = :id", array("id" => $id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
        }
    }

    public static function get_rental_by_member_book($id) {

        $query = self::execute("SELECT * FROM `rental` where rental.book =:id", array("id" => $id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["id"], $data["book"], $data["user"], $data["rentaldate"], $data["returndate"]);
        }
    }

    public static function get_book_by_user($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book join rental on book.id=rental.book join user on rental.user=user.id  WHERE user.id =:user", array("user" => $user));

            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    
       public static function get_book_by_user_without_rental($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * "
                                    . "FROM book join rental on book.id=rental.book join user on rental.user=user.id  "
                                     ."WHERE user.id =:user and rental.rentaldate is NULL", array("user" => $user));

            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    } 
    

    public static function get_book_by_member_book($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book join rental on book.id=rental.book join user on rental.user=user.id  WHERE user =:user", array("user" => $user));

            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_book_not_rental_by_user($user) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM book join rental on book.id=rental.book join user on rental.user=user.id  WHERE user =:user", array("user" => $user));

            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Book($data["id"], $data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"]);
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

    public static function get_rental_by_user_with_rentaldate($id) {
        $result = [];
        try {
            $query = self::execute("SELECT * FROM rental where user =:user and rentaldate is NOT NULL", array("user" => $id));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_rental_by_profile($id) {
        $result = [];
        try {
            $query = self::execute("SELECT rentaldate,returndate,title FROM `rental` join book on book.id=rental.book where user =:user", array("user" => $id));
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

    public static function get_rental_by_id_user_objet($user) {
        $query = self::execute("SELECT * FROM rental where user = :user ", array("user" => $user));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
        }
    }

    public static function get_rental_by_user_objet($user) {
        $query = self::execute("SELECT * FROM rental where user = :user and rentaldate is null", array("user" => $user));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
        }
    }

    public static function get_rental_user_id_by_username_objet($username) {
        $query = self::execute("SELECT * FROM rental join user on user.id=rental.user where user.username = :username", array("username" => $username));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
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
    
    
    
//        public function Select2($user) {
//        if (empty($this->rentaldate))
//            $this->rentaldate = null;
//        if (empty($this->returndate))
//            $this->returndate = null;
//        self::execute("INSERT INTO rental (rentaldate) VALUES(:rentaldate)", array("user" => $this->user,"rentaldate" => $this->rentaldate));
//        return $this;
//    }
    

    public function Deselect() {
        $query = self::execute("DELETE FROM rental where id=:id", array('id' => $this->id));
    }

    public function clear() {
        self::execute("DELETE FROM rental where user=:user and  rentaldate is null", array('user' => $this->user));
    }


    public function rent() {
        if ($this->rentaldate == null)
            $this->rentaldate = date('Y-m-d H:i:s');
        self::execute("UPDATE rental SET user=:user, book=:book, rentaldate=:rentaldate, returndate=:returndate WHERE user=:user and rentaldate is null", array("id" => $this->id, "user" => $this->user, "book" => $this->book, "rentaldate" => $this->rentaldate, "returndate" => $this->returndate));
    }
    public function rent2() {
        if ($this->rentaldate == null)
            $this->rentaldate = date('Y-m-d H:i:s');
        self::execute("UPDATE rental SET user=:user, rentaldate=:rentaldate WHERE user=:user and rentaldate is null", array("user" => $this->user,"rentaldate" => $this->rentaldate));
    }

    public static function get_rental_by_filter($book) {
        $result = [];
        try {
            $query = self::execute("SELECT rental.id, user.username, book.title,rental.rentaldate,rental. returndate FROM rental join book on rental.book=book.id where isbn LIKE :book OR title LIKE :book OR author LIKE :book OR editor LIKE :book ", array(":book" => "%" . $book . "%"));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    
    
    

    
    

    public static function get_rental_by_filter_all($book, $user, $rentaldate) {
        $result = [];
        try {

            $query = self::execute("SELECT rental.id, user.username,book.title,rental.rentaldate,rental.returndate FROM rental join book on rental.book=book.id join user on rental.user = user.id where ( rentaldate IS NOT NULL  OR returndate IS NOT NULL) and (isbn LIKE :book OR title LIKE :book OR author LIKE :book OR editor LIKE :book) and username like :member or username like :member and rental.rentaldate=:rentaldate", array(":book" => "%" . $book . "%", ":member" => "%" . $user . "%", ':rentaldate' => $rentaldate));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                            $result[] = new Rental($data["id"], $data["username"], $data["title"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }


    
    
    public static function get_rental_by_filter_open($book, $user, $rentaldate) {
        $result = [];
        try {

            $query = self::execute("SELECT * FROM rental join book on rental.book=book.id join user on rental.user = user.id where (isbn LIKE :book OR title LIKE :book OR author LIKE :book OR editor LIKE :book and username like :member or username like :member and rental.rentaldate=:rentaldate and rental.rentaldate is not null", array(":book" => "%" . $book . "%", ":member" => "%" . $user . "%", ':rentaldate' => $rentaldate));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_rental_by_filter_return($book, $user, $rentaldate) {
        $result = [];
        try {

            $query = self::execute("SELECT user.username,book.title,rental.rentaldate,rental.returndate FROM rental join book on rental.book=book.id join user on rental.user = user.id where (isbn LIKE :book OR title LIKE :book OR author LIKE :book OR editor LIKE :book and username like :member or username like :member and rental.rentaldate=:rentaldate and rentaldate is not null and returndate is not null", array(":book" => "%" . $book . "%", ":member" => "%" . $user . "%", ':rentaldate' => $rentaldate));
            $datas = $query->fetchAll();
            foreach ($datas as $data) {
                $result[] = new Rental($data["id"], $data["username"], $data["title"], $data["rentaldate"], $data["returndate"]);
            }return $result;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function get_rental_by_user_book($user, $book) {
        $query = self::execute("SELECT * FROM rental WHERE user =:user and book =:book", array("user" => $user, "book" => $book));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["id"], $data["user"], $data["book"], $data["rentaldate"], $data["returndate"]);
        }
    }

    public function returndate($id, $user, $book, $rentaldate, $returndate) {
        self::execute("UPDATE rental SET id=:id,user=:user, book=:book, rentaldate=:rentaldate, returndate=:returndate WHERE id=:id", array(':id' => $id, ':user' => $user, ':book' => $book, ':rentaldate' => $rentaldate, ':returndate' => $returndate));
    }

    public function delete_rental() {
        try {
            $query = self::execute("DELETE FROM rental where id=:id", array('id' => $this->id));
            return true;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
        
         public function rental_returndate($returndate) {
        self::execute("UPDATE rental SET returndate = :returndate where id=:id  ", array("returndate" => $returndate, "id" => $this->id));
    }
        
        
        
    }
    
    
    
    
    
    

