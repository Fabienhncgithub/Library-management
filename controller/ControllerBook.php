<?php

require_once 'model/book.php';
require_once 'model/rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerBook extends Controller {

    //si l'utilisateur est conecté, redirige vers son profil.
    //sinon, produit la vue d'accueil.
    public function index() {
        $user = Controller::get_user_or_redirect();
        $books = Book::get_book_by_all();
        $rentals = Rental::get_rental_by_user($user);
        var_dump($rentals);
        (new View("reservation"))->show(array("books" => $books, "rentals" => $rentals, "user" => $user));
    }

    public function search() {
        $books = Book::get_book_by_all();
        $user = Controller::get_user_or_redirect();
        if (isset($_POST["critere"])) {
            $books = Book::get_book_by_filter($_POST["critere"]);
        }
        (new View("reservation"))->show(array("books" => $books, "user" => $user));
    }

    public function selection() {
        $user = Controller::get_user_or_redirect();
        $books = Book::get_book_by_all();
        
        
        //var_dump($books);

        (new View("reservation"))->show(array("books" => $books, "user" => $user));
    }

    public function details() {
        $books = "";
        $user = Controller::get_user_or_redirect();
        if (isset($_POST["details"])) {
//            echo $_POST["details"];
            $books = Book::get_book_by_id($_POST["details"]);
           // var_dump($books);
        }
        (new View("details"))->show(array("books" => $books, "user" => $user));
    }
    
    public function isSelected(){
        return true;
    }
}
