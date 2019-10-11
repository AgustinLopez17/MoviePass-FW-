<?php
    namespace Controllers;

    use DAO\UsersRepository as UserRepository;
    use Models\User as User;

    use DAO\CinemaRepository as CinemaRepository;
    use Models\Cinema as Cinema;

    use Controllers\MovieController as MovieController;
    use Controllers\CinemaController as CinemaController;

    class HomePageController
    {
        public function login()
        {
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

                        // $movieList = new MovieRepository();
                        // $movieList->retrieveDataApi();
                        // $allMovies = $movieList->GetAll();
                        //require_once("Views/home.php");
                        
                    }else{
                        echo "<script> if(confirm('Datos incorrectos, vuelva a intentarlo !')); ";  
                        echo "window.location = '../index.php'; </script>";
                    }
                }else{
                    
                    echo "<script> if(confirm('Hubo un problema al procesar los datos, vuelva a intentarlo !'));";  
                    echo "window.location = '../index.php'; </script>";
                }
            }else if(isset($_SESSION['loggedUser'])){
                $movieController = new MovieController();
                $movieController->ShowListView();
            }
        }

        public function exit(){
            unset($_SESSION["loggedUser"]);
            include_once("Views/viewLogin.php");
        }




    }

?>