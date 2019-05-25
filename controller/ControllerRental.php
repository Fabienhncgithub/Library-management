<?php

require_once 'model/rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'framework/Utils.php';

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
        $filter = [];
        
        if (isset($_GET['param1'])){
            $filter= Utils::url_safe_decode($_GET['param1']);
            if(!$filter){
                Tools::abort("Bad url");
            }
        }
        if (isset($_POST['selection']) && (isset($_POST['selections']))) {
            $filter['selection'] = $_POST['selection'];
            $filter['selections'] = $_POST['selections'];
            $this->redirect("rental/selection", Utils::url_safe_encode($filter));
        }
        $smember = User::get_member_by_id($filter['selections']);
        $idsmember = ($filter['selections']);
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $user = $user->id;
        $members = User::selection_member_by_all_not_selected($idsmember);
        $rentaldate = '';
        $returndate = '';
        $books = Book::get_book_not_rental_by_member($idsmember);
        $book = $filter["selection"];
        $rental = new Rental('', $idsmember, $book, $rentaldate, $returndate);
        $rental->Select();

        var_dump($user);
        var_dump($idsmember);


//            if ($user !== $idsmember) {
//                $rental = new Rental('', $idsmember, $book, $rentaldate, $returndate);
//                var_dump($rental);
//                $rental->Select();
//                $this->redirect("rental", "user_choice", $idsmember);
//                
//                
//            } else {
//                $rental = new Rental('', $user, $book, $rentaldate, $returndate);
//                var_dump($rental);
//                $rental->Select();
//                $this->redirect("rental", "user_choice", $user);
//            }





        $books = Book::get_book_not_rental_by_member($idsmember);
        $rentalbooks = Rental::get_rental_by_user($idsmember);
        $id = $rental->book;
        $selections = Rental::get_book_by_user($idsmember);
        $user = $this->get_user_or_redirect();
        $members = User::selection_member_by_all_not_selected($idsmember);

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
        if (isset($_POST['memberclearbasket'])) {
            $smember = User::get_member_by_pseudo($_POST['memberclearbasket']);
            $idsmember = $smember->id;
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $user = $user->id;
            $rental = Rental::get_rental_by_user_objet($idsmember);
            if ($rental == 'false') {
                $this->redirect("book", "index");
            } else
                $rental->clear();
            $books = Book::get_book_by_all();
            $members = User::selection_member_by_all_not_selected($idsmember);
            $selections = Rental::get_book_by_user($idsmember);
            $user = $this->get_user_or_redirect();
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember));
    }

    public function confirm_basket() {
        $user = $this->get_user_or_redirect();
        if (isset($_POST['memberconfirmbasket'])) {
            $smember = User::get_member_by_pseudo($_POST['memberconfirmbasket']);
            $idsmember = $smember->id;
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            $user = $user->id;
            $rental = Rental::get_rental_by_user_objet($idsmember);
            if ($rental == 'false') {
                $this->redirect("book", "index");
            } else
                $rental->rent();
            $books = Book::get_book_by_all();
            $members = User::selection_member_by_all_not_selected($idsmember);
            $selections = Rental::get_book_by_user($idsmember);
            $user = $this->get_user_or_redirect();
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember));
    }

