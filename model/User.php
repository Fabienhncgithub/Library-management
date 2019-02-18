<?php

require_once "framework/Model.php";
require_once "Book.php";

//require_once "book.php";

class User extends Model {

    public $id;
    public $username;
    public $hashed_password;
    public $fullname;
    public $email;
    public $birthdate;
    public $role;

    public function __construct($id, $username, $hashed_password, $fullname, $email, $birthdate = null, $role) {
        $this->id = $id;
        $this->username = $username;
        $this->hashed_password = $hashed_password;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->role = $role;
    }

    public static function get_member_by_pseudo($username) {
        $query = self::execute("SELECT * FROM user where username = :username", array("username" => $username));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["id"],$data["username"], $data["password"],$data["fullname"], $data["email"],$data["birthdate"], $data["role"]);
        }
    }

    public static function get_members() {
        $query = self::execute("SELECT * FROM user", array());
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new user($row["username"], $row["password"]);
        }
        return $results;
    }

    //renvoie un tableau d'erreur(s) 
    //le tableau est vide s'il n'y a pas d'erreur.
    //ne s'occupe que de la validation "métier" des champs obligatoires (le pseudo)
    //les autres champs (mot de passe, description et image) sont gérés par d'autres
    //méthodes.
    public function validate() {
        $errors = array();
        if (!(isset($this->username) && is_string($this->username) && strlen($this->username) > 0)) {
            $errors[] = "Username is required.";        
        } 
//        if (!(isset($this->username) && is_string($this->username) && strlen($this->username) >= 1 && strlen($this->username) <= 16)) {
//            $errors[] = "Pseudo length must be between 3 and 16.";
//        }
        if (!(isset($this->username) && is_string($this->username) && preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $this->username))) {
            $errors[] = "Username must start by a letter and must contain only letters and numbers.";
        }
        return $errors;
    }

    private static function validate_password($password) {
        $errors = [];
        if (strlen($password) < 8 || strlen($password) > 16) {
            $errors[] = "Password length must be between 8 and 16!";
        }if (!((preg_match("/[A-Z]/", $password)) && preg_match("/\d/", $password) && preg_match("/['\";:,.\/?\\-]/", $password))) {
            $errors[] = "Password must contain one uppercase letter, one number and one punctuation mark.";
        }
        return $errors;
    }

    public static function validate_passwords($password, $password_confirm) {
        $errors = user::validate_password($password);
        if ($password != $password_confirm) {
            $errors[] = "You have to enter twice the same password.";
        }
        return $errors;
    }

    public static function validate_unicity($username) {
        $errors = [];
        $user = self::get_member_by_pseudo($username);
        if ($user) {
            $errors[] = "This user already exists.";
        }
        return $errors;
    }

    //indique si un mot de passe correspond à son hash
    private static function check_password($clear_password, $hash) {
        return $hash === Tools::my_hash($clear_password);
    }

    //renvoie un tableau d'erreur(s) 
    //le tableau est vide s'il n'y a pas d'erreur.
    public static function validate_login($username, $password) {
        $errors = [];
        $user = User::get_member_by_pseudo($username);
        if ($user) {
            var_dump($password);
            var_dump($user);
            if (!self::check_password($password, $user->hashed_password)) {
                $errors[] = "Wrong password. Please try again!";
            }
        } else {
            $errors[] = "Can't find a user with the username '$username'. Please sign up.";
        }
        return $errors;
    }

    public function update() {
        if (self::get_member_by_pseudo($this->username))
            self::execute("UPDATE user SET password=:password, profile=:profile WHERE username=:username ", array("username" => $this->username, "password" => $this->hashed_password));
        else
            self::execute("INSERT INTO user (username,password, fullname, email, birthdate, role) VALUES(:username,:password,:fullname,:email,:birthdate, :role)", array("username" => $this->username, "password" => $this->hashed_password,"fullname" => $this->fullname, "email" => $this->email, "birthdate" => $this->birthdate, "role" => $this->role));
        return $this;
    }
    
    
    
        public function isAdmin() {
        $query = self::execute("select * from user where username=:username and role='admin'", array(":username" => $this->username));
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    }
    
        
            public function isMember() {
        $query = self::execute("select * from user where username=:username and role='member'", array(":username" => $this->username));
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    
            public function isManager() {
        $query = self::execute("select * from user where username=:username and role='manager'", array(":username" => $this->username));
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    }
        public static function validate_admin($username) {
        $errors = [];
        $user = User::get_member_by_role($username);
        if (!$user) {

            $errors[] = "You are not allowed to do this kind of operéation.";
        }
        return $errors;
    }
    
     public static function get_member_by_role($username) {
        $query = self::execute("SELECT * FROM user where username = :username and role='admin'", array("username" => $username));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["id"],$data["username"], $data["password"],$data["fullname"], $data["email"],$data["birthdate"], $data["role"]);
        }
    }
    
}


