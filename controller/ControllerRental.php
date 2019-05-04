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

    public function selection() {
        $user = $this->get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $user = $user->id;
        $rentaldate = '';
        $returndate = '';
        

        if (isset($_POST['selection'])) {

            $books = Book::get_book_by_all_not_selected($_POST["selection"]);
            $book = $_POST["selection"];
            $rental = new Rental('', $user, $book, $rentaldate, $returndate);
            $rental->Rental();
            
            
            
            //$selections = Book::get_book_by_id($_POST["selection"]);
            // $rental->insert_Rental();
        }
//        $user = Controller::get_user_or_redirect();
//        $books = Book::get_book_by_all();
//        $selections = [];
//        $rental = [];
//        
//       // si post selection
//       //     new rental et add
//       // recuperer rentals null  null
//       // afficher
//       
//        if (isset($_POST['selection']) && isset($_POST['book'])){
//        $selection = $_POST['selection'];
//        $book = $_POST['book']; 
//        
//        $newrental = new Rental('',$user, $book);
//        
//        $newrental->insert_Rental();
        //$rental = Rental::rental($_POST["selection"]);
        //$selections = Book::get_book_by_id($_POST["selection"]);
        //$books = Book::get_book_by_all_not_selected($_POST["selection"]);
//        foreach($selections as $selection)
//            $selection;
//        var_dump($selections);
//        foreach ($selections as $selection){
//            $selections = $selection;
//            var_dump($selection);
//        }
//            var_dump($selections);
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
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

}
