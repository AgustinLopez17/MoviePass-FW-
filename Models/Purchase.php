<?php 
    namespace Models;
    class Purchase{
        private $id_purchase;
        private $id_show;
        private $purchased_tickets;
        private $date_purchase;
        private $discount;
        private $qr;
        private $dni;
        private $amount;

        public function __construct($id_show,$purchased_tickets,$date_purchase,$discount,$qr,$DNI,$amount){
            $this->id_show= $id_show;    
            $this->purchased_tickets = $purchased_tickets;
            $this->date_purchase = $date_purchase;
            $this->discount = $discount;
            $this->qr = $qr;
            $this->dni = $DNI;
            $this->amount = $amount;
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
         * Get the value of purchased_tickets
         */ 
        public function getPurchased_tickets()
        {
                return $this->purchased_tickets;
        }

        /**
         * Set the value of purchased_tickets
         *
         * @return  self
         */ 
        public function setPurchased_tickets($purchased_tickets)
        {
                $this->purchased_tickets = $purchased_tickets;

                return $this;
        }

        /**
         * Get the value of date_purchase
         */ 
        public function getDate_purchase()
        {
                return $this->date_purchase;
        }

        /**
         * Set the value of date_purchase
         *
         * @return  self
         */ 
        public function setDate_purchase($date_purchase)
        {
                $this->date_purchase = $date_purchase;

                return $this;
        }

        /**
         * Get the value of discount
         */ 
        public function getDiscount()
        {
                return $this->discount;
        }

        /**
         * Set the value of discount
         *
         * @return  self
         */ 
        public function setDiscount($discount)
        {
                $this->discount = $discount;

                return $this;
        }

        /**
         * Get the value of qr
         */ 
        public function getQr()
        {
                return $this->qr;
        }

        /**
         * Set the value of qr
         *
         * @return  self
         */ 
        public function setQr($qr)
        {
                $this->qr = $qr;

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
         * Get the value of amount
         */ 
        public function getAmount()
        {
                return $this->amount;
        }

        /**
         * Set the value of amount
         *
         * @return  self
         */ 
        public function setAmount($amount)
        {
                $this->amount = $amount;

                return $this;
        }
    }


?>