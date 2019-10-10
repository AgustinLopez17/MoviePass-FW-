<?php
    namespace Controllers;

    use DAO\UsersRepository as UserRepository;
    use Models\User as User;

    class HomePageController
    {
        public function login()
        {
            session_destroy();
            if($_POST){
                if(isset($_POST["email"]) && isset($_POST["password"])){
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $userRepository = new UserRepository();
                    $user = $userRepository->GetByEmail($email);
        
                    if($user != null && ($password == $user->getPass())){
                        session_start();
                        $loggedUser = new User($user->getFirstName(),$user->getSurName(),$user->getDni(),$user->getEmail(),$user->getPass());
                        $_SESSION["loggedUser"] = $loggedUser;
                        require_once("./Views/home.php");
                        
                    }else{
                        echo "<script> if(confirm('Datos incorrectos, vuelva a intentarlo !'));";  
                        echo "window.location = '../index.php'; </script>";
                    }
                }else{
                    
                    echo "<script> if(confirm('Hubo un problema al procesar los datos, vuelva a intentarlo !'));";  
                    echo "window.location = '../index.php'; </script>";
                }
            }
        } 
        

    }

?>