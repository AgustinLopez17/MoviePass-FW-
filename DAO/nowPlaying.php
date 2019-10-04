<?php

use DAO\MovieRepository as MovieRepository;
use Models\Movie as Movie;

$movieList = new MovieRepository();
$cont = 0;
$response = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=bf47253392bc9b0762556be7b49ab033");
$array = ($response) ? json_decode($response, true) : array();
foreach($array as $value){
  if(is_array($value)){
    foreach($value as $aux){
      if(is_array($aux)){
        if(!$movieList->getById($aux['id'])){
          $data = file_get_contents("https://api.themoviedb.org/3/movie/".$aux['id']."?language=en-US&api_key=bf47253392bc9b0762556be7b49ab033");
          $movie = ($data) ? json_decode($data, true) : array();
          $newMovie = new Movie($movie["id"],$movie["title"],$movie["runtime"],$movie["original_language"],$movie["poster_path"],$movie['overview']);
          $movieList->add($newMovie);
        }
      }
    }
  }
}

?>