<?php namespace Controllers;

use DAO\DAODB\MovieTheaterDao as MovieTheaterDao;
use Models\MovieTheater as MovieTheater;
use DAO\DAODB\MovieDao as MovieDao;
use DAO\DAODB\ShowDao as ShowDao;
use DAO\DAODB\UserDao;
use Controllers\HomePageController as HomePageController;
use PDOException;
class MovieTheaterController{
    private $userDao;
    private $MovieTheaterDao;
    private $movieDao;
    // private $showDao;
    private $allMT;

    function __construct(){
        $this->userDao = new UserDao();
        $this->MovieTheaterDao = new MovieTheaterDao();
        $this->movieDao = new MovieDao();
        // $this->showDao = new ShowDao();
        $this->allMT = array();
    }

    public function validateSession(){
        if(!isset($_SESSION['loggedUser'])){
            require_once(VIEWS_PATH."viewLogin.php");
            return false;
        }else{
            $user = $this->userDao->read($_SESSION['loggedUser']->getEmail() );
            if($user){
                if($user->getPass() != $_SESSION['loggedUser']->getPass() || $user->getGroup() == 0){
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
        if ($this->validateSession()) {
            if ($msg == "notAdmin") {
                $hp = new HomePageController();
                $hp->showListView();
            } else {
                $this->allMT = $this->allMTs();
                require_once("Views/adminMT.php");
            }
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



    public function addMT($name,$address,$numberOfCinemas,$capacityDefault,$priceDefault,$available){
        $MTs = $this->allMTs();
        $msg = $this->newMT($name,$address,$available,$numberOfCinemas,$priceDefault,$capacityDefault);
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
                    $this->chargeAllAndBack('The movietheater was modified correctly');
                }
            }else{
                $this->MovieTheaterDao->update($id,$name,$address,$available,$numberOfCinemas);
                $this->chargeAllAndBack("The name already exists");
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


    public function newMT($name,$address,$available,$numberOfCinemas,$priceDefault,$capacityDefault){
        $MTList = $this->allMTs();
        if(!isset($MTList)  ||  !$this->exist($MTList,$name)){
            $MT = new MovieTheater($name,$address,$available,$numberOfCinemas);
            try{
                $this->MovieTheaterDao->createWithCinemas($MT,$priceDefault,$capacityDefault);
            }catch(PDOException $e){
                $msg = $e;
                return $msg;
            }
            return "MovieTheater loaded successfully";
        }else{
            return "There is already a movie theater with that name";
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