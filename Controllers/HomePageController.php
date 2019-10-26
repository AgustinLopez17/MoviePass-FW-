<?php
    namespace Controllers;

    use DAO\DAODB\UserDao as UserDao;
    use Models\User as User;
    use DAO\DAODB\MovieDao as MovieDao;

    class HomePageController
    {
        public function login()
        {
            if($_POST){
                if(isset($_POST["email"]) && isset($_POST["password"])){
                    $email = $_POST["email"];
                    $password = $_POST["password"];

                    $userDao = new UserDao();
                    $user = $userDao->read($email);

                    if($user && ($password == $user->getPass())){
                        $loggedUser = new User($user->getFirstName(),$user->getSurName(),$user->getDni(),$user->getEmail(),$user->getPass(),$user->getGroup());
                        $_SESSION["loggedUser"] = $loggedUser;
                        $this->ShowListView();
                    }else{
                        echo "<script> if(confirm('Datos incorrectos, vuelva a intentarlo !')); ";  
                        echo "window.location = '../index.php'; </script>";
                    }
                }else{
                    
                    echo "<script> if(confirm('Hubo un problema al procesar los datos, vuelva a intentarlo !'));";  
                    echo "window.location = '../index.php'; </script>";
                }
            }else if(isset($_SESSION['loggedUser'])){
                $this->ShowListView();
            }
        }


        

        public function showListView(){
            $movieList = new MovieDao();
            $movieList->retrieveDataApi();
            $allMovies = $movieList->readAll();

            include("Views/home.php");
        }

        public function exit(){
            unset($_SESSION["loggedUser"]);
            include_once("Views/viewLogin.php");
        }




    }

?>