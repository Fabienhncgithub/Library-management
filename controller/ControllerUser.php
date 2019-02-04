<?php

require_once 'model/User.php';
require_once 'model/Book.php';
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
        (new View("profile"))->show(array("user" => $user));
    }
    
    
 
    
//
//    //liste des membres.
//    public function users() {
//        $member = $this->get_user_or_redirect();
//        $members = $member->get_other_members_and_relationships();
//        (new View("users"))->show(array("user" => $user, "users" => $users));
//    }


    
    
    

}

