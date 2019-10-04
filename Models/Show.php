<?php

    namespace Models;

    class Show{
        private $day;
        private $hour;
    
    public function __construct($day, $hour){
        $this->day = $day;
        $this->hour = $hour; 
    }
    
        public function getDay()
        {
                return $this->day;
        }

        public function setDay($day)
        {
                $this->day = $day;

                return $this;
        }

        public function getHour()
        {
                return $this->hour;
        }

        public function setHour($hour)
        {
                $this->hour = $hour;

                return $this;
        }
    }
?>