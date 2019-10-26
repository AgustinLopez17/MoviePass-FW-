<?php
    namespace DAO\DAODB;
    use Models\Show as Show;
    use DAO\DAODB\Connection as Connection;
    use PDOException;

    class ShowDao extends Singleton{
        private $connection;

        public function __construct()
        {
            $this->connection = null;
        }

        public function create($show){
            $sql = "INSERT INTO shows (show_date,id_cinema,id_movie) VALUES (:show_date,:id_cinema,:id_movie)";
            $parameters['show_date'] = $show->getDate()->format("Y-m-d H:i");
            $parameters['id_cinema'] = $show->getId_cinema();
            $parameters['id_movie'] = $show->getId_movie();
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                echo $e;
            }
        }

        public function readAll()
        {
            $sql = "SELECT * FROM shows";
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql);
            }
            catch(PDOException $e)
            {
                echo $e;
            }
            finally
            {
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
            } 
        }

        public function read ($id)
        {
            $sql = "SELECT * FROM shows where id_cinema = :id";
            $parameters['id'] = $id;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(PDOException $e)
            {
                echo '<script>';
                echo 'console.log("Error en base de datos. Archivo: ShowDAO.php")';
                echo '</script>';
            }
            finally
            {
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return "false";
            }
        }

        public function readByMovieAndDate($id_movie,$date){
            
            $sql = "SELECT * FROM shows where id_movie = :id_movie and date(show_date) = :newDate  ";
            $parameters['id_movie'] = $id_movie;
            $parameters['newDate'] = $date->format('Y-m-d');
            try{
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->executeNonQuery2($sql, $parameters);
            }catch(PDOException $e){
                echo '<script>';
                echo 'console.log("Error en base de datos. Archivo: ShowDAO.php")';
                echo '</script>';
            }finally{
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return "false";
            }
        }

        public function readByCinemaAndDate($id_cinema,$date){
            $sql = "SELECT * FROM shows where id_cinema = :id_cinema and date(show_date) = :newDate";
            $parameters['id_cinema'] = $id_cinema;
            $parameters['newDate'] = $date->format('Y-m-d');
            try{
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->executeNonQuery2($sql, $parameters);
            }catch(PDOException $e){
                echo '<script>';
                echo 'console.log("Error en base de datos. Archivo: ShowDAO.php")';
                echo '</script>';
            }finally{
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return "false";
            }
        }


        protected function mapear($value) { //TRAIGO VALORES DE LA BASE DE DATOS PARA USAR EN LA WEB (CREAR OBJETOS)
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                $newShow = new Show($p['show_date'], $p['id_cinema'], $p['id_movie']);
                $newShow->setId_show($p['id_show']); 
                return $newShow;
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }
        
    }




?>