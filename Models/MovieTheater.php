<?php namespace Models;
    class MovieTheater{
        private $id;
        private $name;
        private $address;
        private $available;
        private $numberOfCinemas;

        public function __construct($name,$address,$available,$numberOfCinemas){
            $this->name = $name;
            $this->address = $address;
            $this->available = $available;
            $this->numberOfCinemas = $numberOfCinemas;
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of name
         */ 
        public function getName()
        {
                return $this->name;
        }

        /**
         * Set the value of name
         *
         * @return  self
         */ 
        public function setName($name)
        {
                $this->name = $name;

                return $this;
        }

        /**
         * Get the value of address
         */ 
        public function getAddress()
        {
                return $this->address;
        }

        /**
         * Set the value of address
         *
         * @return  self
         */ 
        public function setAddress($address)
        {
                $this->address = $address;

                return $this;
        }

        /**
         * Get the value of available
         */ 
        public function getAvailable()
        {
                return $this->available;
        }

        /**
         * Set the value of available
         *
         * @return  self
         */ 
        public function setAvailable($available)
        {
                $this->available = $available;

                return $this;
        }

        /**
         * Get the value of numberOfCinemas
         */ 
        public function getNumberOfCinemas()
        {
                return $this->numberOfCinemas;
        }

        /**
         * Set the value of numberOfCinemas
         *
         * @return  self
         */ 
        public function setNumberOfCinemas($numberOfCinemas)
        {
                $this->numberOfCinemas = $numberOfCinemas;

                return $this;
        }
    }


?>