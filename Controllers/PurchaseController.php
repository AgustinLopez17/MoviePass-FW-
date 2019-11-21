<?php 
    namespace Controllers;
    use DAO\DAODB\MovieDao;
    use DAO\DAODB\MovieTheaterDao;
    use DAO\DAODB\ShowDao;
    use Models\Ticket;
    use Models\Purchase;

    use PDOException;
    class PurchaseController{
        private $movieDao;
        private $showDao;
        private $movieTheaterDao;
        private $movie;
        private $allAvailableMT;

        public function __construct(){
            $this->movieDao = new MovieDao();
            $this->movieTheaterDao = new MovieTheaterDao();
            $this->showDao = new ShowDao();
        }

        public function chargeShows($id_movie,$id_mt){
            try{
                $availableShows = $this->showDao->readByMovieAndMT($id_movie,$id_mt);
            }catch(PDOException $e){
                $msg = $e;
            }

            if($availableShows && !is_array($availableShows)){
                $availableShows = array($availableShows);
            }
            return $availableShows;
        }

        public function chargeMTs($id_movie){
            $MTArray = array();
            try{
                $availableMTs = $this->movieTheaterDao->readByMovie($id_movie);
            }catch(PDOException $e){
                $msg = $e;
            }
            if($availableMTs && !is_array($availableMTs)){
                $availableMTs = array($availableMTs);
            }
            return $availableMTs;
        }

        public function seeAvailableMT($id_movie){
            $avMT = $this->chargeMTs($id_movie);
            try{
                $movie = $this->movieDao->read($id_movie);
            }catch(PDOException $e){
                $msg = $e;
            }
            include('Views/viewPurchase.php');
        }

        public function continuePurchase($id_MT,$id_movie){

            try{
                $mt = $this->movieTheaterDao->read($id_MT);
                $movie = $this->movieDao->read($id_movie);
            }catch(PDOException $e){
                $msg = $e;
            }
            $avShows = $this->chargeShows($id_movie,$id_MT);
            include('Views/selectDatePurchase.php');
        }

        public function finishPurchase($id_show){
            try{
                $show = $this->showDao->read($id_show);
                $mt = $this->movieTheaterDao->read($show->getId_movieTheater());
                $movie = $this->movieDao->read($show->getId_movie());
            }catch(PDOException $e){
                $msg = $e;
            }
            include('Views/confirmPurchase.php');
        }

        public function makeTicket($id_show,$numberOfTickets){
            $date = date_create();
            $tk_number = date_timestamp_get($date);

            // Solo falta compra con tarjeta de credito, y consulta de compras realizadas.





        }


    }



?>


