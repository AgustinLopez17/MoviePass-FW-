<?php
    namespace Controllers;
    use Models\User as User;
    use DAO\DAODB\UserDao as UserDao;
    use PDOException as PDOException;

class RegisterController{

    protected $dao;

    function __construct(){
        $this->dao = UserDao::getInstance();
    }

    public function goBack(){
        require_once(VIEWS_PATH."viewLogin.php");
    }

    public function register($firstname,$surname,$dni,$email,$pass){
        if($email == "adm170599@gmail.com"){ 
            $group = 1;
        }else{
            $group = 0;
        }
        $user = new User($firstname,$surname,$dni,$email,$pass,$group);
        $flag = null;
        try{
            $flag = $this->dao->readById($dni);
        }catch(PDOException $e){
            $msg = $e;
        }
        if(isset($flag) && !$flag){
            try{
                $this->dao->create($user);
                $msg = 'Registered user successfully';
            }catch(PDOException $e){
                $msg = $e;
            }
        }else if(isset($flag)){
            $msg = 'Existing ID';
        }
        include('Views/viewLogin.php');
    }
}
?>