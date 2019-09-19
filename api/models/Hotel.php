<?php 

class Hotel{
    public $_id;
    public $hName;
    public $hAddress;
    public $hPhone;
    public $hEmail;
    public $hFreeRoom;

    public function __construct($_id,$hName,$hAddress,$hPhone,$hEmail,$hFreeRoom){

        $this->_id = $_id;
        $this->$hName = $hName;
        $this->hAdress = $hAddress;
        $this->$hEmail = $hEmail;
    }
}

     




?>