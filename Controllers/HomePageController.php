<?php
    namespace Controllers;

    use DAO\DAODB\UserDao as UserDao;
    use Models\User as User;
    use DAO\DAODB\MovieDao as MovieDao;
    use DAO\DAODB\ShowDao as ShowDao;
    use DAO\DAODB\GenreDao as GenreDao;
    use \DateTime;
    use PDOException as PDOException;

    class HomePageController
    {
        private $movieDao;
        private $allMovies;

        private $showDao;

        private $allGenres;
        private $genreDao;
        private $genre_x_movie;

        private $userDao;
        private $nowDate;

        public function __construct()
        {
            $this->userDao = new UserDao();


            $this->genreDao = new GenreDao();
            $this->allGenres = $this->showGenres();


            $this->movieDao = new MovieDao();
            $this->movieDao->retrieveDataApi();
            $this->allMovies = array();
            
            $this->showDao = new ShowDao();
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $this->nowDate = new DateTime(date('Y-m-d H:i:s'));
        }

        public function validateSession(){
            if(!isset($_SESSION['loggedUser'])){
                require_once(VIEWS_PATH."viewLogin.php");
                return false;
            }else{
                $user = $this->userDao->read($_SESSION['loggedUser']->getEmail());
                if($user){
                    if($user->getPass() != $_SESSION['loggedUser']->getPass() ){
                        require_once(VIEWS_PATH."viewLogin.php");
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return false;
                }
            }
        }

        public function Index($message = "")
        {
            if (!isset($_SESSION["loggedUser"])) {
                require_once(VIEWS_PATH."viewLogin.php");
            } else {
                $this->ShowListView();
            }
        }

        public function login($email, $password)
        {
            if (isset($email) && isset($password)) {
                try {
                    $user = $this->userDao->read($email);
                } catch (PDOException $e) {
                    $user = $e;
                }
                if ($user && ($password == $user->getPass())) {
                    $loggedUser = new User($user->getFirstName(), $user->getSurName(), $user->getDni(), $user->getEmail(), $user->getPass(), $user->getGroup());
                    $_SESSION["loggedUser"] = $loggedUser;
                    $this->ShowListView();
                } else {
                    $datosIncorrectos = true;
                    require_once(VIEWS_PATH."viewLogin.php");
                }
            } else {
                $huboProblema = true;
                require_once(VIEWS_PATH."viewLogin.php");
            }
        }
        
        public function showListView($filter = null)
        {
            if ($this->validateSession()) {
                try {
                    if (isset($filter)) {
                        if (!strstr($filter, '-')) {
                            $this->setAllMovies($this->movieDao->readMoviesByGenre($filter));
                        } else {
                            $this->setAllMovies($this->movieDao->readMoviesByDate($filter));
                        }
                    } else {
                        $this->setAllMovies($this->movieDao->readMoviesIfShow());
                    }
                } catch (PDOException $e) {
                    $this->allMovies = $e;
                }
                include("Views/home.php");
            }
        }
        
        public function showGenreMovie($id_movie)
        {
            try {
                $genres = $this->genreDao->readByMovieId($id_movie);
            } catch (PDOException $e) {
                $genres = null;
            }
            if (!is_array($genres)) {
                $genres = array($genres);
            }
            return $genres;
        }
        
        public function showGenres()
        {
            try {
                $this->genreDao->retrieveDataApi();
                $genresList = $this->genreDao->readAll();
            } catch (PDOException $e) {
                $genresList = null;
            }
            return $genresList;
        }

        public function exit()
        {
            unset($_SESSION["loggedUser"]);
            include_once("Views/viewLogin.php");
        }
        
        public function setAllMovies($allMovies)
        {
            if ($allMovies) {
                if (!is_array($allMovies)) {
                    $this->allMovies = array($allMovies);
                } else {
                    $this->allMovies = $allMovies;
                }
            }
        }
        
    }
