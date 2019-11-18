<?php namespace Controllers;

use DAO\DAODB\MovieTheaterDao as MovieTheaterDAO;
use Models\MovieTheater as MovieTheater;
use DAO\DAODB\ShowDao as ShowDao;
class AdminController{
    private $movieTheaterDao;
    private $showDao;
    private $allMT;

    public function __construct(){
        $this->movieTheaterDao = new MovieTheaterDAO();
        $this->showDao = new ShowDao();
        $this->allMT = array();
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
        $this->setAllMT($this->movieTheaterDao->readAll());
        require_once("Views/adminMT.php");
    }

    public function getAllMT()
    {
        return $this->allMT;
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