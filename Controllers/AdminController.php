<?php namespace Controllers;

use DAO\DAODB\MovieTheaterDao as MovieTheaterDAO;
use DAO\DAODB\MovieDao as MovieDao;
use Models\MovieTheater as MovieTheater;
use DAO\DAODB\ShowDao as ShowDao;
use PDOException as PDOException;


class AdminController{
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
        $this->allMT = array();
        $this->allShows = array();

    }

    public function chargeAllAndBack($msg=null){

        if($msg == "notAdmin"){
            $hp = new HomePageController();
            $hp->showListView();
        }else{
            require_once(VIEWS_PATH."validate-session.php");
            require_once("Views/administration.php");
        }
    }

    public function checkAdmin(){

        if($_SESSION["loggedUser"]->getGroup() == 1){
            $this->chargeAllAndBack(null);    //hay que hacer un userController para hacer esta verificacion
        }else{
            $this->chargeAllAndBack("notAdmin");
        }
    }

    public function showAdminMovieTheater(){

        try{
            $this->setAllMT($this->movieTheaterDao->readAll());
        }catch(PDOException $e){
            $pdoEx = $e;
        }
        require_once("Views/adminMT.php");
    }

    public function showAdminShows(){
        try {
            $this->setAllShows($this->showDao->readAll());
            $this->setAllMT($this->movieTheaterDao->readAll());
        }catch(PDOException $e){
            $pdoEx = $e;
        }
        require_once("Views/adminShow.php");
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
}


?>