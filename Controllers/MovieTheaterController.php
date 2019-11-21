<?php namespace Controllers;

use DAO\DAODB\MovieTheaterDao as MovieTheaterDao;
use Models\MovieTheater as MovieTheater;
use DAO\DAODB\MovieDao as MovieDao;
use DAO\DAODB\ShowDao as ShowDao;
use Controllers\HomePageController as HomePageController;
use PDOException;
class MovieTheaterController{

    private $MovieTheaterDao;
    private $movieDao;
    private $showDao;
    private $allMT;

    function __construct(){
        $this->MovieTheaterDao = new MovieTheaterDao();
        $this->movieDao = new MovieDao();
        $this->showDao = new ShowDao();
        $this->allMT = array();
    }

    public function chargeAllAndBack($msg=null){

        if($msg == "notAdmin"){
            $hp = new HomePageController();
            $hp->showListView();
        }else{
            require_once(VIEWS_PATH."validate-session.php");
            $this->allMT = $this->allMTs();
            require_once("Views/adminMT.php");
        }
    }

    public function allMTs(){
        try{
            $MTList = $this->MovieTheaterDao -> readAll();
        }catch(PDOException $e){
            $msg = $e;
            return $msg;
        }

        if(!$MTList){
            return null;
        }
        if(empty($MTList))
        {
            $MTs = array();
        }else{
            if(!is_array($MTList)){
                $MTs = array($MTList);
            }else{
                $MTs = $MTList;
            }

        } 
        return $MTs;
    }



    public function addMT($name,$address,$numberOfCinemas,$priceDefault,$available){
        $MTs = $this->allMTs();
        $msg = $this->newMT($name,$address,$available,$numberOfCinemas,$priceDefault);
        $this->chargeAllAndBack($msg);
    }

    public function modMT($id,$name,$address,$available,$numberOfCinemas){
            $MTList = $this->allMTs();
            if($this->MovieTheaterDao->read($id)->getName() != $name){
                if(!$this->exist($MTList,$name)){
                    try{
                        $this->MovieTheaterDao->update($id,$name,$address,$available,$numberOfCinemas);
                    }catch(PDOException $e){
                        $this->chargeAllAndBack($e);
                    }
                    $this->chargeAllAndBack('El cine se modifico correctamente');
                }
            }else{
                $this->MovieTheaterDao->update($id,$name,$address,$available,$numberOfCinemas);
                $this->chargeAllAndBack("El nombre ya existe");
            }
    }

    public function downMT($id){
        $MTList = $this->allMTs();
        if(is_array($id)){
            foreach($id as $aux){
                foreach($MTList as $value){
                    if($value->getId() == $aux){
                        if($value->getAvailable() == 0){
                            $value->setAvailable(1);
                            $this->MovieTheaterDao->update($value->getId(),$value->getName(),$value->getAddress(),$value->getAvailable(),$value->getNumberOfCinemas());
                            //$cinemaList = $this->allCines();
                        }else{
                            $value->setAvailable(0);
                            $this->MovieTheaterDao->update($value->getId(),$value->getName(),$value->getAddress(),$value->getAvailable(),$value->getNumberOfCinemas());
                            //$cinemaList = $this->allCines();
                        }
                    }
                }
            }
        }
        $this->chargeAllAndBack();
    }


    public function newMT($name,$address,$available,$numberOfCinemas,$priceDefault){
        $MTList = $this->allMTs();
        if(!isset($MTList)  ||  !$this->exist($MTList,$name)){
            $MT = new MovieTheater($name,$address,$available,$numberOfCinemas);
            try{
                $this->MovieTheaterDao->createWithCinemas($MT,$priceDefault);
            }catch(PDOException $e){
                $msg = $e;
                return $msg;
            }
            return "Cine cargado con éxito";
        }else{
            return "Ya existe un cine con ese nombre";
        }
    }

    public function exist($MTList,$name){
        if(!$MTList){
            return false;
        }
        foreach($MTList as $values){
            if($values->getName() == $name){
                return true;
            }
        }
        return false;
    }

}



?>