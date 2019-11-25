<?php
    namespace Models;
    class CreditCard{
        private $numberCard;
        private $expire;
        private $securityCode;
        private $dni;
        
        public function __construct($numberCard,$expire,$securityCode,$dni){
            $this->numberCard = $numberCard;
            $this->expire = $expire;
            $this->securityCode = $securityCode;
            $this->dni = $dni;
        }

        /**
         * Get the value of numberCard
         */ 
        public function getNumberCard()
        {
                return $this->numberCard;
        }

        /**
         * Set the value of numberCard
         *
         * @return  self
         */ 
        public function setNumberCard($numberCard)
        {
                $this->numberCard = $numberCard;

                return $this;
        }

        /**
         * Get the value of expire
         */ 
        public function getExpire()
        {
                return $this->expire;
        }

        /**
         * Set the value of expire
         *
         * @return  self
         */ 
        public function setExpire($expire)
        {
                $this->expire = $expire;

                return $this;
        }

        /**
         * Get the value of securityCode
         */ 
        public function getSecurityCode()
        {
                return $this->securityCode;
        }

        /**
         * Set the value of securityCode
         *
         * @return  self
         */ 
        public function setSecurityCode($securityCode)
        {
                $this->securityCode = $securityCode;

                return $this;
        }

        /**
         * Get the value of dni
         */ 
        public function getDni()
        {
                return $this->dni;
        }

        /**
         * Set the value of dni
         *
         * @return  self
         */ 
        public function setDni($dni)
        {
                $this->dni = $dni;

                return $this;
        }
    }
?>