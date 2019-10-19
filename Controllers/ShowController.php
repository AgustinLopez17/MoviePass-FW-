<?php
    namespace Controllers;

    use DAO\DAODB\ShowDao as ShowDao;
    use Models\Show as Show;
    use DAO\DAODB\CinemaDao as CinemaDao;
    use DAO\DAODB\MovieDao as MovieDao;

    class ShowController{
        private $showDao;
        function __construct(){
            $this->showDao = new ShowDao();
        }

        public function goBack($outcome){
            $cinemaList = new CinemaDao();
            $allMovies = new MovieDao();
            $cinemaList = $cinemaList->readAll();
            $allMovies = $allMovies->readAll();
            require_once("Views/adminCines.php");
        }


        public function dateManage($date){
            $allDate = explode("T",$date); //en la base de datos la fecha y la hora estan separadas por una T
            return $allDate;
        }

        public function addShow(){
            if($_POST){
                $arrayDate = $this->dateManage($_POST['date']);
                $outcome = $this->checkShowInCinema($arrayDate,$_POST['id_movie'],$_POST['id_cinema']);
                if(!is_string($outcome)){ //Si la funcion a agregar no la tiene otro cine en ese dia se agregará la funcion si no existe una funcion ese dia en ese horario que dure la pelicula inclusive comprobando los 15 minutos que existen entre funcion y funcion
                    if(!$outcome){
                        $newShow = new Show($_POST['date'],$_POST['id_cinema'],$_POST['id_movie']);
                        $this->showDao->create($newShow);
                        $this->goBack($outcome);
                    }else{ //esto se puede ejecutar por variadas razones: la funcion pertenece a otro cine, la funcion se quizo agregar encima de otra funcion ya existente y en caso de no encontrar el id de la pelicula (caso extraño)
                        $this->goBack($outcome);
                    }
                }else{
                    $this->goBack($outcome);
                }
            }
        }

        public function allShows(){
            if(!is_array($this->showDao->readAll())){
                return array($this->showDao->readAll());
            }else{
                return $this->showDao->readAll();
            }
        }

        public function checkShowInCinema($arrayDate,$id_movie,$id_cinema){
            $allShow = $this->allShows();
            $dates = explode("-",$arrayDate[0]);
            $day = $dates[2];
            foreach($allShow as $value){ //recorro todos los shows existentes en mi BD
                $datesOfShowDB = explode(" ",$value->getDate()); //esto es necesario para manejar los dias y los horarios por separado
                $arrayDatesOfShowDB = explode("-",$datesOfShowDB[0]);
                $dayOfShow = $arrayDatesOfShowDB[2];
                if($dayOfShow == $day && $value->getId_movie() == $id_movie && $id_cinema != $value->getId_cinema()){ //si el dia que se quiere agregar coincide esta funcion existente en la BD y la pelicula que se quiere agregar también coincide con esta funcion existente en bd pero el cine no es el mismo, quiere decir se está intentando agregar una funcion ya existente en otro cine.
                    //echo "La pelicula se encuentra en la cartelera de otro cine";
                    return "showInOther";
                }else if($id_cinema == $value->getId_cinema() && $dayOfShow == $day && $value->getId_movie() == $id_movie){ //si el dia que se quiere agregar coincide esta funcion existente en la BD y la pelicula que se quiere agregar también coincide con esta funcion existente en bd PERO EL CINE ES EL MISMO QUE YA HABIA CREADO LA FUNCION MENCIONADA, QUIERE DECIR QUE PODRÍA AGREGAR OTRA FUNCION, YA QUE LA PELICULA SELECCIONADA LE PERTENECE.
                    $outcome = $this->checkOverlaying($arrayDate,$id_movie,$datesOfShowDB[1]); //verifico que las funciones no se pisen
                    if($outcome){
                        return "showOverlaying";
                    }else{
                        return false;
                    }
                }else if($id_cinema == $value->getId_cinema() && $dayOfShow == $day && $value->getId_movie() != $id_movie){ //en caso de que ese dia el cine ya tenga una funcion registrada, no le va a dejar en ese dia agregar otro tipo de funcion (diferente pelicula)
                    return "diferentMovie";
                }
            }
            return false;
        }

        public function checkOverlaying($arrayDate,$id_movie,$datesOfShowDB){ //los explodes son necesarios para poder cambiar los ":" por "." y transformarlos en numeros con decimales
           
            $hourAndMinutes = explode(":",$arrayDate[1]); //separo la hora y los minutos de la funcion a agregar para poder hacer correctamente las validaciones
            $hour = $hourAndMinutes[0];
            $hour = $hour . "." . ($hourAndMinutes[1] % 60);
            $hourAndMinutesDB = explode(":",$datesOfShowDB); //separo la hora y los minutos de la funcion existente en la BD para poder hacer correctamente las validaciones
            
            $hourDB = $hourAndMinutesDB[0];
            $hourAndMinutesDB[1] = $hourAndMinutesDB[1]+15; //Agrego los 15 minutos de espera luego de la funcion
           
            $hourDB = $hourDB . "." . ($hourAndMinutesDB[1] % 60);
            $movieTime = $this->timeOfMovie($id_movie); //llamo a la funcion que evalua la duracion de la funcion para evaluar que no se este añadiendo una funcion encima de otra
           
            if($movieTime){ // movieTime podría devolver falso en caso de no encontrar el ID de la pelicula en la BD, si lo encuentra devuelve la duracion de la misma
             
                if( ($hourDB + $movieTime) > 24){ //evaluo el caso de que la duracion de la funcion sobrepase las 24hs y en caso de ser asi empiezo el reloj devuelta (xej. pelicula que comenzo a las 23 y dura mas de 1 hs)
                    $newHour = ($hourDB + $movieTime) - 24;
                  
                    if($newHour > $hour){ //si el horario en el que se quiere poner la nueva funcion se encuentra dentro del horario o pasados 15 minutos de la funcion ya existente en la BD, no se agregará a la misma
                        //echo "Funcion ya existente que terminará a las ".$newHour." por lo tanto en el horario ingresado aun se encuentra en ejecucion, por favor ingrese otro horario";
                        return true;
                    }else{
                        //echo "Felicitaciones, ha ingresado la función correctamente";
                        return false;
                    }
               
                }else{ //ejecuta lo mismo de arriba, solo que aqui la funcion no se pasó de las 24hs
                    if(($hourDB + $movieTime) > $hour){
                        //echo "Función ya existente que terminará a las ".($hourDB+$movieTime)." por lo tanto en el horario ingresado aun se encuentra en ejecucion, por favor ingrese otro horario";
                        return true;
                    }else{
                        //echo "Felicitaciones, ha ingresado la función correctamente";
                        return false;
                    }
                }

            }
            return false;
        }

        public function timeOfMovie($id_movie){ //Esta funcion devuelve la duracion de la pelicula
            $allMovies = new MovieDao();
            $allMovies = $allMovies->readAll();
            foreach($allMovies as $value){
                if($id_movie == $value->getId()){
                    $hour = floor($value->getLenght() / 60);
                    $minutes = ($value->getLenght() % 60);
                    return $hour . "." . $minutes;
                }
            }
            return false;
        }




    }






?>