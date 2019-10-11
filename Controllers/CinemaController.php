<?php namespace Controllers;

use DAO\CinemaRepository as CinemaRepository;
use Models\Cinema as Cinema;

class CinemaController{
    public function newCinema(){
        if($_POST){
            $cinema = new Cinema($_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value']);
            $cRepo = new CinemaRepository();
            $cRepo->add($cinema);
        }
    }
}



?>