<?php namespace Controllers;

    use DAO\MovieRepository as MovieRepository;

    class MovieController{

        public function showListView(){
            $movieList = new MovieRepository();
            $movieList->retrieveDataApi();
            $allMovies = $movieList->GetAll();
            include("Views/home.php");
        }

    }




?>