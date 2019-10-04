<?php namespace Controllers;
     require_once('..\Config\Autoload.php');
     use Config\Autoload as Autoload;
     Autoload::Start();

    use Models\User as User;
    use DAO\UsersRepository as UserRepository;

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
                
                header("location: ../Views/home.php");
                
            }else{
                echo "<script> if(confirm('Datos incorrectos, vuelva a intentarlo !'));";  
                echo "window.location = '../index.php'; </script>";
            }
        }else{
            
            echo "<script> if(confirm('Hubo un problema al procesar los datos, vuelva a intentarlo !'));";  
            echo "window.location = '../index.php'; </script>";
        }
    }


?>