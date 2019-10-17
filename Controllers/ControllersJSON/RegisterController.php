<?php
    namespace Controllers;

    use DAO\UsersRepository as UserRepository;
    use Models\User as User;

    use DAO\DAODB\UserDao as UserDao;


class RegisterController{

    protected $dao;

    function __construct(){
        $this->dao = UserDao::getInstance();
    }


    public function register(){
        if($_POST){
            if(isset($_POST["firstName"]) && isset($_POST["surName"]) && isset($_POST["dni"]) 
                && isset($_POST["email"]) && isset($_POST["pass"])){

                if($_POST["email"] == "lab4@utn.com"){
                    $group = 1;
                }else{
                    $group = 0;
                }
                $user = new User($_POST["firstName"],$_POST["surName"],$_POST["dni"],$_POST["email"],$_POST["pass"],$group);  
                $usersRepository = new UserRepository();
                $userList = $usersRepository->getAll();
                $userExist = false;
                foreach ($userList as $key => $value) {
                    if($value->getDni() == $user->getDni()){
                        $userExist = true;
                    }
                }
                if(!$userExist) {
                    $usersRepository->Add($user);
                    echo "<script> if(confirm('Usuario agregado con éxito!'));";
                    echo "window.location = '../index.php'; </script>";
                } else {
                    echo "<script> if(confirm('El usuario ya existe'));";
                    echo "window.location = '../index.php'; </script>";
                }    
            }  
        }
    }
}
?>