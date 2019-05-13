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
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members));
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
        if ($rental == false) {
            $this->redirect("book", "index");
        } else
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
        $rental = Rental::get_rental_by_user_objet($user);
        if ($rental = 'false') {
            $this->redirect("book", "index");
        } else
            $rental->rent();
        $books = Book::get_book_by_all();
        $selections = Rental::get_book_by_user($user);
        $user = $this->get_user_or_redirect();
        $this->redirect("book", "index");
    }

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
    public function user_choice() {
        $user = Controller::get_user_or_redirect();
        $users = $user->id;
        $members = User::get_member_by_pseudo($_POST['rental_select']);
        $member = $members->id;
        var_dump($member);  
        $books = Book::get_book_not_rental_by_member($member);
        var_dump($books);
        $selections = Rental::get_book_by_user($member);
        $members = User::selection_member_by_all_not_selected($users);
        var_dump($member);

        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members));
    }

    public function return_book() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        $returns = Rental::get_rental_by_user($users);


        (new View("return_book"))->show(array("user" => $user, "returns" => $returns));
    }

    public function filter_return() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        $user = User::get_member_by_id($users);
        $returns = Rental::get_rental_by_user($users);


        if (isset($_POST["book"])) {
            //  $returns = Book::get_book_by_filter($_POST["book"]); 
            $book = Rental::get_rental_by_filter($_POST["book"]);
            $book = $book->id;

            var_dump($book);
        }

//         if (isset($_POST["member"])){
//             $member = User::get_member_by_id(($_POST["member"]));
//         }


        $returns = new Rental('', $users, $book, $rentaldate, '');
        var_dump($returns);

        (new View("return_book"))->show(array("user" => $user, "returns" => $returns));
    }

}
