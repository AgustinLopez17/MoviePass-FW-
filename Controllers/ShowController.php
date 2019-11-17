<?php
    namespace Controllers;

    use DAO\DAODB\ShowDao as ShowDao;
    use Models\Show as Show;
    use DAO\DAODB\CinemaDao as CinemaDao;
    use DAO\DAODB\MovieDao as MovieDao;
    use \DateTime;

    class ShowController{
        private $showDao;
        private $cinemaDao;
        private $movieDao;

        function __construct(){
            $this->showDao = new ShowDao();
            $this->cinemaDao = new CinemaDao();
            $this->movieDao = new MovieDao();
        }

        public function goBack($outcome){
            require_once(VIEWS_PATH."validate-session.php");
            require_once("Views/adminCines.php");
        }

        public function converseArray($dbShows){
            if(!is_array($dbShows)){
                $shows = array($dbShows);
            }else{
                $shows = $dbShows;
            }
            return $shows;
        }

        public function addShow($id_cinema,$id_movie,$date){
            $objDate = new DateTime($date);
            $nowDate = new DateTime(date('Y-m-d'));
            $dbShows = $this->showDao->readByMovieAndDate($id_movie,$objDate);
            if($dbShows != "false"    &&  $objDate >= $nowDate){
                $shows = $this->converseArray($dbShows);
                if($id_cinema == $shows[0]->getId_cinema()){
                    require_once("Views/newShow.php");
                }else{
                    $this->goBack("Pelicula ya reservada por otro cine");
                }
            }else if($objDate >= $nowDate){
                require_once("Views/newShow.php");
            }else{
                $this->goBack("Fecha posterior a actual");
            }
        }

        public function addHour($id_cinema,$id_movie,$date,$time){
            $objDate = new DateTime($date);
            $inDisplay = $this->showDao->readByCinemaAndDate($id_cinema,$objDate);
            $movieTime = $this->timeOfMovie($id_movie);
            $aux = $date . " " . $time;
            $newDate = new DateTime($aux);
            $newShow = new Show($aux,$id_cinema,$id_movie);
            if($inDisplay != "false" && $this->showDao->readAll()){
                $shows = $this->converseArray($inDisplay);
                $validation = $this->checkAvailableTime($shows,$newDate,$movieTime);
                if($validation){
                    $this->showDao->create($newShow);
                    $this->goBack("Se agregó correctamente");
                }else{
                    $this->goBack("No se agregó porque se pisa con otro horario");
                }
            }else{
                $this->showDao->create($newShow);
                $this->goBack("Se agregó correctamente porque la pelicula no existia en otro cine");
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
            foreach($this->movieDao->readAll() as $value){
                if($id_movie == $value->getId()){
                    $asd = "+".($value->getLenght()+15)." minutes";
                    return $asd;
                }
            }
            return false;
        }

        public function modShow($id_show,$id_cinema,$id_movie,$date){
            
        }

    }

?>