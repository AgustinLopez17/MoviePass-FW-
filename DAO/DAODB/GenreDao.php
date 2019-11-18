<?php
    namespace DAO\DAODB;
    use Models\Genres as Genres;
    use Models\Movie as Movie;
    use DAO\DAODB\Connection as Connection;
    use PDOExpection;

    class GenreDao extends Singleton{
        private $connection;
        public function __construct(){
            $this->connection = null;
        }

        public function create($genre){
            $sql = "INSERT INTO genre (id_genre,genre) VALUES (:id_genre,:genre)";
            $parameters['id_genre'] = $genre->getId_genre();
            $parameters['genre'] = $genre->getName_genre();
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql,$parameters);
            }catch(PDOException $e){
                echo $e;
            }
        }
        public function readAll()
        {
            $sql = "SELECT * FROM genre";
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
            $sql = "SELECT * FROM genre where id_genre = :id";
            $parameters['id'] = $id;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(PDOException $e)
            {
                echo '<script>';
                echo 'console.log("Error en base de datos. Archivo: GENREDAO.php")';
                echo '</script>';
            }
            finally
            {
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
            }
        }
        protected function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                return new Genres( $p['id_genre'],$p['genre']);
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }

        public function retrieveDataApi(){
            $response = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=bf47253392bc9b0762556be7b49ab033&language=en-US");
            $array = ($response) ? json_decode($response,true) : array();
            foreach($array as $value){
                if(is_array($value)){
                    foreach($value as $aux){
                        if(!$this->read($aux['id'])){
                            $genre = new Genres($aux['id'],$aux['name']);
                            $this->create($genre);
                        }
                    }
                }
            }
        }

        public function readByMovieId($id_movie){
            $sql = "SELECT * FROM genre g INNER JOIN genre_x_movie gm ON gm.id_genre = g.id_genre where id_movie = :id_movie";
            $parameters['id_movie'] = $id_movie;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(PDOException $e)
            {
                echo '<script>';
                echo 'console.log("Error en base de datos. Archivo: GENREDAO.php")';
                echo '</script>';
            }
            finally
            {
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
            }
        }

        public function arrayGenre($genres){ //Esta funcion va a generar un array de objetos genero, desde un arreglo que nos devuelve la api
            $arrayGenres = array();
            foreach($genres as $value){
                $genre = new Genres($value['id'],$value['name']);
                array_push($arrayGenres,$genre);
            }
            return $arrayGenres;
        }

        // public function addGenreToMovie($movie){
        //     $sql = "SELECT genre.id_genre,genre.genre FROM genre inner join genre_x_movie on genre.id_genre = genre_x_movie.id_genre WHERE genre_x_movie.id_movie = :id_movie";
        //     $paramenters['id_movie'] = $movie->getId();
        //     try
        //     {
        //         $this->connection = Connection::getInstance();
        //         $resultSet = $this->connection->execute($sql,$paramenters);
        //     }
        //     catch(PDOException $e)
        //     {
        //         echo $e;
        //     }
        //     finally
        //     {
        //         if(!empty($resultSet)){
        //             $aux = $this->mapear($resultSet);
        //             if(!is_array($aux)){
        //                 $aux= array($aux);
        //             }
        //             $movie->setGenres($aux);
        //             return $movie;
        //         }
        //         else
        //             return "false";
        //     } 
        //}

    }


?>