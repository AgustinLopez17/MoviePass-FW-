<?php

    namespace Models;

    class Cinema{
        private $name;
        private $adress;
        private $capacity;
        private $ticket_value;

        public function __construct($name, $adress, $capacity, $ticket_value)
        {
            $this->name = $name;
            $this->adress = $adress;
            $this->capacity = $capacity;
            $this->ticket_value = $ticket_value;
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

        public function getAdress()
        {
                return $this->adress;
        }
 
        public function setAdress($adress)
        {
                $this->adress = $adress;

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
    }

?>