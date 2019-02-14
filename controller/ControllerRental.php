<?php

require_once 'model/rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerRenatl extends Controller {
   
    public function index() {
        $user = Controller::get_user_or_redirect();
        $rentals = Rental::get_rental_by_user($user);
        (new View("profile"))->show(array("rentals" => $rentals, "user" => $user));
    }
    
    public function rent(){
        
        
        $user = Controller::get_user_or_redirect();
        $rentals = Rental::get_rental_by_user($user);
        
        
        (new View("profile"))->show(array("rentals" => $rentals, "user" => $user));
    }

}
