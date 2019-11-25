<?php
    namespace Controllers;
    use DAO\DAODB\UserDao as UserDao;
    use DAO\DAODB\ShowDao as ShowDao;
    use Models\Show as Show;
    use DAO\DAODB\CinemaDao as CinemaDao;
    use DAO\DAODB\MovieTheaterDao as MovieTheaterDao;
    use DAO\DAODB\MovieDao as MovieDao;
    use \DateTime;
    use PDOException;
    class ShowController{
        private $userDao;
        private $showDao;
        private $cinemaDao;
        private $movieDao;
        private $movieTheaterDao;
        private $allMT;
        private $allShows;


        function __construct(){
            $this->userDao = new UserDao();
            $this->showDao = new ShowDao();
            $this->cinemaDao = new CinemaDao();
            $this->movieDao = new MovieDao();
            $this->movieTheaterDao = new MovieTheaterDao();
            $this->allMT = array();
            $this->allShows = array();
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

        public function goBack($msg = null){
            if($this->validateSession()){
                $this->chargeMT();
                $this->chargeShows();
                require_once("Views/adminShow.php");
            }
        }

        public function converseArray($dbShows){
            if(!is_array($dbShows)){
                $shows = array($dbShows);
            }else{
                $shows = $dbShows;
            }
            return $shows;
        }

        public function chargeMT(){
            try{
                $this->setAllMT($this->movieTheaterDao->readAll());
            }catch(PDOException $e){
                $pdoEx = $e;
            }
        }

        public function chargeShows(){
            try{
                $this->setAllShows($this->showDao->readAll());
            }catch(PDOException $e){
                $pdoEx = $e;
            }
        }

        public function verifyMovieTheater($id_MT,$id_movie,$date){
            $objDate = new DateTime($date);
            $nowDate = new DateTime(date('Y-m-d'));
            try{
                $dbShows = $this->showDao->readByMovieAndDate($id_movie,$objDate);//buscamos si el show existe en la fecha que se desea poner
                $MT = $this->movieTheaterDao->read($id_MT);
                $allCinemas = $this->cinemaDao->readFromMovieTheater($id_MT);
            }catch(PDOException $e){
                $this->goBack($e);
            }
            if($dbShows != "false"    &&  $objDate >= $nowDate){//en caso de existir el show y que la fecha ingresada sea mayor o igual al dia de hoy
                $shows = $this->converseArray($dbShows);//convertimos en array en caso de que en ese dia exista mas de un show igual
                if($id_MT == $shows[0]->getId_movieTheater()){ // verificamos que el show que se quiere agregar sea del mismo cine, en caso de no serlo, no seria posible agregarlo debido a que eso significaria que el show ya lo posee otro cine
                    if ($this->validateSession()) {
                        include("Views/selectCinema.php");
                    }
                }else{
                    $this->goBack("Movie already booked by another cinema");
                }
            }else if($objDate >= $nowDate){ //en caso de que la fecha ingresada sea mayor y no exista el show en ninguna otra fecha
                if ($this->validateSession()) {
                    include("Views/selectCinema.php");
                }
            }else{
                $this->goBack("Date after current");
            }
        }

        public function verifyHour($id_cinema,$id_MT,$id_movie,$date,$time){
            $objDate = new DateTime($date);
            try{
                $inDisplay = $this->showDao->readByMTAndDate($id_MT,$objDate);
                $cinema = $this->cinemaDao->read($id_cinema);
            }catch(PDOException $e){
                $this->goBack($e);
            }
            $movieTime = $this->timeOfMovie($id_movie);
            $aux = $date . " " . $time;
            $newDate = new DateTime($aux);
            $newShow = new Show($aux, $id_cinema, $id_movie, $id_MT, $cinema->getCapacity(), 0, $cinema->getTicket_value());
            if ($inDisplay != "false" && $this->showDao->readAll()) {
                $shows = $this->converseArray($inDisplay);
                $validation = $this->checkAvailableTime($shows, $newDate, $movieTime);
                if ($validation) {
                    try {
                        $this->showDao->create($newShow);
                    } catch (PDOException $e) {
                        $this->goBack($e);
                    }
                    $this->goBack("Successfully added");
                } else {
                    $this->goBack("It was not added because it intersects with another schedule");
                }
            } else {
                try {
                    $this->showDao->create($newShow);
                } catch (PDOException $e) {
                    $this->goBack($e);
                }
                $this->goBack("It was added successfully. The movie did not exist in another cinema");
            }
        }


        public function checkAvailableTime($shows, $newDate, $movieTime){
            $aux = new DateTime($newDate->format("Y-m-d H:i"));
            $newEndTime = $aux->modify($movieTime);
            foreach($shows as $value){
                $aux2 = new DateTime($value->getDate()->format("Y-m-d H:i"));
                $oldEndTime = $aux2->modify($movieTime);
                if( ($oldEndTime > $newDate  && $newEndTime > $value->getDate()) || ($newDate == $value->getDate()) ){
                    return false;
                }
            }
            return true;
        }

        public function timeOfMovie($id_movie){ //Esta funcion devuelve la duracion de la pelicula lista para añadirla a un horario
            try {
                $movies = $this->movieDao->readAll();
            }catch(PDOException $e){
                $this->goBack($e);
            }
            foreach($movies as $value){
                if($id_movie == $value->getId()){
                    // $asd = "+".($value->getLenght()+15)." minutes";
                    // return $asd;
                    return "+".($value->getLenght()+15)." minutes";
                }
            }
            return false;
        }

        public function setAllMT($allMT)
        {
            if(isset($allMT) && !is_array($allMT)){
                $this->allMT = array($allMT);
            }else if(is_array($allMT)){
                $this->allMT = $allMT;
            }else{
                $this->allMT = $allMT;
            }
        }

        public function setAllShows($allShows){
            if(isset($allShows) && !is_array($allShows)){
                $this->allShows = array($allShows);
            }else if(is_array($allShows)){
                $this->allShows = $allShows;
            }
        }


    }

?>