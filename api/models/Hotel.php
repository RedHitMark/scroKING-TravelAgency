<?php 

class Hotel{
    public $_id;
    public $name;
    public $destination;
    public $address;
    public $phone;
    public $email;
    public $freeRoom;

    /**
     * Hotel constructor.
     * @param $_id
     * @param $name
     * @param $destination
     * @param $address
     * @param $phone
     * @param $email
     * @param $freeRoom
     */
    public function __construct($_id, $name, $destination, $address, $phone, $email, $freeRoom) {
        $this->_id = $_id;
        $this->name = $name;
        $this->destination = $destination;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
        $this->freeRoom = $freeRoom;
    }


}

     




?>
