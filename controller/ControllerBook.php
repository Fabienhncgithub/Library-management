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
        $selections = [];
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user));
    }

    public function search() {
        $books = Book::get_book_by_all();
        $user = Controller::get_user_or_redirect();
        if (isset($_POST["member"])) {
            $books = Book::get_book_by_filter($_POST["critere"]);
        }
        (new View("reservation"))->show(array("books" => $books, "user" => $user));
    }
    
    public function search_rental() {
        $books = Book::get_book_by_all();
        $user = Controller::get_user_or_redirect();
        if (isset($_POST["member"]) && isset($_POST["book"]) && isset($_POST["rental_date"]) && isset($_POST["state"])) {
            $books = Book::get_book_by_filter($_POST["critere"]);
        }
        (new View("return_book"))->show(array("books" => $books, "user" => $user));
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
    
//    public function isSelected(){
//        return true;
//    }
    
    public function edit() {
        $user = $this->get_user_or_redirect();
//        if ($user->isAdmin()) {
        if (isset($_POST['edit'])) {
            $books = Book::get_book_by_id($_POST["edit"]);
            var_dump($books);
//            }

            (new View("editbook"))->show(array("user" => $user, "books" => $books));
        }
    }

    public function delete() {
        echo '0';
        $books = new Book();
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
            echo '1';
            if (isset($_POST['id_book'])) {
                echo '2';
                $errors = user::validate_admin($user->username);
                if (empty($errors)) {
                    echo '3';
                    $books->id = $_POST['id_book'];
                    //$books = $_POST['id_book'];
                    //recevoir un titre et envoyer id
                    var_dump($books);
                }
            }
        }
        (new View("confirm"))->show(array("user" => $user, "books" => $books));
    }

    public function confirm() {
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
            if (isset($_POST['book']) && isset($_POST['confirm'])) {
                $books = $_POST['book'];
                var_dump($books);
                $confirm = $_POST['confirm'];
                if ($confirm != 0) {
                    $books = Book::get_book_by_id($_POST["book"]);
                    var_dump($books);
                    $books->deleteBook();
                }
            }
        }
        $this->redirect("user", "book");
    }

//    
//        public function confirm() {
//        $books = "";
//
//        $user = Controller::get_user_or_redirect();
//        if (isset($_POST["confirm"])) {
//            echo $_POST["confirm"];
//            $books = Book::get_book_by_id($_POST["confirm"]);
//            $confirm = $_POST['confirm'];
//            var_dump($books);
//            if ($confirm != 0) {
//                
//                echo 'test';
//            }
//        }
//        (new View("confirm"))->show(array("books" => $books, "user" => $user));
//    }

    public function deleteBook() {
        self::execute("delete from book where id=:id", array('book' => $this->id));
    }

    public function editbook() {
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
            if (isset($_POST['isbn']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['editor']) && isset($_POST['picture'])) {
                $isbn = $_POST['isbn'];
                $title = $_POST['title'];
                $author = $_POST['author'];
                $editor = $_POST['editor'];
                $picture = $_POST['picture'];
                $errors = user::validate_photo($_FILES['image']);
                if (empty($errors)) {
                    $saveTo = $book->generate_photo_name($_FILES['image']);
                    $oldFileName = $book->picture;
                    if ($oldFileName && file_exists("upload/" . $oldFileName)) {
                        unlink("upload/" . $oldFileName);

                        move_uploaded_file($_FILES['image']['tmp_name'], "upload/$saveTo");
                        $book->picture = $saveTo;
                        $book->updateBook();
                        $success = "Your book has been successfully updated.";
                    }
                }
                (new View("editbook"))->show(array("user" => $user, "books" => $books));
            }
        }
    }

}
