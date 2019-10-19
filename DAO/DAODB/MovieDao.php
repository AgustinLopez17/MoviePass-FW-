<?php
    namespace DAO\DAODB;
    use Models\Movie as Movie;
    use DAO\DAODB\Connection as Connection;
    use PDOException;

    class MovieDao extends Singleton{
        private $connection;
        public function __construct()
        
        {
            $this->connection = null;
        }
        
        public function create($movie)
        {
            $sql = "INSERT INTO movies (id_movie, title, lenght, language, image, overview) VALUES (:id, :title, :lenght, :language, :image, :overview)";
            $parameters['id'] = $movie->getId();
            $parameters['title'] = $movie->getTitle();
            $parameters['lenght'] = $movie->getLenght();
            $parameters['language'] = $movie->getLanguage();
            $parameters['image'] = $movie->getImage();
            $parameters['overview'] = $movie->getOverview();
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
            $sql = "SELECT * FROM movies";
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
            $sql = "SELECT * FROM movies where id_movie = :id";
            $parameters['id'] = $id;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(PDOException $e)
            {
                echo '<script>';
                echo 'console.log("Error en base de datos. Archivo: movieDao.php")';
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

        public function delete ($id)
        {
            $sql = "DELETE FROM movies WHERE id_movie = :id";
            $parameters['id'] = $id;
            try
            {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e)
            {
                echo $e;
            }
        }
        protected function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                return new Movie( $p['id_movie'], $p['title'], $p['lenght'], $p['language'],$p['image'],$p['overview']);
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }

        public function retrieveDataApi(){
            $cont = 0;
            $response = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=bf47253392bc9b0762556be7b49ab033");
            $array = ($response) ? json_decode($response, true) : array();
            //$this->deleteNotNowPlaying($array);
            foreach($array as $value){
                if(is_array($value)){
                    foreach($value as $aux){
                        if(is_array($aux)){
                            if(!$this->read($aux['id'])){
                                $data = file_get_contents("https://api.themoviedb.org/3/movie/".$aux['id']."?language=en-US&api_key=bf47253392bc9b0762556be7b49ab033");
                                $movie = ($data) ? json_decode($data, true) : array();
                                $newMovie = new Movie($movie["id"],$movie["title"],$movie["runtime"],$movie["original_language"],$movie["poster_path"],$movie['overview']);
                                $this->create($newMovie);
                            }
                        }
                    }
                }
            }
        }

        // function deleteNotNowPlaying($array){
        //     $all = $this->readAll();
        //     $flag = false;
        //     foreach($all as $valueR){
        //         foreach($array as $value){
        //             if(is_array($value)){
        //                 foreach($value as $aux){
        //                     if(is_array($aux)){
        //                         if($valueR->getId() == $aux['id']){
        //                             $flag = true;
        //                             break;
        //                         }else{
        //                             $flag = false;
        //                         }
        //                     }
        //                 }
        //             }
        //             if($flag)
        //                 break;
        //         }
        //         if(!$flag){
        //             $this->delete($valueR->getId());
        //         }
        //     }
        // }
    }


?>