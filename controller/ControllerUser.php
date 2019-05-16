<?php

require_once 'model/User.php';
require_once 'model/Rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerUser extends Controller {

    const UPLOAD_ERR_OK = 0;

    
    public function user_exists_service(){
        $res = "false";
        if(isset($_GET["param1"]) && $_GET["param1"] !== ""){
            $member = User::get_member_by_pseudo($_GET["param1"]);
            if($member)
                $res = "true";
        } 
        echo $res;
    }
    
    
    
    

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
       $rentals = Rental::get_rental_by_user($users);
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

    public function edit_user() {
        $id = null;
        $user = $this->get_user_or_redirect();
        $username = '';
        $fullname = '';
        $email = '';
        $birthdate = null;
        $role = '';

        if (isset($_POST["id"]) && $_POST["id"] !== "") {
            $edit = User::get_member_by_id($_POST["id"]);
            $id = $edit->id;
            $username = $edit->username;
            $fullname = $edit->fullname;
            $email = $edit->email;
            $birthdate = $edit->birthdate;
            $role = $edit->role;
        }
        (new View("edit-user"))->show(array("id" => $id, "users" => $user, "username" => $username, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role));
    }

    public function delete_user() {
        $user = $this->get_user_or_redirect();
        $users = User::get_member_by_all();
        if ($user->isAdmin()) {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $user = User::get_member_by_id($id);
                $user->delete();
            }
            $users = User::get_member_by_all();
            $this->redirect("user", "users");
        }
        (new View("users"))->show(array("user" => $user, "users" => $users));
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

            if (empty($username)) {
                $errors[] = "User Name is required.";
            }

            if ($username == '')
                $errors[] = "rentrez votre pseudo";
            if (($fullname) == '')
                $errors[] = "rentrez votre nom";
            if (($password) == '')
                $errors[] = "rentrez votre password";
            if (($email) == '')
                $errors[] = "rentrez votre email";

            $newuser = new User('', $username, Tools::my_hash($password), $fullname, $email, $birthdate, $role);

            $errors = User::validate_unicity($username);
            $errors = array_merge($errors, $user->validate());
            $errors = array_merge($errors, USer::validate_passwords($password, $password_confirm));
//       
            if (count($errors) == 0) {
                $newuser->update(); //sauve l'utilisateur
                $this->redirect("user", "users");
                echo 'sauvé';
            }
        }
        (new View("add-user"))->show(array("username" => $username, "password" => $password, "password_confirm " => $password_confirm, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "errors" => $errors));
    }

    public function save_user() {
        $user = $this->get_user_or_redirect();

        $errors = [];

        if (isset($_POST['cancel'])) {
            $this->redirect("user", "users");
        }

        if (isset($_POST['id']) && isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['birthdate']) && isset($_POST['role'])) {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            $role = $_POST['role'];
            if (trim($username) == '')
                $errors[] = "rentrez votre pseudo";
            if (($fullname) == '')
                $errors[] = "rentrez votre nom";
            if (($email) == '')
                $errors[] = "rentrez votre email";
            //$newuser = new User('', $username, Tools::my_hash($password), $fullname, $email, $birthdate, $role);
            // $errors = User::validate_unicity($username);
            $errors = array_merge($errors, $user->validate());
            $edit = User::get_member_by_id($_POST["id"]);
            $edit->username = $username;
            $edit->fullname = $fullname;
            $edit->email = $email;
            $edit->birthdate = $birthdate;
            $edit->role = $role;

            if (count($errors) == 0) {
                $edit->update_User(); //update l'utilisateur
                $this->redirect("user", "users");
            }
        }
        (new View("edit-user"))->show(array("username" => $username, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role, "errors" => $errors));
    }

}
