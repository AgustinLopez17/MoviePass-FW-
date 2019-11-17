<?php
    namespace DAO\DAODB;
    use Models\Movie as Movie;
    use Models\Genres as Genres;

    use DAO\DAODB\GenreDao as GenreDao;

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
            if( $movie->getLenght() == null ){
                $movie->setLenght(120);
            }
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
                throw $e;
            }
        }

        public function addGenre_X_movie($genres,$id_movie){
            $sql = "INSERT INTO genre_x_movie (id_genre,id_movie) VALUES (:id_genre, :id_movie)";
            foreach($genres as $value){
                $parameters['id_genre'] = $value->getId_genre();
                $parameters['id_movie'] = $id_movie;
                try{
                    $this->connection = Connection::getInstance();
                    $this->connection->ExecuteNonQuery($sql,$parameters);
                }catch(PDOException $e){
                    throw $e;
                }
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
                throw $e;
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
            $sql = "SELECT * FROM movies where movies.id_movie = :id";
            $parameters['id'] = $id;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            finally
            {
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
            }
        }
        
        public function readMoviesIfShow(){
            $sql = "SELECT m.id_movie,m.title,m.lenght,m.language,m.image,m.overview FROM movies m INNER JOIN shows s ON m.id_movie = s.id_movie WHERE s.show_date >= curdate()";
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            finally
            {
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
            }
        }

        public function readMoviesByGenre($id_genre){
            $sql = "SELECT m.id_movie,m.title,m.lenght,m.language,m.image,m.overview FROM movies m INNER JOIN shows s ON m.id_movie = s.id_movie INNER JOIN genre_x_movie gm ON M.id_movie = GM.id_movie WHERE GM.id_genre = :id_genre AND s.show_date >= curdate()";
            $parameters['id_genre'] = $id_genre;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql,$parameters);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            finally
            {
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
            }
        }

        public function readMoviesByDate($date){
            $sql = "SELECT m.id_movie,m.title,m.lenght,m.language,m.image,m.overview FROM movies m INNER JOIN shows s ON m.id_movie = s.id_movie WHERE date_format(s.show_date,'%Y-%m-%d') = :dateForSearch";
            $parameters['dateForSearch'] = $date;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql,$parameters);
            }
            catch(PDOException $e)
            {
                throw $e;
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
                throw $e;
            }
        }

        protected function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                $genreDao = new GenreDao();

                $movie = new Movie( $p['id_movie'], $p['title'], $p['lenght'], $p['language'],$p['image'],$p['overview']);
                
                return $genreDao->addGenreToMovie($movie);
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
                                $genreDao = new GenreDao();
                                $newMovie->setGenres($genreDao->arrayGenre($movie['genres']));


                                $this->addGenre_X_movie($newMovie->getGenres(),$movie['id']);
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