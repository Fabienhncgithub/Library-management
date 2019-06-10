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

        $filter = [];
        if (isset($_GET["param1"])) {
            $filter = Utils::url_safe_decode($_GET["param1"]);
            if (!$filter)
                Utils::abort("bad url parameter");
        }
        if (isset($_POST["critere"]) && isset($_POST['member'])) {
            $filter["critere"] = $_POST["critere"];
            $filter["member"] = $_POST["member"];
            $this->redirect("book", "search", Utils::url_safe_encode($filter));
        }

        $smember = User::get_member_by_pseudo($filter['member']);
        $idsmember = $smember->id;
        $user = User::get_member_by_pseudo($user->username);
        $users = $user->id;

        $role = User::get_member_by_role($user->username);

        $selections = Rental::get_book_by_user_without_rental($smember->id);
        $id = $users;
        $members = User::selection_member_by_all_not_selected($id);
        $search = ($filter['critere']);
        $books = Book::get_book_by_filter($filter["critere"], $smember->id);


        (new View("reservation"))->show(array("books" => $books, "selections" => $selections, "user" => $user, "members" => $members, "smember" => $smember, "role" => $role));
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
        if ($user->isAdmin() || $user->isManager()) {
            $role = User::get_member_by_role($user->username);
            if (isset($_POST['details'])) {
                $this->redirect("book", "details", $_POST["details"]);
            }
            if (isset($_GET['param1'])) {
                $books = Book::get_book_by_id($_GET['param1']);
            }
            (new View("details"))->show(array("books" => $books, "user" => $user, "role" => $role));
        } else {
            $this->redirect("book", "index");
        }
    }

    public function delete() {
        $books = new Book();
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
            $role = User::get_member_by_role($user->username);
            if (isset($_POST['id_book'])) {
                $this->redirect("book", "delete", $_POST["id_book"]);
            }
            if (isset($_GET['param1'])) {
                $books = $_GET['param1'];
                $errors = user::validate_admin($user->username);
                $books = Book::get_member_by_object_id($books);
            }
            (new View("confirm"))->show(array("user" => $user, "books" => $books, "role" => $role));
        } else {
            $this->redirect("book", "index");
        }
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

    public function edit() {
        $id = null;
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
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
                $edit->isbn = substr($edit->isbn, 0, 12);
                //$edit->isbn == find_Isbn($isbn);
                $title = $edit->title;
                $author = $edit->author;
                $editor = $edit->editor;
                $picture = $edit->picture;
            }
            (new View("editbook"))->show(array("id" => $id, "books" => $edit, "isbn" => $isbn, "title" => $title, "author" => $author, "editor" => $editor, "picture" => $picture, "role" => $role));
        } else {
            $this->redirect("book", "index");
        }
    }

    public function edit_book() {
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
            $errors = [];
            $books = "";
            if (isset($_POST['cancel'])) {
                $this->redirect("book", "index");
            }
            if (isset($_POST['edit'])) {
                $books = Book::get_member_by_object_id($_POST['edit']);
                (new View("editbook"))->show(array("books" => $books));
            }
            if (isset($_POST['id']) && isset($_POST['isbn']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['editor']) && isset($_POST['picture'])) {
                $books = Book::get_member_by_object_id($_POST['id']);
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
                $errors = Book::unicity_edit_book($books, $this->get_isbn_format($isbn), $title, $editor, $author);
                if (empty($errors)) {
                    $edit->isbn = $this->get_isbn_format($isbn);
                    $edit->updateBook();
                    $this->redirect("book", "index");
                }
                (new View("editbook"))->show(array("user" => $user, "books" => $books, "errors" => $errors));
            } else {
                $this->redirect("book", "index");
            }
        }
    }

    public function add_book() {
        $book = new Book();
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin() || $user->isManager()) {
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
                $newbook = new Book('', $this->get_isbn_format($isbn), $title, $author, $editor, $picture);
                $errors = Book::validate_unicity_addbook($this->get_isbn_format($isbn), $title, $author, $editor);
                if (count($errors) == 0) {

                    $newbook->updateBook(); //sauve le livre
                    $this->redirect("book", "index");
                }
            }
            (new View("add_book"))->show(array("isbn" => $isbn, "title" => $title, "author" => $author, "editor" => $editor, "picture" => $picture, "errors" => $errors, "role" => $role));
        } else {
            $this->redirect("rental", "return_book");
        }
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

    public function find_Isbn($isbn) {
        $res = 0;
        $arrayphp = [];
        $res2 = 0;

        for ($i = 0; $i < strlen($isbn); ++$i) {
            $arrayphp[$i] = (int) $isbn[$i];
        }
        for ($j = 1; $j <= sizeof($arrayphp); ++$j) {
            if ($j % 2 === 0) {
                $arrayphp[$j - 1] *= 3;
            }
        }
        foreach ($arrayphp as $a) {
            $res += $a;
        }
        if ($res % 10 != 0) {
            $res2 = (int) 10 - (int) ($res % 10);
        }
        return $res2;
    }

    public function get_isbn_format($isbn) {
        return $isbn . $this->find_Isbn($isbn);
    }

    public function JSIsbn() {
        if (isset($_GET['param1'])) {
            $isbn = $this->find_Isbn($_GET['param1']);
            echo json_encode($isbn);
        }
    }

    public function JSIsbnformat() {
        if (isset($_GET['param1'])) {
            $isbn = $this->get_isbn_format($_GET['param1']);
            echo json_encode($isbn);
        }
    }

}
