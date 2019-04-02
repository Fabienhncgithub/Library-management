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
        $user = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $user = User::get_member_by_pseudo($_GET["param1"]);
        }
        $rentals = Rental::get_rental_by_user($user);

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

    public function add_user() {
         $id = null;
        $user = $this->get_user_or_redirect();
        
        $username = '';
        $fullname = '';
        $email = '';
        $birthdate = null;
        $role = 'member';
        
        if (isset($_POST["id"]) && $_POST["id"] !== "") {
          $edit = User::get_member_by_id($_POST["id"]);
   
          
          $username=$edit->username;
          $fullname=$edit->fullname;
          $email=$edit->email;
                 var_dump($email);
          $birthdate=$edit->birthdate;
                  var_dump($birthdate);
          $role=$role->role;
          var_dump($role);
          
          
            
        }
        (new View("add-user"))->show(array("users" => $user, "username" => $username, "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role));

    }

    public function delete_user() {
        echo 'test2';
    }

}
