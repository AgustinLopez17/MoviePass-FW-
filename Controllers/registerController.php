<?php
    namespace Controllers;
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
                
                $users = $this->dao->readAll();

                if( $users && !empty($users) && !is_array($users)){
                    $usersList = array($users);
                }else if(!$users){
                    $this->dao->create($user);
                    echo "<script> if(confirm('Usuario agregado con éxito!'));";
                    echo "window.location = '../index.php'; </script>";
                }else{
                    $userList = $users;
                }
                $userExist = false;
                foreach($usersList as $value){
                    if($value->getDni() == $user->getDni()){
                        $userExist = true;
                    }
                }


                if(!$userExist) {
                    $this->dao->create($user);
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