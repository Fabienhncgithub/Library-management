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

        if (isset($_POST['selection']) && (isset($_POST['selections']))) {
            $smember = User::get_member_by_pseudo($_POST['selections']);
            $idsmember = $smember->id;
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $user = $user->id;
            $members = User::selection_member_by_all_not_selected($idsmember);
            $rentaldate = '';
            $returndate = '';
            $books = Book::get_book_not_rental_by_member($idsmember);
            $book = $_POST["selection"];

            $rental = new Rental('', $idsmember, $book, $rentaldate, $returndate);
            $rental->Select();
            $rentalbooks = Rental::get_rental_by_user($idsmember);
            $id = $rental->book;
            $selections = Rental::get_book_by_user($idsmember);
            $user = $this->get_user_or_redirect();
            $members = User::selection_member_by_all_not_selected($idsmember);
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember));
    }

    public function deselection() {
        $user = $this->get_user_or_redirect();
        if (isset($_POST['deselection']) && ($_POST['sdeselection'])) {
            $smember = User::get_member_by_pseudo($_POST['sdeselection']);
            $idsmember = $smember->id;
            $book = Book::get_member_by_object_title($_POST['deselection']);
            $book = $book->id;
            $rental = Rental::get_rental_by_user_book($idsmember, $book);
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $members = User::selection_member_by_all_not_selected($idsmember);
            $rental->Deselect();
            $books = Book::get_book_not_rental_by_member($idsmember);
            $selections = Rental::get_book_by_user($idsmember);
            $user = $this->get_user_or_redirect();
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember));
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

    public function user_choice() {
        $user = Controller::get_user_or_redirect();
        if (isset($_POST['rental_select'])) {
            $this->redirect("rental", "user_choice", $_POST["rental_select"]);
        }
        if (isset($_GET['param1'])) {
            $username = $_GET['param1'];
            $smember = User::get_member_by_pseudo($username);
            $idmember = $smember->id;
            $books = Book::get_book_not_rental_by_member($idmember);
            $selections = Rental::get_book_by_user($idmember);
            $members = User::selection_member_by_all_not_selected($idmember);
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember));
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
            $returns = Rental::get_rental_by_filter($_POST["book"]);
        }

//         if (isset($_POST["member"])){
//             $member = User::get_member_by_id(($_POST["member"]));
//         }
        //      $returns = new Rental('', $users, $book, $rentaldate, '');
        //      var_dump($returns);

        (new View("return_book"))->show(array("user" => $user, "returns" => $returns));
    }

//        public function search() {
//        $books = Book::get_book_by_all();
//        $user = Controller::get_user_or_redirect();
//        $selections = [];
//        if (isset($_POST["critere"])) {
//            $books = Book::get_book_by_filter($_POST["critere"]);
//        }
//        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
//    }


    public function return_rental() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        if (isset($_POST["return"])) {
            $returns = ($_POST["return"]);
            $returns = Rental::get_rental_by_id_objet($returns);
            $idreturns = $returns->id;
            var_dump($idreturns);
            $book = Book::get_book_by_id_rental($idreturns);
        }
        (new View("return_date"))->show(array("user" => $user, "returns" => $returns, "book" => $book));
    }

    public  function insert_return_date() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;


        if (isset($_POST["return_date"])) {
            
            
            $rental = Rental::get_rental_by_id_objet($_POST["return"]);
            var_dump($rental);
            $id = $rental->id;
            $user = $rental->user;
            var_dump($user);
            $book = $rental->book;
            var_dump($book);
            $rentaldate = $rental->rentaldate;
            $returndate = ($_POST["return_date"]);
            Rental::returndate($id,$user,$book,$rentaldate,$returndate);
            
           $this->redirect("book", "index");
        }
    }

}
