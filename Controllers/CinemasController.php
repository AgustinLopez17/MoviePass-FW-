<?php namespace Controllers;

use DAO\DAODB\CinemaDao as CinemaDao;
use Models\Cinema as Cinema;

class CinemasController{
    private $cinemaDao;
    private $allCinemas;
    public function __contruct(){
        $this->cinemaDao = new CinemaDao();
    }

    public function seeAllCinemas($id_movieTheater){
        $allCinemas = $this->cinemaDao->readFromMovieTheater($id_movieTheater);
    }

}