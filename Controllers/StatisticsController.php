<?php
    namespace Controllers;
    use DAO\DAODB\MovieTheaterDao;
    use DAO\DAODB\ShowDao;
    use DAO\DAODB\MovieDao;
    use DAO\DAODB\PurchaseDao;
    use DAO\DAODB\UserDao;
    use DateTime;

    class StatisticsController{
        private $movieTheaterDao;
        private $showDao;
        private $movieDao;
        private $purchaseDao;
        private $userDao;
        private $allMT;
        private $allShows;
        private $allMovies;
        public function __construct(){
            $this->movieTheaterDao = new MovieTheaterDao();
            $this->showDao = new ShowDao();
            $this->movieDao = new MovieDao();
            $this->purchaseDao = new PurchaseDao();
            $this->userDao = new UserDao();
            $this->setAllShows($this->showDao->readAll());
            $this->setAllMT($this->movieTheaterDao->readAll());
            $this->setAllMovies($this->movieDao->readAllMoviesIfShow());
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

        public function salesOfMT($id_mt){
            if($this->validateSession()){
                try {
                    $salesOfMt = $this->showDao->salesOfMT($id_mt); // para ver la cantidad de tickets vendidos $salesOfMt->getTickets_sold();
                    $earningsOfMt = $this->purchaseDao->readEarningsOfMT($id_mt);
                }catch(PDOException $e){
                    $pdoEx = $e;
                }
                $msg = "Tickets sold: ".$salesOfMt->getTickets_sold()." - Total movietheater profit: ".$earningsOfMt->getAmount();
                require_once("Views/viewStatistics.php");
            }
        }

        public function salesOfMovie($id_movie){
            if($this->validateSession()){
                try {
                    $salesOfMovie = $this->showDao->salesOfMovie($id_movie); // para ver la cantidad de tickets vendidos $salesOfMt->getTickets_sold();
                    $earningsOfMovie = $this->purchaseDao->readEarningsOfMovie($id_movie);
                }catch(PDOException $e){
                    $pdoEx = $e;
                }
                $msg = "Tickets of movie sold: ".$salesOfMovie->getTickets_sold()." - Total movie profit: ".$earningsOfMovie->getAmount();
                require_once("Views/viewStatistics.php");
            }
        }

        public function salesBetweenDates($date1,$date2){
            if($this->validateSession()){
                try {
                    $allPurchases = $this->purchaseDao->readAll();
                }catch(PDOException $e){
                    $pdoEx = $e;
                }
                $minDate = new DateTime($date1);
                $maxDate = new DateTime($date2);
                $earning = 0;
                foreach($allPurchases as $value){
                    $date = new DateTime($value->getDate_purchase());
                    if($date >= $minDate && $date <= $maxDate){
                        $earning = $earning + $value->getAmount();
                    }
                }
                $msg = "Total profit between".$minDate->format('y-m-d')." and ".$maxDate->format('y-m-d')." : ".$earning;
                require_once("Views/viewStatistics.php");
            }
        }





        public function earnOfMT($id_mt){

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