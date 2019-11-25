<?php
    namespace Models;
    class Ticket{
        private $id_ticket;
        private $tk_code;
        private $id_purchase;
        private $id_show;

        public function __construct($tk_code,$id_purchase,$id_show){
            $this->tk_code = $tk_code;
            $this->id_purchase = $id_purchase;
            $this->id_show = $id_show;
        }

        /**
         * Get the value of id_ticket
         */ 
        public function getId_ticket()
        {
                return $this->id_ticket;
        }

        /**
         * Set the value of id_ticket
         *
         * @return  self
         */ 
        public function setId_ticket($id_ticket)
        {
                $this->id_ticket = $id_ticket;

                return $this;
        }

        /**
         * Get the value of id_purchase
         */ 
        public function getId_purchase()
        {
                return $this->id_purchase;
        }

        /**
         * Set the value of id_purchase
         *
         * @return  self
         */ 
        public function setId_purchase($id_purchase)
        {
                $this->id_purchase = $id_purchase;

                return $this;
        }

        /**
         * Get the value of id_show
         */ 
        public function getId_show()
        {
                return $this->id_show;
        }

        /**
         * Set the value of id_show
         *
         * @return  self
         */ 
        public function setId_show($id_show)
        {
                $this->id_show = $id_show;

                return $this;
        }

        /**
         * Get the value of tk_code
         */ 
        public function getTk_code()
        {
                return $this->tk_code;
        }

        /**
         * Set the value of tk_code
         *
         * @return  self
         */ 
        public function setTk_code($tk_code)
        {
                $this->tk_code = $tk_code;

                return $this;
        }
    }


?>