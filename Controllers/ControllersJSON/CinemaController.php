<?php namespace Controllers;

use DAO\CinemaRepository as CinemaRepository;
use Models\Cinema as Cinema;

use DAO\MovieRepository as MovieRepository;

class CinemaController{

    public function adminCines(){
        $cinemaRepository = new CinemaRepository();
        $cinemaList = $cinemaRepository->getAll();
        if($_SESSION["loggedUser"]->getGroup() == 1){
            $movieList = new MovieRepository();
            $movieList->retrieveDataApi();
            $allMovies = $movieList->GetAll();
            require_once("Views/adminCines.php");    //hay que hacer un userController para hacer esta verificacion
        }else{
            $movieList = new MovieRepository();
            $movieList->retrieveDataApi();
            $allMovies = $movieList->GetAll();
            require_once("Views/home.php");
        }
    }

    public function addCine(){
        if($_POST){

            if($_POST['capacity']>0 && $_POST['ticket_value']>=0){
                $this->newCinema($_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value'],$_POST['available']);
                $msg = "Cine cargado con éxito";
                $cRepo = new CinemaRepository();
                $cinemaList = $cRepo->getAll();
                require_once("Views/adminCines.php");
            }else{
                $cRepo = new CinemaRepository();
                $cinemaList = $cRepo->getAll();
                $msg = "La capacidad y el valor del ticket debe ser mayor a 0";
                require_once("Views/adminCines.php");
            }
        }
    }

    public function modCine(){
        if($_POST){
            $cRepo = new CinemaRepository();
            $cinemaList = $cRepo->getAll();
            $newList = $this->modifyCinema($cinemaList,$_POST['id'],$_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value'],$_POST['available']);
            $cRepo->modifyList($newList);
            require_once("Views/adminCines.php");
        }
    }

    public function bajaCine($id){
        $cRepo = new CinemaRepository();
        $cinemaList = $cRepo->getAll();
        if(is_array($id)){
            foreach($id as $aux){
                foreach($cinemaList as $value){
                    if($value->getId() == $aux){
                        if($value->getAvailable() == 0){
                            $value->setAvailable(1);
                            $newList = $this->modifyCinema($cinemaList,$value->getId(),$value->getName(),$value->getAddress(),$value->getCapacity(),$value->getTicket_value(),$value->getAvailable());
                            $cRepo->modifyList($newList);
                        }else{
                            $value->setAvailable(0);
                            $newList = $this->modifyCinema($cinemaList,$value->getId(),$value->getName(),$value->getAddress(),$value->getCapacity(),$value->getTicket_value(),$value->getAvailable());
                            $cRepo->modifyList($newList);
                        }
                    }
                }
            }
        }
        require_once("Views/adminCines.php");
    }


    public function newCinema($name,$address,$capacity,$ticket_value,$available){
        $cRepo = new CinemaRepository();
        $listCinema = $cRepo->getAll();
        if(!$this->exist($listCinema,$name)){
            $id = 0;
            foreach($listCinema as $values){
                $id=$values->getId();
            }
            $cinema = new Cinema($id+1,$name,$address,$capacity,$ticket_value,$available);
            $cRepo->add($cinema);
        }
    }

    public function modifyCinema($cinemaList,$id,$name,$address,$capacity,$ticket_value,$available){
        $cinemaList[$id-1]->setAddress($address);
        $cinemaList[$id-1]->setCapacity($capacity);
        $cinemaList[$id-1]->setTicket_value($ticket_value);
        $cinemaList[$id-1]->setAvailable($available);
        if(!$this->exist($cinemaList,$name)){
            $cinemaList[$id-1]->setName($name);
        }
        return $cinemaList;
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