<?php namespace Controllers;

use DAO\DAODB\CinemaDao as CinemaDao;
use Models\Cinema as Cinema;
use DAO\DAODB\MovieDao as MovieDao;
use DAO\DAODB\ShowDao as ShowDao;
use Controllers\HomePageController as HomePageController;

class CinemaController{

    private $cinemaDao;
    private $movieDao;
    private $showDao;

    function __construct(){
        $this->cinemaDao = new CinemaDao();
        $this->movieDao = new MovieDao();
        $this->showDao = new ShowDao();
    }

    public function chargeAllAndBack($msg=null){

        if($msg == "notAdmin"){
            $hp = new HomePageController();
            $hp->showListView();
        }else{
            require_once(VIEWS_PATH."validate-session.php");
            require_once("Views/adminCines.php");
        }
    }

    public function allMovies(){
        $this->movieDao->retrieveDataApi();
        $allMovies = $this->movieDao->readAll();
        if(!is_array($allMovies)){
            $movies = array($allMovies);
        }else{
            $movies = $allMovies;
        }
        return $movies;
    }

    public function allCines(){
        $cinemaList = $this->cinemaDao -> readAll();
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

        if($_SESSION["loggedUser"]->getGroup() == 1){
            $this->chargeAllAndBack(null);    //hay que hacer un userController para hacer esta verificacion
        }else{
            $this->chargeAllAndBack("notAdmin");
        }
    }

    public function addCine($name,$address,$capacity,$ticket_value,$available){
            $cinemaList = $this->allCines();
            if($capacity>0 && $ticket_value>=0){
                $msg = $this->newCinema($name,$address,$capacity,$ticket_value,$available);
                $this->chargeAllAndBack($msg);
            }else{
                $this->chargeAllAndBack("La capacidad y el valor del ticket debe ser mayor a 0");
            }
    }

    public function modCine($id,$name,$address,$capacity,$ticket_value,$available){
            $cinemaList = $this->allCines();
            if($this->cinemaDao->read($id)->getName() != $name){
                if(!$this->exist($cinemaList,$name)){
                    $this->cinemaDao->update($id,$name,$address,$capacity,$ticket_value,$available);
                    $this->chargeAllAndBack("Modificado con éxito");
                }
            }else{
                $this->cinemaDao->update($id,$name,$address,$capacity,$ticket_value,$available);
                $this->chargeAllAndBack("El nombre ya existe");
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
                            //$cinemaList = $this->allCines();
                        }else{
                            $value->setAvailable(0);
                            $this->cinemaDao->update($value->getId(),$value->getName(),$value->getAddress(),$value->getCapacity(),$value->getTicket_value(),$value->getAvailable());
                            //$cinemaList = $this->allCines();
                        }
                    }
                }
            }
        }
        $this->chargeAllAndBack();
    }


    public function newCinema($name,$address,$capacity,$ticket_value,$available){
        $cinemaList = $this->allCines();
        if(!$this->exist($cinemaList,$name)){
            $cinema = new Cinema($name,$address,$capacity,$ticket_value,$available);
            $this->cinemaDao->create($cinema);
            return "Cine cargado con éxito";
        }else{
            return "Ya existe un cine con ese nombre";
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