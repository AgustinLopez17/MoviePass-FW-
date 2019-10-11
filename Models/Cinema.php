<?php

    namespace Models;

    class Cinema{
        private $id;
        private $name;
        private $address;
        private $capacity;
        private $ticket_value;
        private $available;

        public function __construct($id,$name, $address, $capacity, $ticket_value,$available)
        {
            $this->id = $id;
            $this->name = $name;
            $this->address = $address;
            $this->capacity = $capacity;
            $this->ticket_value = $ticket_value;
            $this->available = $available;
        }
    
        public function getName()
        {
                return $this->name;
        }

        public function setName($name)
        {
                $this->name = $name;

                return $this;
        }

        public function getAddress()
        {
                return $this->address;
        }
 
        public function setAddress($address)
        {
                $this->address = $address;

                return $this;
        }

        public function getCapacity()
        {
                return $this->capacity;
        }

        public function setCapacity($capacity)
        {
                $this->capacity = $capacity;

                return $this;
        }

        public function getTicket_value()
        {
                return $this->ticket_value;
        }

        public function setTicket_value($ticket_value)
        {
                $this->ticket_value = $ticket_value;

                return $this;
        }

        public function getId(){
                return $this->id;
        }
        public function setId($id){
                $this->id = $id;
        }

        public function getAvailable(){
                return $this->available;
        }
        public function setAvailable($available){
                $this->available = $available;
        }

    }

?>