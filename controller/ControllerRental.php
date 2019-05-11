<?php

require_once 'model/rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerRental extends Controller {

    public function index() {
        $user = Controller::get_user_or_redirect();
        $rentals = Rental::get_rental_by_user($user);
        (new View("profile"))->show(array("rentals" => $rentals, "user" => $user));
    }

    public function rent() {
        $user = Controller::get_user_or_redirect();
        $rentals = Rental::get_rental_by_user($user);
        (new View("profile"))->show(array("rentals" => $rentals, "user" => $user));
    }

//    public function removeSelection() {
//        $user = Controller::get_user_or_redirect();
//        $books = Book::get_book_by_all();
//        $selections = [];
//        if (isset($_POST["selection"])) {
//            $selections = array_shift(Book::get_book_by_id($_POST["selection"]));
//        }
//        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
//    }

    public function selection() {
        $user = $this->get_user_or_redirect();

        if (isset($_POST['selection'])) {
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $user = $user->id;
            $rentaldate = '';
            $returndate = '';
            $books = Book::get_book_by_all();
            $book = $_POST["selection"];
            $rental = new Rental('', $user, $book, $rentaldate, $returndate);
            $rental->Select();
            $rentalbooks = Rental::get_rental_by_user($user);
            $id = $rental->book;
            $selections = Rental::get_book_by_id($id);
            $user = $this->get_user_or_redirect();
            $this->redirect("book", "index");
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
    }

    public function deselection() {
        $user = $this->get_user_or_redirect();
        if (isset($_POST['deselection'])) {
            $id = $_POST['deselection'];
            $idrental = Rental::get_rental_by_id_objet($id);
            $idrental->Deselect();
            $books = Book::get_book_by_all();
            $selections = Rental::get_book_by_id($id);
            $this->redirect("book", "index");
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
    }

    public function clear_basket() {
        $user = $this->get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $user = $user->id;
        $rental = Rental::get_user_by_id_rental_objet($user);
        if ($rental == false){
                 $this->redirect("book", "index");
        }
        else
        $rental->clear();
        $books = Book::get_book_by_all();
        $selections = Rental::get_book_by_user($user);
        $user = $this->get_user_or_redirect();
        $this->redirect("book", "index");
    }

    public function confirm_basket() {
        $user = $this->get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $user = $user->id;
        $rental = Rental::get_user_by_id_rental_objet($user);
        $rental->rent();
        $books = Book::get_book_by_all();
        $selections = Rental::get_book_by_user($user);
         $user = $this->get_user_or_redirect();
      $this->redirect("book", "index");    }

        public function confirm_basket_for_user() {
        $user = $this->get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $user = $user->id;
        $rental = Rental::get_user_by_id_rental_objet($user);
        $rental->rent();
        $books = Book::get_book_by_all();
        $selections = Rental::get_book_by_user($user);
         $user = $this->get_user_or_redirect();
    }
    
    
//        public function selection_member() {
//        $user = $this->get_user_or_redirect();
//        if (isset($_POST['rental_select'])) {
//            
//            
//            var_dump($_POST['rental_select']);
//            
//            
//            
//            $username = $user->username;
//            $user = User::get_member_by_pseudo($username);
//            $user = $user->id;
//            $rentaldate = '';
//            $returndate = '';
//               $books = Book::get_book_by_all();
//            $book = $_POST["selection"];
//            $rental = new Rental('', $user, $book, $rentaldate, $returndate);
//            $rental->Select();
//            $rentalbooks = Rental::get_rental_by_user($user);
//            $id = $rental->book;
//            $selections = Rental::get_book_by_id($id);
//            $user = $this->get_user_or_redirect();
//            $this->redirect("book", "index");
//        }
//        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
//    }
    
        public function user_choice(){
           $user = $this->get_user_or_redirect();
           
           $member= User::get_member_by_pseudo($_POST['rental_select']);
           var_dump($member);
           
        $books = Book::get_book_not_rental_by_user($user);
       $selections = Rental::get_book_by_id($user);
                 
        
            
        (new View("reservation_member"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "member" => $member));
        }
    

    
}
