<?php namespace Controllers;

use DAO\DAODB\CinemaDao as CinemaDao;
use Models\Cinema as Cinema;
use DAO\DAODB\MovieDao as MovieDao;

class CinemaController{

    private $cinemaDao;

    function __construct(){
        $this->cinemaDao = new CinemaDao();
    }

    public function allMovies(){
        $movieList = new MovieDao();
        $movieList->retrieveDataApi();
        $allMovies = $movieList->readAll();
        if(!is_array($allMovies)){
            $movies = array($allMovies);
        }else{
            $movies = $allMovies;
        }
        return $movies;
    }

    public function allCines(){
        $cinemaDao = new CinemaDao();
        $cinemaList = $cinemaDao -> readAll();
        if(empty($cinemaList))
        {
            $cinemas = array();
        }else{
            if(!is_array($cinemaList)){
                $cinemas = array($cinemaList);
            }else{
                $cinemas = $cinemaList;
            }

        }
        return $cinemas;
    }

    public function adminCines(){
        $cinemaList = $this->allCines();
        $allMovies = $this->allMovies();
        if($_SESSION["loggedUser"]->getGroup() == 1){
            require_once("Views/adminCines.php");    //hay que hacer un userController para hacer esta verificacion
        }else{
            require_once("Views/home.php");
        }
    }

    public function addCine(){
        if($_POST){
            $cinemaList = $this->allCines();
            if($_POST['capacity']>0 && $_POST['ticket_value']>=0){
                $this->newCinema($_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value'],$_POST['available']);
                $msg = "Cine cargado con éxito";
                $cinemaList = $this->allCines();
                $allMovies = $this->allMovies();
                require_once("Views/adminCines.php");
            }else{
                $msg = "La capacidad y el valor del ticket debe ser mayor a 0";
                require_once("Views/adminCines.php");
            }
        }
    }

    public function modCine(){
        if($_POST){
            $cinemaList = $this->allCines();
            if($this->cinemaDao->read($_POST['id'])->getName() != $_POST['name']){
                if(!$this->exist($cinemaList,$_POST['name'])){
                    $this->cinemaDao->update($_POST['id'],$_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value'],$_POST['available']);
                }
            }else{
                $this->cinemaDao->update($_POST['id'],$_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value'],$_POST['available']);
            }
            $cinemaList = $this->allCines();
            require_once("Views/adminCines.php");
        }
    }

    public function bajaCine($id){
        $cinemaList = $this->allCines();
        if(is_array($id)){
            foreach($id as $aux){
                foreach($cinemaList as $value){
                    if($value->getId() == $aux){
                        if($value->getAvailable() == 0){
                            $value->setAvailable(1);
                            $this->cinemaDao->update($value->getId(),$value->getName(),$value->getAddress(),$value->getCapacity(),$value->getTicket_value(),$value->getAvailable());
                            $cinemaList = $this->allCines();
                        }else{
                            $value->setAvailable(0);
                            $this->cinemaDao->update($value->getId(),$value->getName(),$value->getAddress(),$value->getCapacity(),$value->getTicket_value(),$value->getAvailable());
                            $cinemaList = $this->allCines();
                        }
                    }
                }
            }
        }
        require_once("Views/adminCines.php");
    }


    public function newCinema($name,$address,$capacity,$ticket_value,$available){
        $cinemaList = $this->allCines();
        $cinemaDao = new CinemaDao();
        if(!$this->exist($cinemaList,$name)){
            $cinema = new Cinema($name,$address,$capacity,$ticket_value,$available);
            $cinemaDao->create($cinema);
        }
    }

    public function exist($listCinema,$name){
        foreach($listCinema as $values){
            if($values->getName() == $name){
                return true;
            }
        }
        return false;
    }

}



?>