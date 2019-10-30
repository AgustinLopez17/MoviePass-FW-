<?php
    namespace Controllers;

    use DAO\DAODB\UserDao as UserDao;
    use Models\User as User;
    use DAO\DAODB\MovieDao as MovieDao;
    use DAO\DAODB\ShowDao as ShowDao;
    use DAO\DAODB\GenreDao as GenreDao;

    class HomePageController
    {
        private $movieDao;
        private $allMovies;
        private $showDao;
        private $genresList;

        public function __construct(){
            $this->movieDao = new MovieDao();
            $this->movieDao->retrieveDataApi();
            $this->allMovies = array();
            $this->showDao = new ShowDao();
            $this->genresList = $this->showGenres();
        }


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

        // public function showListView(){
        //     foreach($this->showDao->readAll() as $show){
        //         foreach($this->movieDao->readAll() as $movie){
        //             if(($show->getId_movie() == $movie->getId())  ){
        //                 if(!in_array($movie,$this->allMovies)){
        //                     array_push($this->allMovies,$movie);
        //                 }
        //             }
        //         }
        //     }
        //     include("Views/home.php");
        // }

        public function showListView(){ 
            foreach($this->showDao->readAll() as $show){
                foreach($this->movieDao->readAll() as $movie){
                    if(($show->getId_movie() == $movie->getId())){
                        if(isset($_POST['id_genre'])){ //tuve que usar post para poder reutilizar esta función
                            foreach($movie->getGenres() as $genre){
                                if($_POST['id_genre'] == $genre->getId_genre()){
                                    if(!in_array($movie,$this->allMovies)){
                                        array_push($this->allMovies,$movie);
                                    }
                                }
                            }
                        }else if(isset($_POST['date'])){

                            if($_POST['date'] == $show->getDate()->format("Y-m-d")){
                                if(!in_array($movie,$this->allMovies)){
                                    array_push($this->allMovies,$movie);
                                }
                            }
                        }else{
                            if(!in_array($movie,$this->allMovies)){
                                array_push($this->allMovies,$movie);
                            }
                        }
                    }
                }
            }
            include("Views/home.php");
        }


        public function showGenres(){
            $genres = new GenreDao();
            $genres->retrieveDataApi();
            $genresList = $genres->readAll();
            return $genresList;
        }

        public function filter_x_date($date){

        }

        public function exit(){
            unset($_SESSION["loggedUser"]);
            include_once("Views/viewLogin.php");
        }




    }

?>