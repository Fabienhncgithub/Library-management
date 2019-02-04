<?php

require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerMain extends Controller {

    //si l'utilisateur est conecté, redirige vers son profil.
    //sinon, produit la vue d'accueil.
    public function index() {
        if ($this->user_logged()) {
            $this->redirect("user", "profile");
        } else {
            (new View("index"))->show();
        }
    }

    //gestion de la connexion d'un utilisateur
    public function login() {
        $username = '';
        $password = '';
        $errors = [];
        if (isset($_POST['username']) && isset($_POST['password'])) { //note : pourraient contenir
            //des chaînes vides
            $username = $_POST['username'];
            $password = $_POST['password'];
            $errors = User::validate_login($username, $password);
            if (empty($errors)) {
                $this->log_user(User::get_member_by_pseudo($username));
            }
        }
        (new View("login"))->show(array("username" => $username, "password" => $password, "errors" => $errors));
    }

    //gestion de l'inscription d'un utilisateur
    public function signup() {
        $username = '';
        $password = '';
        $password_confirm = '';
        $fullname = '';
        $email = '';
        $birthdate = '';
        $errors = [];


        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['birthdate'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            $role = 'member';


            $user = new User('',$username, Tools::my_hash($password),$fullname,$email,$birthdate,$role);
            $errors = User::validate_unicity($username);
            $errors = array_merge($errors, $user->validate());
            $errors = array_merge($errors, USer::validate_passwords($password, $password_confirm));

            if (count($errors) == 0) {
                $user->update(); //sauve l'utilisateur
                $this->log_user($user);
            }
        }
        (new View("signup"))->show(array("username" => $username, "password" => $password, "password_confirm" => $password_confirm, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "errors" => $errors));
    }

    //profil de l'utilisateur connecté ou donné
    public function username() {
        $user = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $user = User::get_member_by_pseudo($_GET["param1"]);
        }
        (new View("username"))->show(array("user" => $user));
    }

}