//    public function confirm_basket_for_user() {
//        $user = $this->get_user_or_redirect();
//        $username = $user->username;
//        $user = User::get_member_by_pseudo($username);
//        $user = $user->id;
//        $rental = Rental::get_user_by_id_rental_objet($user);
//        $rental->rent();
//        $books = Book::get_book_by_all();
//        $selections = Rental::get_book_by_user($user);
//        $user = $this->get_user_or_redirect();
//    }

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
        $returns = Rental::get_rental_all();
        (new View("return_book"))->show(array("user" => $user, "returns" => $returns));
    }

    public function filter_return() {
        //empty - renvoyer tout
        //
        // 3requêtes qui reprennent le all return open
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        $user = User::get_member_by_id($users);
        $returns = Rental::get_all_rental();

        $book = "";
        $member = "";
        $rentaldate = null;
        $selection = "all";


        if (isset($_POST['book'])) {
            $book = ($_POST['book']);
        }

        if (isset($_POST['member'])) {
            $member = ($_POST['member']);
        }

        if (isset($_POST['rentaldate'])) {
            $rentaldate = ($_POST['rentaldate']);
        }

        if (isset($_POST['MyRadio'])) {
            $selection = ($_POST['MyRadio']);
            var_dump($selection);

            if ($selection == 1) {
                $selection = "all";
            } else if ($selection == 2) {
                $selection = "open";
            } else if ($selection == 3) {
                $selection = "return";
            }
        }


        if ($selection == 'all') {
            $returns = Rental::get_rental_by_filter_all($book, $member, $rentaldate);
        } else if ($selection == 'open') {
            $returns = Rental::get_rental_by_filter_open($book, $member, $rentaldate);
        } else if ($selection == 'return') {
            $returns = Rental::get_rental_by_filter_return($book, $member, $rentaldate);
        }
        (new View("return_book"))->show(array("user" => $user, "returns" => $returns));
    }

    public function get_rental() {
        $rentaldate = null;
        $title = "";
        $author = "";
        $MyRadio = 1;
        if (isset($_POST['title'])) {
            $title = $_POST['title'];
        }
        if (isset($_POST['author'])) {
            $author = $_POST['author'];
        }
        if (isset($_POST['rentaldate'])) {
            $rentaldate = $_POST['rentaldate'];
        }
        if (isset($_POST['MyRadio'])) {
            $selection = ($_POST['MyRadio']);
        }
        if ($title == "" && $author == "" && $rentaldate == null) {
            $rents = Rental::get_rental_all();
        }
        if ($rents != null) {
            foreach ($rents as $rent) {
                if ($rent->returndate == null) {
                    if (date('Y-m-d', strtotime('1 month', strtotime($rent->rentaldate))) >= date('Y-m-d')) {
                        $rent->eventColor = 'green';
                    } else {
                        $rent->eventColor = 'red';
                    }
                } else {
                    if (date('Y-m-d', strtotime('1 month', strtotime($rent->rentaldate))) >= $rent->returndate) {
                        $rent->eventColor = 'blue';
                    } else {
                        $rent->eventColor = 'yellow';
                    }
                }
                if ($rent->returndate == null) {
                    $rent->end = "/";
                } else {
                    $rent->end = $rent->returndate;
                }
            }
        }
        echo json_encode($rents);
    }

    public function return_rental() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        if (isset($_POST["return"])) {
            $returns = ($_POST["return"]);
            $returns = Rental::get_rental_by_id_objet($returns);
            $idreturns = $returns->id;
            $book = Book::get_book_by_id_rental($idreturns);
        }
        (new View("return_date"))->show(array("user" => $user, "returns" => $returns, "book" => $book));
    }

    public function insert_return_date() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        if (isset($_POST["return_date"])) {
            $rental = Rental::get_rental_by_id_objet($_POST["return"]);
            $id = $rental->id;
            $user = $rental->user;
            $book = $rental->book;
            $rentaldate = $rental->rentaldate;
            $returndate = ($_POST["return_date"]);
            Rental::returndate($id, $user, $book, $rentaldate, $returndate);
            $this->redirect("rental", "return_book");
        }
    }

    public function get_events() {
        $events = Rental::get_rental_all();
        foreach ($events as $event) {
            $event->start = $event->rentaldate;
            $event->resourceId = $event->id;
            if ($event->returndate == null) {
                if (date('Y-m-d h:i:s', strtotime('1 month', strtotime($event->rentaldate))) >= date('Y-m-d h:i:s')) {
                    $event->end = date('Y-m-d h:i:s', strtotime('1 month', strtotime($event->rentaldate)));
                } else {
                    $event->end = date('Y-m-d h:i:s');
                }
            } else {
                $event->end = $event->returndate;
            }
        }
        echo json_encode($events);
    }

    public function delete_rental_return() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        if (isset($_POST["deleterental"])) {
            $return = ($_POST["deleterental"]);
            $return = Rental::get_rental_by_id_objet($return);
        }
        (new View("confirm_delete_return"))->show(array("user" => $user, "return" => $return));
    }

    public function del_Rental() {
        if (isset($_POST['delete'])) {
            $rent = Rental::get_rental_by_id($_POST['delete']);
            $rent[0]->delete_rental();
        }
    }

    public function confirm_delete() {
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
            if (isset($_POST['idrental']) && isset($_POST['confirm'])) {
                $confirm = $_POST['confirm'];
                $return = ($_POST["idrental"]);
                $return = Rental::get_rental_by_id_objet($return);
                if ($confirm != 0) {
                    $return->delete_rental();
                }
                $this->redirect("rental", "return_book");
            }
            $this->redirect("rental", "return_book");
        }
    }

    public function return_date() {
        if (isset($_POST['retour'])) {
            $rent = Rental::get_rental_by_id($_POST['retour']);
            $rent[0]->returndate(date('Y-m-d h:i:s'));
        }
    }

}
