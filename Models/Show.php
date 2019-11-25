<?php

    namespace Models;

    use DateTime;

    class Show{
        private $id_show;
        private $date;
        private $id_cinema;
        private $id_movieTheater;
        private $id_movie;
        
        private $total_tickets;
        private $tickets_sold;
        private $ticket_price;
        
        public function __construct($date,$id_cinema,$id_movie,$id_movieTheater,$total_tickets,$tickets_sold,$ticket_price){
            $this->date = new DateTime($date); 
            $this->id_cinema = $id_cinema;
            $this->id_movie = $id_movie;
            $this->id_movieTheater = $id_movieTheater;
            $this->total_tickets = $total_tickets;
            $this->tickets_sold = $tickets_sold;
            $this->ticket_price = $ticket_price;
        }
    
        public function getDate()
        {
                return $this->date;
        }

        public function setDate($date)
        {
                $this->date = $date;
        }

        public function setId_show($id_show){
            $this->id_show = $id_show;
        }
        public function getId_show(){
            return $this->id_show;
        }
        
        public function getId_cinema(){
            return $this->id_cinema;
        }
        public function setId_cinema($id_cinema){
            $this->id_cinema = $id_cinema;
        }

        public function getId_movie()
        {
            return $this->id_movie;
        }
        public function setId_movie($id_movie)
        {
            $this->id_movie = $id_movie;
        }

        /**
         * Get the value of id_movieTheater
         */ 
        public function getId_movieTheater()
        {
                return $this->id_movieTheater;
        }

        /**
         * Set the value of id_movieTheater
         *
         * @return  self
         */ 
        public function setId_movieTheater($id_movieTheater)
        {
                $this->id_movieTheater = $id_movieTheater;

                return $this;
        }

        /**
         * Get the value of total_tickets
         */ 
        public function getTotal_tickets()
        {
                return $this->total_tickets;
        }

        /**
         * Set the value of total_tickets
         *
         * @return  self
         */ 
        public function setTotal_tickets($total_tickets)
        {
                $this->total_tickets = $total_tickets;

                return $this;
        }

        /**
         * Get the value of tickets_sold
         */ 
        public function getTickets_sold()
        {
                return $this->tickets_sold;
        }

        /**
         * Set the value of tickets_sold
         *
         * @return  self
         */ 
        public function setTickets_sold($tickets_sold)
        {
                $this->tickets_sold = $tickets_sold;

                return $this;
        }

        /**
         * Get the value of ticket_price
         */ 
        public function getTicket_price()
        {
                return $this->ticket_price;
        }

        /**
         * Set the value of ticket_price
         *
         * @return  self
         */ 
        public function setTicket_price($ticket_price)
        {
                $this->ticket_price = $ticket_price;

                return $this;
        }
    }
?>