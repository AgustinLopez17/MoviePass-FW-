<?php namespace Controllers;

use DAO\DAODB\CinemaDao as CinemaDao;
use Models\Cinema as Cinema;
use PDOException;
class CinemasController{
    private $cinemaDao;
    private $allCinemas;
    public function __construct(){
        $this->cinemaDao = new CinemaDao();
    }

    public function seeCinemas($id_movieTheater,$nameOfMT,$msg=null){
        try{
            $this->allCinemas = $this->cinemaDao->readFromMovieTheater($id_movieTheater);
        }catch(PDOException $e){
            $msg = $e;
        }
        require_once("Views/adminCinema.php");
    }

    public function addCinema($idMT,$nameOfMT=null,$numberCinema,$capacity,$ticketValue,$available){
        $cinema = new Cinema($idMT,$numberCinema,$capacity,$ticketValue,$available);
        try{
            $this->cinemaDao->create($cinema);
            $msg = "Cinema creado con éxito";
        }catch(PDOException $e){
            $msg = $e;
        }
        $this->seeCinemas($idMT,$nameOfMT,$msg);
    }

    public function modCinema($idMT,$idCinema,$nameOfMT=null,$capacity,$ticketValue,$available){
        try{
            $this->cinemaDao->update($idCinema,$capacity,$ticketValue,$available);
            $msg = "Cinema actualizado con éxito";
        }catch(PDOException $e){
            $msg = $e;
        }    
        $this->seeCinemas($idMT,$nameOfMT,$msg);
    }

    public function setAvaiableCinema($nameOfMT,$idMT,$idCinema){
        if(is_array($idCinema)){
            foreach($idCinema as $aux){
                try {
                    foreach ($this->cinemaDao->readFromMovieTheater($idMT) as $value) {
                        if ($value->getIdCinema() == $aux) {
                            if ($value->getAvailable() == 0) {
                                $value->setAvailable(1);
                                $this->cinemaDao->update($value->getIdCinema(), $value->getCapacity(), $value->getTicket_value(), $value->getAvailable());
                                $msg = 'Dado de alta con éxito';
                            } else {
                                $value->setAvailable(0);
                                $this->cinemaDao->update($value->getIdCinema(), $value->getCapacity(), $value->getTicket_value(), $value->getAvailable());
                                $msg = 'Dado de baja con éxito';
                            }
                        }
                    }
                }catch(PDOException $e){
                    $msg = $e;
                }
            }
        }
        $this->seeCinemas($idMT,$nameOfMT,$msg);
    }

}