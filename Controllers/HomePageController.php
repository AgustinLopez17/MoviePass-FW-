<?php
    namespace Controllers;

    use DAO\DAODB\UserDao as UserDao;
    use Models\User as User;
    use DAO\DAODB\MovieDao as MovieDao;
    use DAO\DAODB\ShowDao as ShowDao;
    use DAO\DAODB\GenreDao as GenreDao;
    use \DateTime;

    class HomePageController
    {
        private $movieDao;
        private $allMovies;
        private $showDao;
        private $genresList;
        private $genreDao;
        private $genre_x_movie;
        private $userDao;
        private $nowDate;

        public function __construct(){
            $this->userDao = new UserDao();
            $this->genreDao = new GenreDao();
            $this->genresList = $this->showGenres();
            $this->movieDao = new MovieDao();
            $this->movieDao->retrieveDataApi();
            $this->allMovies = array();
            $this->showDao = new ShowDao();
            date_default_timezone_set('America/Argentina/Buenos_Aires'); 
            $this->nowDate = new DateTime(date('Y-m-d H:i:s'));
        }


        public function login($email,$password)
        {
            if(isset($email) && isset($password)){
                $user = $this->userDao->read($email);
                if($user && ($password == $user->getPass())){
                    $loggedUser = new User($user->getFirstName(),$user->getSurName(),$user->getDni(),$user->getEmail(),$user->getPass(),$user->getGroup());
                    $_SESSION["loggedUser"] = $loggedUser;
                    $this->ShowListView();
                }else{
                    $datosIncorrectos = true;
                    require_once(VIEWS_PATH."viewLogin.php");
                }
            }else{
                $huboProblema = true;
                require_once(VIEWS_PATH."viewLogin.php");
            }
            
        }     


        // public function showListView($something = null){ //something es el filtro que se aplicaría para ver las peliculas      
        //     require_once(VIEWS_PATH."validate-session.php"); 
        //     foreach($this->showDao->readAll() as $show){
        //         foreach($this->movieDao->readAll() as $movie){
        //             if($show->getId_movie() == $movie->getId() ){
        //                 if(isset($something)){ 
        //                     if(!strstr($something,'-') &&  $show->getDate() >= $this->nowDate){
        //                         foreach($movie->getGenres() as $genre){
        //                             if($something == $genre->getId_genre()){
        //                                 if(!in_array($movie,$this->allMovies)){
        //                                     array_push($this->allMovies,$movie);
        //                                 }
        //                             }
        //                         }
        //                     }else{
        //                         if($something == $show->getDate()->format("Y-m-d")){
        //                             if(!in_array($movie,$this->allMovies)){
        //                                 array_push($this->allMovies,$movie);
        //                             }
        //                         }
        //                     }
        //                 }else{
        //                     if(!in_array($movie,$this->allMovies) && $show->getDate() >= $this->nowDate){
        //                         array_push($this->allMovies,$movie);
        //                     }
        //                 }
        //             }
        //         }
        //     }
            
        // }


        public function showListView($filter = null){
            if(isset($filter)){
                if(!strstr($filter,'-')){
                    $this->setAllMovies($this->movieDao->readMoviesByGenre($filter));
                }else{
                    $this->setAllMovies($this->movieDao->readMoviesByDate($filter));
                }
            }else{
                $this->setAllMovies($this->movieDao->readMoviesIfShow());
            }
            include("Views/home.php");
        }

        public function showGenreMovie($id_movie){
            $genres = $this->genreDao->readByMovieId($id_movie);
            if(!is_array($genres)){
                $genres = array($genres);
            }
            return $genres;
        }

        public function showGenres(){
            $this->genreDao->retrieveDataApi();
            $genresList = $this->genreDao->readAll();
            return $genresList;
        }

        public function exit(){
            unset($_SESSION["loggedUser"]);
            include_once("Views/viewLogin.php");
        }

        public function setAllMovies($allMovies){
            if($allMovies){
                if(!is_array($allMovies)){
                    $this->allMovies = array($allMovies);
                }else{
                    $this->allMovies = $allMovies;
                }
            }
        }




    }

?>