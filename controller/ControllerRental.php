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

    public function removeSelection() {
        $user = Controller::get_user_or_redirect();
        $books = Book::get_book_by_all();
        $selections = [];
        if (isset($_POST["selection"])) {
            $selections = array_shift(Book::get_book_by_id($_POST["selection"]));
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
    }

    public function selection() {
        $user = $this->get_user_or_redirect();

        if (isset($_POST['selection'])) {
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $user = $user->id;
            $rentaldate = '';
            $returndate = '';
            $books = Book::get_book_by_all_not_selected($_POST["selection"]);
            $book = $_POST["selection"];
            $rental = new Rental('', $user, $book, $rentaldate, $returndate);
            $rental->Select();
            $rentalbooks = Rental::get_rental_by_user($user);
            $id = $rental->book;
            $selections = Rental::get_book_by_id($id);
            $user = $this->get_user_or_redirect();
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
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
    }

    public function clear_basket() {
        $user = $this->get_user_or_redirect();
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $user = $user->id;
            var_dump($user);
            $rental = Rental::get_user_by_id_rental_objet($user);
            
            var_dump($rental);

          //$rental->clear();

            $books = Book::get_book_by_all();
            $selections = Rental::get_rental_by_user($user);
            $user = $this->get_user_or_redirect();

            (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
        
    }

    public function confirm_basket() {
        $user = $this->get_user_or_redirect();
        $rental = new Rental();


        if (isset($_POST['confirm'])) {

            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $user = $user->id;




            $books = Book::get_book_by_all();
            $selections = Rental::get_book_by_id($id);
        }


        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
    }

}
