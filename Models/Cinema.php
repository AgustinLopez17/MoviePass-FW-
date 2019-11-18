<?php

    namespace Models;

    class Cinema{
        private $idCinema;
        private $idMovieTheater;
        private $numberCinema;
        private $capacity;
        private $ticket_value;
        private $available;

        public function __construct($idMovieTheater,$numberCinema, $capacity, $ticket_value,$available)
        {
            $this->idMovieTheater = $idMovieTheater;    
            $this->numberCinema= $numberCinema;
            $this->capacity = $capacity;
            $this->ticket_value = $ticket_value;
            $this->available = $available;
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

        public function getAvailable(){
                return $this->available;
        }
        public function setAvailable($available){
                $this->available = $available;
        }


        /**
         * Get the value of idCinema
         */ 
        public function getIdCinema()
        {
                return $this->idCinema;
        }

        /**
         * Set the value of idCinema
         *
         * @return  self
         */ 
        public function setIdCinema($idCinema)
        {
                $this->idCinema = $idCinema;

                return $this;
        }

        /**
         * Get the value of idMovieTheater
         */ 
        public function getIdMovieTheater()
        {
                return $this->idMovieTheater;
        }

        /**
         * Set the value of idMovieTheater
         *
         * @return  self
         */ 
        public function setIdMovieTheater($idMovieTheater)
        {
                $this->idMovieTheater = $idMovieTheater;

                return $this;
        }

        /**
         * Get the value of numberCinema
         */ 
        public function getNumberCinema()
        {
                return $this->numberCinema;
        }

        /**
         * Set the value of numberCinema
         *
         * @return  self
         */ 
        public function setNumberCinema($numberCinema)
        {
                $this->numberCinema = $numberCinema;

                return $this;
        }
    }

?>