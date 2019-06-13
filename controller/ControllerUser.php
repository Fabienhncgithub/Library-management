<?php

require_once 'model/User.php';
require_once 'model/Rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerUser extends Controller {

    const UPLOAD_ERR_OK = 0;

    //page d'accueil. 
    public function index() {
        $this->profile();
    }

    //profil de l'utilisateur connecté ou donné
    public function profile() {
        $user = Controller::get_user_or_redirect();
        $username = $user->username;
        $user = User::get_member_by_pseudo($username);
        $users = $user->id;
        $rentals = Rental::get_rental_by_user_with_rentaldate($users);

        (new View("profile"))->show(array("user" => $user, "rentals" => $rentals));
    }

    public function users() {
        $user = Controller::get_user_or_redirect();
        $users = User::get_member_by_all();

        (new View("users"))->show(array("user" => $user, "users" => $users));
    }

    public function members() {
        $member = $this->get_user_or_redirect();
        $members = $member->get_users();
        (new View("users"))->show(array("user" => $user, "member" => $member, "users" => $users));
    }

//    public function edit_user() {
//        $id = null;
//        $user = $this->get_user_or_redirect();
//        $username = '';
//        $fullname = '';
//        $email = '';
//        $birthdate = null;
//        $role = '';
//
//        if (isset($_POST["id"]) && $_POST["id"] !== "") {
//            $edit = User::get_member_by_id($_POST["id"]);
//            $id = $edit->id;
//            $username = $edit->username;
//            $fullname = $edit->fullname;
//            $email = $edit->email;
//            $birthdate = $edit->birthdate;
//            $role = $edit->role;
//        }
//        (new View("edit-user"))->show(array("id" => $id, "users" => $user, "username" => $username, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role));
//    }
    public function edit_user_prg() {
        $id = null;
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin() || $user->isManager()) {
            $username = '';
            $fullname = '';
            $email = '';
            $birthdate = null;
            $role = '';
            if (isset($_POST['id'])) {
                $this->redirect("user", "edit_user_prg", $_POST["id"]);
            }
            if (isset($_GET['param1'])) {
                $edit = User::get_member_by_id($_GET['param1']);
                $id = $edit->id;
                $username = $edit->username;
                $fullname = $edit->fullname;
                $email = $edit->email;
                $birthdate = $edit->birthdate;
                $role = $edit->role;
            }
            (new View("edit-user"))->show(array("id" => $id, "users" => $user, "username" => $username, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role));
        } else {
            $this->redirect("rental", "return_book");
        }
    }

    public function delete_user() {
        $user = Controller::get_user_or_redirect();
        if ($user->isAdmin()) {
            $username = $user->username;
            $user = User::get_member_by_pseudo($username);
            if (isset($_POST['id'])) {
                $this->redirect("user", "delete_user", $_POST["id"]);
            }
            if (isset($_GET['param1'])) {
                $id = ($_GET['param1']);
                $users = User::get_member_by_id($id);
            }
            (new View("confirm_delete_user"))->show(array("user" => $user, "users" => $users));
        } else {
            $this->redirect("rental", "return_book");
        }
    }

    public function confirm_delete_user() {
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin()) {
            if (isset($_POST['iduser']) && isset($_POST['confirm'])) {
                $confirm = $_POST['confirm'];
                $users = ($_POST["iduser"]);
                if ($confirm != 0) {
                    $users = User::get_member_by_id($users);
                    $users->deleteuser();
                }
            }
            $this->redirect("User", "Users");
        } else {
            $this->redirect("book", "index");
        }
    }

    public function add_user() {
        $id = null;
        $user = $this->get_user_or_redirect();
        $username = '';
        $fullname = '';
        $email = '';
        $birthdate = null;
        $role = 'member';
        $errors = [];

        if (isset($_POST["id"]) && $_POST["id"] !== "") {
            $edit = User::get_member_by_id($_POST["id"]);
            $username = $edit->username;
            $fullname = $edit->fullname;
            $email = $edit->email;
            $birthdate = $edit->birthdate;
        }
        (new View("add-user"))->show(array("users" => $user, "username" => $username, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role));
    }

    public function adduser() {
        $user = Controller::get_user_or_redirect();
        if ($user->isAdmin() || $user->isManager()) {
            $id = '';
            $username = '';
            $password = '';
            $password_confirm = '';
            $fullname = '';
            $email = '';
            $birthdate = '';
            $errors = [];

            if (isset($_POST['cancel'])) {
                $this->redirect("user", "users");
            }
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['birthdate'])) {

                $username = $_POST['username'];
                $password = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $birthdate = $_POST['birthdate'];
                $role = $_POST['role'];
                $newuser = new User('', $username, Tools::my_hash($password), $fullname, $email, $birthdate, $role);
//            $errors = User::validate_email($email);
//            $errors = User::validate_unicity($username);
//            $errors = array_merge($errors, $user->validate());
//            $errors = array_merge($errors, User::validate_passwords($password, $password_confirm));
                $errors = User::validate_unicity_adduser($username, $fullname, $password, $password_confirm, $email);
                if (count($errors) == 0) {
                    $newuser->update(); //sauve l'utilisateur
                    $this->redirect("user", "users");
                }
            }
            (new View("add-user"))->show(array("users" => $user, "username" => $username, "password" => $password, "password_confirm " => $password_confirm, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "errors" => $errors));
        } else {
            $this->redirect("book", "index");
        }
    }

    public function save_user() {
        $user = $this->get_user_or_redirect();
        if ($user->isAdmin() || $user->isManager()) {
            $errors = [];
            if (isset($_POST['cancel'])) {
                $this->redirect("user", "users");
            }
            if (isset($_POST['id']) && isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['birthdate']) && isset($_POST['role'])) {
                $users = User::get_member_by_id($_POST["id"]);
                $id = $_POST['id'];
                $username = $_POST['username'];
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $birthdate = $_POST['birthdate'];
                $role = $_POST['role'];
//            if (trim($username) == '')
//                $errors[] = "rentrez votre pseudo";
//            if (($fullname) == '')
//                $errors[] = "rentrez votre nom";
//            if (($email) == '')
//                $errors[] = "rentrez votre email";
                //$newuser = new User('', $username, Tools::my_hash($password), $fullname, $email, $birthdate, $role);
                //$errors = User::validate_unicity($username);
                // $errors = User::validate_unicity($username);
//            $errors = User::validate_email($email);
//            $errors = array_merge($errors, $user->validate());
//            if ($username != $edit->username)
//                $errors = User::validate_unicity($username);
//              if ($email != $edit->email)
//                $errors = User::validate_email($email);
                $edit = User::get_member_by_id($_POST["id"]);
                $edit->username = $username;
                $edit->fullname = $fullname;
                $edit->email = $email;
                $edit->birthdate = $birthdate;
                $edit->role = $role;
                $errors = User::unicity_edit_user($users, $username, $fullname, $email, $birthdate, $role);
                if (count($errors) == 0) {
                    $edit->update_User(); //update l'utilisateur
                    $this->redirect("user", "users");
                }
            }
            (new View("edit-user"))->show(array("id" => $id, "users" => $user, "username" => $username, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role, "errors" => $errors));
        } else {
            $this->redirect("book", "index");
        }
    }

    public function user_exists_service_edit() {
        $res = "true";
        if (isset($_POST["username"]) && isset($_POST["iduser"])) {
            $member = User::get_member_by_pseudo($_POST["username"]);
            $member2 = User::get_member_by_id(($_POST["iduser"]));
            if ($member) {
                $res = "false";
                if ($member->username === $member2->username) {
                    $res = "true";
                }
            }
        }
        echo $res;
    }

    public function user_exists_service() {
        $res = "true";
        if (isset($_POST["username"]) && $_POST["username"] !== "") {
            $member = User::get_member_by_pseudo($_POST["username"]);
            if ($member) {
                $res = "false";
            }
        }
        echo $res;
    }

    public function email_exists_service() {
        $res = "true";
        if (isset($_POST["email"]) && $_POST["email"] !== "") {
            $email = User::get_member_by_email($_POST["email"]);
            if ($email) {
                $res = "false";
            }
        }
        echo $res;
    }

    public function email_exists_service_edit() {
        $res = "true";
        if (isset($_POST["email"]) && isset($_POST["iduser"])) {

            $member = User::get_member_by_email($_POST["email"]);
            $member2 = User::get_member_by_id(($_POST["iduser"]));
            if ($member) {
                $res = "false";
                if ($member->email === $member2->email) {
                    $res = "true";
                }
            }
        }
        echo $res;
    }

}
