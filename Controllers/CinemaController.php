<?php namespace Controllers;

use DAO\CinemaRepository as CinemaRepository;
use Models\Cinema as Cinema;

class CinemaController{

    public function adminCines(){
        $cinemaRepository = new CinemaRepository();
        $cinemaList = $cinemaRepository->getAll();
        require_once("Views/adminCines.php");
    }

    public function addCine(){
        if($_POST){
            $this->newCinema($_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value'],$_POST['available']);
            $cRepo = new CinemaRepository();
            $cinemaList = $cRepo->getAll();
            require_once("Views/adminCines.php");
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


    public function newCinema($name,$address,$capacity,$ticket_value,$available){
        $cRepo = new CinemaRepository();
        $listCinema = $cRepo->getAll();
        if($this->exist($listCinema,$name)){
            $id;
            
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