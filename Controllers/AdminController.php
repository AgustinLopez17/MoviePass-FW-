<?php namespace Controllers;

use DAO\DAODB\MovieTheaterDao as MovieTheaterDAO;
use DAO\DAODB\MovieDao as MovieDao;
use Models\MovieTheater as MovieTheater;
use DAO\DAODB\ShowDao as ShowDao;
use DAO\DAODB\UserDao as UserDao;
use PDOException as PDOException;


class AdminController{
    private $userDao;
    private $movieTheaterDao;
    private $showDao;
    private $movieDao;
    private $allMT;
    private $allShows;
    private $allMovies;

    public function __construct(){
        $this->movieTheaterDao = new MovieTheaterDAO();
        $this->showDao = new ShowDao();
        $this->movieDao = new MovieDao();
        $this->userDao = new UserDao();
        $this->allMT = array();
        $this->allShows = array();
        $this->allMovies = array();
    }

    public function validateSession(){
        if(!isset($_SESSION['loggedUser'])){
            require_once(VIEWS_PATH."viewLogin.php");
            return false;
        }else{
            $user = $this->userDao->read($_SESSION['loggedUser']->getEmail());
            if($user){
                if($user->getPass() != $_SESSION['loggedUser']->getPass() || $user->getGroup() == 0 ){
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

    public function chargeAllAndBack($msg=null){
        if($msg == "notAdmin"){
            $hp = new HomePageController();
            $hp->showListView();
        }else{
            
            require_once("Views/administration.php");
        }
    }

    public function checkAdmin(){
        if($this->validateSession()){
            if ($_SESSION["loggedUser"]->getGroup() == 1) {
                $this->chargeAllAndBack(null);    //hay que hacer un userController para hacer esta verificacion
            } else {
                $this->chargeAllAndBack("notAdmin");
            }
        }
    }

    public function showAdminMovieTheater(){
        if($this->validateSession()){
            try{
                $this->setAllMT($this->movieTheaterDao->readAll());
            }catch(PDOException $e){
                $pdoEx = $e;
            }
            require_once("Views/adminMT.php");
        }
    }

    public function showAdminShows(){
        if($this->validateSession()){
            try {
                $this->setAllShows($this->showDao->readAll());
                $this->setAllMT($this->movieTheaterDao->readAll());
            }catch(PDOException $e){
                $pdoEx = $e;
            }
            require_once("Views/adminShow.php");
        }
    }

    public function showStatistics(){
        if($this->validateSession()){
            try {
                $this->setAllShows($this->showDao->readAll());
                $this->setAllMT($this->movieTheaterDao->readAll());
                $this->setAllMovies($this->movieDao->readAllMoviesIfShow());
            }catch(PDOException $e){
                $pdoEx = $e;
            }
            require_once("Views/viewStatistics.php");
        }
    }



    public function getAllMT()
    {
        return $this->allMT;
    }

    public function setAllShows($allShows){
        if(isset($allShows) && !is_array($allShows)){
            $this->allShows = array($allShows);
        }else if(is_array($allShows)){
            $this->allShows = $allShows;
        }
    }

    public function setAllMT($allMT)
    {
        if(isset($allMT) && !is_array($allMT)){
            $this->allMT = array($allMT);
        }else if(is_array($allMT)){
            $this->allMT = $allMT;
        }
    }

    public function setAllMovies($allMovies)
    {
        if(isset($allMovies) && !is_array($allMovies)){
            $this->allMovies = array($allMovies);
        }else if(is_array($allMovies)){
            $this->allMovies = $allMovies;
        }
        return $this;
    }
}


?>