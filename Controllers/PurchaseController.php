<?php 
    namespace Controllers;
    use DAO\DAODB\MovieDao;
    use DAO\DAODB\MovieTheaterDao;
    use DAO\DAODB\ShowDao;
    use DAO\DAODB\UserDao;
    use DAO\DAODB\CinemaDao;
    use DAO\DAODB\PurchaseDao;
    use DAO\DAODB\TicketDao;
    use Models\Ticket;
    use Models\Purchase;
    use Controllers\HomePageController;
    use DateTime;
    use PDOException;
    class PurchaseController{
        private $userDao;
        private $movieDao;
        private $showDao;
        private $movieTheaterDao;
        private $cinemaDao;
        private $movie;
        private $allAvailableMT;
        private $currentDate;
        private $ticketDao;

        public function __construct(){
            $this->movieDao = new MovieDao();
            $this->movieTheaterDao = new MovieTheaterDao();
            $this->showDao = new ShowDao();
            $this->userDao = new UserDao();
            $this->cinemaDao = new CinemaDao();
            $this->purchaseDao = new PurchaseDao();
            $this->ticketDao = new TicketDao();
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $this->currentDate = new DateTime(date('Y-m-d H:i:s'));
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
            if ($this->validateSession()) {
                $avMT = $this->chargeMTs($id_movie);
                try {
                    $movie = $this->movieDao->read($id_movie);
                } catch (PDOException $e) {
                    $msg = $e;
                }
                include('Views/viewPurchase.php');
            }
        }

        public function continuePurchase($id_MT,$id_movie){
            if ($this->validateSession()) {
                try {
                    $mt = $this->movieTheaterDao->read($id_MT);
                    $movie = $this->movieDao->read($id_movie);
                } catch (PDOException $e) {
                    $msg = $e;
                }
                $avShows = $this->chargeShows($id_movie, $id_MT);
                include('Views/selectDatePurchase.php');
            }
        }

        public function listDats($id_show,$msg = null){
            if ($this->validateSession()) {
                try {
                    $show = $this->showDao->read($id_show);
                    $cinema = $this->cinemaDao->read($show->getId_cinema());
                    $mt = $this->movieTheaterDao->read($show->getId_movieTheater());
                    $movie = $this->movieDao->read($show->getId_movie());
                } catch (PDOException $e) {
                    $msg = $e;
                }
                include('Views/confirmPurchase.php');
            }
        }

        public function addCreditCard($id_show,$numberOfTickets){
            if ($this->validateSession()) {
                try {
                    $show = $this->showDao->read($id_show);
                    $movie = $this->movieDao->read($show->getId_movie());
                } catch (PDOException $e) {
                    $msg = $e;
                }
                if($numberOfTickets <= ($show->getTotal_tickets() - $show->getTickets_sold())){
                    if($numberOfTickets >= 2 || $this->currentDate->format("D") == 'Wed' || $this->currentDate->format("D") == 'Tue'){
                        $finalPrice = ($show->getTicket_price() * $numberOfTickets) * 0.75;
                        $discount = ($show->getTicket_price() * $numberOfTickets) * 0.25;
                    }else{
                        $finalPrice = $show->getTicket_price() * $numberOfTickets;
                    }
                    include('Views/addCC.php');
                }else{
                    $this->listDats($id_show,'Solo quedan '.($show->getTotal_tickets() - $show->getTickets_sold()).' tickets');
                }
            }
        }

        public function completePurchase($numberCard,$cvv,$dni,$expireMonth,$expireYear,$id_show,$numberOfTickets,$finalPrice,$discount = 0){
            if ($this->validateSession()) {
                $expireDate = $expireYear."-".$expireMonth;
                if ($this->creditCardValidation($numberCard, $cvv, $expireDate, $dni)) {
                    $flag = false;
                    while (!$flag) {
                        $codeOfTicket = $this->codeGen(30);
                        if ($this->codeValidation($codeOfTicket)) {
                            $flag = true;
                        }
                    }
                    $qr = "http://api.qrserver.com/v1/create-qr-code/?data='.$codeOfTicket.'&amp;size=300x300";
                    try {
                        $show = $this->showDao->read($id_show);
                        $user = $this->userDao->readById($dni);
                        $this->purchaseDao->createWithTickets($id_show, $codeOfTicket, $numberOfTickets, $this->currentDate->format("Y-m-d"), $qr, $dni, $discount, $finalPrice);
                        $show->setTickets_sold($show->getTickets_sold()+$numberOfTickets);
                        $this->showDao->updateTksSold($show->getTickets_sold(),$id_show);
                        $movie = $this->movieDao->read($show->getId_movie());
                    } catch (PDOException $e) {
                        $msg = $e;
                    }
                    if ($this->sendMail($user, $codeOfTicket) && !isset($msg)) {
                        $msg = 'Compra creada con éxito, se le ha enviado un mail con el codigo que deberá presentar en el cine';
                    } else {
                        $msg = 'Compra realizada con éxito, pero hubo un error al enviar el mail, QR para presentar en cine guardado en su perfil';
                    }
                    if($discount == 0){
                        $discount = null;
                    }
                    $price = $show->getTicket_price() * $numberOfTickets;
                    include('Views/addCC.php');
                }else{
                    $msg = 'Datos de tarjeta erroneos';
                    try {
                        $show = $this->showDao->read($id_show);
                        $movie = $this->movieDao->read($show->getId_movie());
                    } catch (PDOException $e) {
                        $msg = $e;
                    }
                    if($discount == 0){
                        $discount = null;
                    }
                    include('Views/addCC.php');
                }
            }
        }

        public function sendMail($user,$codeOfTicket){
            $email = "adm170599@gmail.com";
            $headers = 
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'From: ' .$email . "\r\n".
            'Reply-To: ' . $email. "\r\n" .
            'X-Mailer: PHP/' . phpversion();
            $cuerpo ='<html>
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                            <title>Enviar email</title>
                        </head>
                        <body>
                        <p> El siguiente codigo QR debera presentar en el correspondiente cine: </p>
                            <img src="http://api.qrserver.com/v1/create-qr-code/?data='.$codeOfTicket.'&amp;size=500x500">
                        </body>
                    </html>';
            return mail($user->getEmail(), 'MOVIEPASS - CODIGOQR', $cuerpo, $headers);
        }
        function goHome(){
            $home = new HomePageController();
            $home->showListView();
        }
        function codeValidation($codeOfTicket){
            try{
                if($this->ticketDao->readByCode($codeOfTicket)){
                    return false;
                }else{
                    return true;
                }
            }catch(PDOException $e){
                $msg = $e;
                return $msg;
            }
        }

        function codeGen($long) {
            $key = '';
            $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
            $max = strlen($pattern)-1;
            for($i=0;$i < $long;$i++) $key .= $pattern{mt_rand(0,$max)};
            return $key;
        }

        public function creditCardValidation($numberCard,$cvv,$expireDate,$dni){
            if(strlen($numberCard)==16 && strlen($cvv) == 3){
                return true;
            }else{
                return false;
            }
        }

    }



?>


