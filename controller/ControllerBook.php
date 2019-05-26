<?php

require_once 'model/book.php';
require_once 'model/rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'framework/Utils.php';

class ControllerBook extends Controller {

    //si l'utilisateur est conecté, redirige vers son profil.
    //sinon, produit la vue d'accueil.
    public function index() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        $books = Book::get_book_not_rental_by_member($users);
        $selections = Rental::get_book_by_user_without_rental($users);
        $id = $users;
        $members = User::selection_member_by_all_not_selected($id);
        $smember = $user;
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember));
    }

    public function search() {
        $user = Controller::get_user_or_redirect();
        if (isset($_POST['critere']) && isset($_POST['member'])) {
            $smember = User::get_member_by_pseudo($_POST['member']);
            $idsmember = $smember->id;
            $user = User::get_member_by_pseudo($user->username);
            $users = $user->id;
            
            $role = User::get_member_by_role($user->username);
            var_dump($role);
            
                    
            $selections = Rental::get_book_by_user_without_rental($smember->id);
            $id = $users;
            $members = User::selection_member_by_all_not_selected($id);
            $search = ($_POST['critere']);
            $filter = [];
            if (isset($_GET["param1"])) {
                $filter = Utils::url_safe_decode($_GET["param1"]);
                if (!$filter)
                    Utils::abort("bad url parameter");
            }
            if (isset($_POST["critere"])) {
                $filter["critere"] = $_POST["critere"];
                $this->redirect("book", "index", Utils::url_safe_encode($filter));
            }
            $books = Book::get_book_by_filter($filter["critere"], $smember->id);
            $selections = Rental::get_book_by_user_without_rental($smember->id);
        }
        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember,"role" => $role));
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
             $role = User::get_member_by_role($user->username);

        if (isset($_POST['details'])) {
            $this->redirect("book", "details", $_POST["details"]);
        }
        if (isset($_GET['param1'])) {
            $books = Book::get_book_by_id($_GET['param1']);
        }
        (new View("details"))->show(array("books" => $books, "user" => $user, "role" =>$role));
    }

    public function edit() {
        $id = null;
        $user = $this->get_user_or_redirect();
        $role = User::get_member_by_role($user->username);
            
        $isbn = '';
        $title = '';
        $author = '';
        $editor = '';
        $picture = '';

        if (isset($_POST['edit'])) {
            $this->redirect("book", "edit", $_POST["edit"]);
        }

        if (isset($_GET['param1'])) {
            $edit = $_GET['param1'];
            $edit = Book::get_member_by_object_id($edit);
            $id = $edit->id;
            $isbn = $edit->isbn;
            $title = $edit->title;
            $author = $edit->author;
            $editor = $edit->editor;
            $picture = $edit->picture;
        }
        (new View("editbook"))->show(array("id" => $id, "books" => $edit, "isbn" => $isbn, "title" => $title, "author" => $author, "editor" => $editor, "picture" => $picture, "role" => $role));
    }

    public function delete() {
        $books = new Book();
        $user = $this->get_user_or_redirect();
             $role = User::get_member_by_role($user->username);
        if (isset($_POST['id_book'])) {
            $this->redirect("book", "delete", $_POST["id_book"]);
        }
        if (isset($_GET['param1'])) {
            $books = $_GET['param1'];
            $errors = user::validate_admin($user->username);
//                if (empty($errors)) {
            $books = Book::get_member_by_object_id($books);
            //                }
        }
        (new View("confirm"))->show(array("user" => $user, "books" => $books, "role" => $role));
    }

    public function confirm_delete() {
        $books = new Book();
        $user = $this->get_user_or_redirect();


        if ($user->isAdmin()) {
            if (isset($_POST['idbook']) && isset($_POST['confirm'])) {
                $idbook = $_POST['idbook'];
                $confirm = $_POST['confirm'];
                if ($confirm != 0) {
                    $books->id = $_POST['idbook'];
                    $books->delete_Book();
                }
                $this->redirect("book", "index");
            }
            $this->redirect("book", "delete");
        }
    }

    public function edit_book() {
        $user = $this->get_user_or_redirect();
        $errors = [];
        if (isset($_POST['cancel'])) {
            $this->redirect("book", "index");
        }

        if (isset($_POST['id']) && isset($_POST['isbn']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['editor']) && isset($_POST['picture'])) {

            $id = $_POST['id'];
            $isbn = $_POST['isbn'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $editor = $_POST['editor'];
            $picture = $_POST['picture'];

//                $errors = Book::validate_photo($_FILES['image']);
//                if (empty($errors)) {
//                    $saveTo = $book->generate_photo_name($_FILES['image']);
//                    $oldFileName = $book->picture;
//                    if ($oldFileName && file_exists("upload/" . $oldFileName)) {
//                        unlink("upload/" . $oldFileName);
//
//                        move_uploaded_file($_FILES['image']['tmp_name'], "upload/$saveTo");
//                        $book->picture = $saveTo;
//                        $book->updateBook();
//                        $success = "Your book has been successfully updated.";
//                        $this->redirect("book", "index");

            $edit = Book::get_member_by_object_id($_POST["id"]);
            $edit->isbn = $isbn;
            $edit->title = $title;
            $edit->editor = $editor;
            $edit->author = $author;
            $edit->picture = $picture;

            if (count($errors) == 0) {
                $edit->updateBook();
                $this->redirect("book", "index");
            }
            (new View("reservation"))->show(array("user" => $user, "books" => $books));
        }
    }

    public function add_book() {
        $book = new Book();
        $user = $this->get_user_or_redirect();
             $role = User::get_member_by_role($user->username);
        $id = '';
        $isbn = '';
        $title = '';
        $author = '';
        $editor = '';
        $picture = '';
        $errors = [];

        if (isset($_POST['cancel'])) {
            $this->redirect("book", "index");
        }
        if (isset($_POST['isbn']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['editor']) && isset($_POST['picture'])) {
            $isbn = $_POST['isbn'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $editor = $_POST['editor'];
            $picture = $_POST['picture'];

            $newbook = new Book('', $isbn, $title, $author, $editor, $picture);
            $errors = Book::validate_unicity_isbn($isbn);
            $errors = Book::validate_author($author);
            $errors = Book::validate_title($title);

            if (count($errors) == 0) {
                $newbook->updateBook(); //sauve le livre
                $this->redirect("book", "index");
            }
        }
        (new View("add_book"))->show(array("isbn" => $isbn, "title" => $title, "author" => $author, "editor" => $editor, "picture" => $picture, "errors" => $errors, "role" => $role));
    }

    public function return_book() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        $id = $users;
        $books = Book::get_book_by_all();
        $selections = Rental::get_book_by_user_without_rental($users);
        $members = User::selection_member_by_all_not_selected($id);

        (new View("return_book"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members));
    }

    public function find_book() {
        if (isset($_GET['param1']) && !$_GET['param1'] == "" && isset($_GET['param2'])) {
            if ($_GET['param1'] !== " ") {
                $result = Book::get_book_by_filter($_GET['param1'], $_GET['param2']);
                echo json_encode($result);
            } else {
                $result = Book::get_book_by_all($_GET['param2']);
                echo json_encode($result);
            }
        }
    }

    public function isbn_available_service() {
        $res = "true";
        if (isset($_POST["isbn"]) && $_POST["isbn"] !== "") {
            $isbn = Book::get_book_by_ISBN($_POST["isbn"]);
            if ($isbn) {
                $res = "false";
            }
        }
        echo $res;
    }

    public function isbn_available_service_edit() {
        $res = "true";
        if (isset($_POST["isbn"]) && isset($_POST["idbook"])) {

            $book = Book::get_book_isbn($_POST["isbn"]);
            $book2 = Book::get_book_id(($_POST["idbook"]));

            if ($book) {
                $res = "false";
                if ($book->isbn === $book2->isbn) {
                    $res = "true";
                }
            }
        }
        echo $res;
    }

}
