<?php

class Rental extends Model {
    public $id;
    public $user;
    public $book;
    public $rentaldate;
    public $returndate;
    
    function __construct($id, $user, $book, $rentaldate = null, $returndate = null) {
        $this->id = $id;
        $this->user = $user;
        $this->book = $book;
        $this->rentaldate = $rentaldate;//date de location
        $this->returndate = $returndate;//date de retour
    }
    
    public function returndate($date){
        if($returndate > $rentaldate){
            $returndate = $date;
        }
        else
            $returndate = null;
    }
    
    public function rentaldate($date){
        if($rentaldate = null){
            $rentaldate = $date;
        }
        else
            $rentaldate = null;
    }
    
    public function deleterental(){
        
    }

}