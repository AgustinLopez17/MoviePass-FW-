<?php
    namespace Controllers;

    use DAO\DAODB\MovieDao as MovieDao;
    use DAO\DAODB\ShowDao as ShowDao;
    use DAO\DAODB\GenreDao as GenreDao;

    class GenreController{


        public function showGenreXId($id){
            $movieList = new MovieDao();

            $movieList->retrieveDataApi();

            $movies = $movieList->readAll();

            $showDao = new ShowDao();
            $allShows = $showDao->readAll();


            $allMovies = array();

            $genresList = $this->showGenres();


            foreach($allShows as $show){
                foreach($movies as $movie){
                    if(  ($show->getId_movie() == $movie->getId())){
                        foreach($movie->getGenres() as $genre){
                            if($id == $genre->getId_genre()){
                                if(!in_array($movie,$allMovies)){
                                    array_push($allMovies,$movie);
                                }
                            }
                        }
                    }
                }
            }
            include("Views/home.php");
        }

        public function showGenres(){
            $genres = new GenreDao();
            $genres->retrieveDataApi();
            $genresList = $genres->readAll();
            return $genresList;
        }


    }


?>