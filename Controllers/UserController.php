<?php
    namespace Controllers;
    use DAO\DAODB\UserDao;
    use DAO\DAODB\PurchaseDao;
    use DAO\DAODB\MovieDao;
    use DAO\DAODB\ShowDao;
    use PDOException;

    class UserController{
        private $userDao;
        private $purchaseDao;
        // private $movieDao;
        // private $showDao;
        public function __construct(){
            $this->userDao = new UserDao();
            $this->purchaseDao = new PurchaseDao();
            // $this->movieDao = new MovieDao();
            // $this->showDao = new ShowDao();
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

        public function seeUser($msg = null){
            if($this->validateSession()){
                $user = $_SESSION['loggedUser'];
                $allPurchases = $this->purchases($user->getDni());
                if(!is_array($allPurchases)){
                    $allPurchases = array($allPurchases);
                }
                include("Views/viewProfile.php");
            }
        }

        public function modifyUser($firstName,$surname,$dni){
            try{
                $this->userDao->update($firstName,$surname,$dni);
                $_SESSION['loggedUser']->setFirstName($firstName);
                $_SESSION['loggedUser']->setSurName($surname);
            }catch(PDOException $e){
                $msg = $e;
            }
            if(!isset($msg)){

                $msg = "User updated successfully";
            }
            $this->seeUser($msg);
        }

        public function purchases($dni){
            try{
                $allPurchases = $this->purchaseDao->readByDni($dni);
            }catch(PDOException $e){
                $msg = $e;
            }
            return $allPurchases;
        }

        // public function readMovie($id_show){
        //     try{
        //         $show = $this->showDao->read($id_show);
        //         $movie = $this->movieDao->read($show->getId_movie());
        //     }catch(PDOException $e){
        //         $msg = $e;
        //     }
        //     return $movie;
        // }



    }



?>