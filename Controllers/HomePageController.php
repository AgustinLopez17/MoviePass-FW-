<?php
    namespace Controllers;

    use DAO\UsersRepository as UserRepository;
    use Models\User as User;

    use DAO\CinemaRepository as CinemaRepository;
    use Models\Cinema as Cinema;

    use Controllers\MovieController as MovieController;


    class HomePageController
    {
        public function login()
        {
             //sacar esto en un futuro, hay que hacer el check loggin
            if($_POST){
                if(isset($_POST["email"]) && isset($_POST["password"])){
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $userRepository = new UserRepository();
                    $user = $userRepository->GetByEmail($email);
                    if($user != null && ($password == $user->getPass())){
                        $loggedUser = new User($user->getFirstName(),$user->getSurName(),$user->getDni(),$user->getEmail(),$user->getPass(),$user->getGroup());
                        $_SESSION["loggedUser"] = $loggedUser;

                        $movieController = new MovieController();
                        $movieController->ShowListView();
                        //require_once("./Views/home.php");
                        
                    }else{
                        echo "<script> if(confirm('Datos incorrectos, vuelva a intentarlo !')); ";  
                        //include(VIEWS_PATH."header.php");
                        //include("Views/viewLogin.php");
                        echo "window.location = '../index.php'; </script>";
                    }
                }else{
                    
                    echo "<script> if(confirm('Hubo un problema al procesar los datos, vuelva a intentarlo !'));";  
                    echo "window.location = '../index.php'; </script>";
                }
            }
        }
        
        public function adminCines(){
            $cinemaRepository = new CinemaRepository();
            $cinemaList = $cinemaRepository->getAll();
            
            require_once("./Views/adminCines.php");
        }

        public function addCine(){
            if($_POST){
                $cinema = new Cinema($_POST['name'],$_POST['address'],$_POST['capacity'],$_POST['ticket_value']);
                $cRepo = new CinemaRepository();
                $cRepo->add($cinema);
                require_once("./Views/adminCines.php");
            }
            require_once("./Views/adminCines.php");
        }
        
        public function back(){
            define("GROUP",$_SESSION["loggedUser"]->getGroup());
            $movieController = new MovieController();
            $movieController->ShowListView();
        }

        public function exit(){
            unset($_SESSION["loggedUser"]);
            include_once("./Views/viewLogin.php");
        }


    }

?>