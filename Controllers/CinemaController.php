<?php namespace Controllers;

use DAO\CinemaRepository as CinemaRepository;
use Models\Cinema as Cinema;

class CinemaController{
    public function newCinema($name,$address,$capacity,$ticket_value,$available){
        //if($_POST){
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
        //}
    }

    public function modifyCinema($cinemaList,$id,$name,$address,$capacity,$ticket_value,$available){
        if($this->exist($cinemaList,$name)){
            $cinemaList[$id-1]->setName($name);
            $cinemaList[$id-1]->setAddress($address);
            $cinemaList[$id-1]->setCapacity($capacity);
            $cinemaList[$id-1]->setTicket_value($ticket_value);
            $cinemaList[$id-1]->setAvailable($available);
        }
        return $cinemaList;
    }

    public function exist($listCinema,$name){
        foreach($listCinema as $values){
            if($values->getName() == $name){
                return false;
            }
        }
        return true;
    }

}



?>