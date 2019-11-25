<?php
    namespace DAO\DAODB;

    use Models\Movie as Movie;
    use Models\Genres as Genres;

    use DAO\DAODB\GenreDao as GenreDao;

    use DAO\DAODB\Connection as Connection;
    use PDOException;
    use DAO\DAODB\IDao;

    class MovieDao extends Singleton implements IDao
    {
        private $connection;
        public function __construct()
        {
            $this->connection = null;
        }
        
        public function create($movie)
        {
            if ($movie->getLenght() == null) {
                $movie->setLenght(120);
            }
            $sql = "INSERT INTO movies (id_movie, title, lenght, language, image, overview, background) VALUES (:id, :title, :lenght, :language, :image, :overview, :background)";
            $parameters['id'] = $movie->getId();
            $parameters['title'] = $movie->getTitle();
            $parameters['lenght'] = $movie->getLenght();
            $parameters['language'] = $movie->getLanguage();
            $parameters['image'] = $movie->getImage();
            $parameters['overview'] = $movie->getOverview();
            $parameters['background'] = $movie->getBackground();
            

            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
        }

        public function addGenre_X_movie($genres, $id_movie)
        {
            $sql = "INSERT INTO genre_x_movie (id_genre,id_movie) VALUES (:id_genre, :id_movie)";
            foreach ($genres as $value) {
                $parameters['id_genre'] = $value->getId_genre();
                $parameters['id_movie'] = $id_movie;
                try {
                    $this->connection = Connection::getInstance();
                    $this->connection->ExecuteNonQuery($sql, $parameters);
                } catch (PDOException $e) {
                    throw $e;
                }
            }
        }

        public function readAll()
        {
            $sql = "SELECT * FROM movies";
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql);
            } catch (PDOException $e) {
                throw $e;
            }

            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return false;
            }
        }
        public function read($id)
        {
            $sql = "SELECT * FROM movies where movies.id_movie = :id";
            $parameters['id'] = $id;
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }

            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return false;
            }
        }
        
        public function readMoviesIfShow()
        {
            $sql = "SELECT m.id_movie,m.title,m.lenght,m.language,m.image,m.overview,m.background FROM movies m INNER JOIN shows s ON m.id_movie = s.id_movie WHERE s.show_date >= curdate() AND s.tickets_sold < s.total_tickets GROUP BY m.id_movie";
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql);
            } catch (PDOException $e) {
                throw $e;
            }

            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return false;
            }
        }

        public function readAllMoviesIfShow(){
            $sql = "SELECT m.id_movie,m.title,m.lenght,m.language,m.image,m.overview,m.background FROM movies m INNER JOIN shows s ON m.id_movie = s.id_movie GROUP BY m.id_movie";
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql);
            } catch (PDOException $e) {
                throw $e;
            }

            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return false;
            }
        }

        public function readMoviesByGenre($id_genre)
        {
            $sql = "SELECT m.id_movie,m.title,m.lenght,m.language,m.image,m.overview,m.background FROM movies m INNER JOIN shows s ON m.id_movie = s.id_movie INNER JOIN genre_x_movie gm ON M.id_movie = GM.id_movie WHERE GM.id_genre = :id_genre AND s.show_date >= curdate() AND s.tickets_sold < s.total_tickets GROUP BY M.id_movie";
            $parameters['id_genre'] = $id_genre;
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return false;
            }
        }

        public function readMoviesByDate($date)
        {
            $sql = "SELECT m.id_movie,m.title,m.lenght,m.language,m.image,m.overview,m.background FROM movies m INNER JOIN shows s ON m.id_movie = s.id_movie WHERE date_format(s.show_date,'%Y-%m-%d') = :dateForSearch  AND s.tickets_sold < s.total_tickets GROUP BY m.id_movie";
            $parameters['dateForSearch'] = $date;
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }

            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return false;
            }
        }


        public function delete($id)
        {
            $sql = "DELETE FROM movies WHERE id_movie = :id";
            $parameters['id'] = $id;
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
        }

        public function mapear($value)
        {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function ($p) {
                $movie = new Movie($p['id_movie'], $p['title'], $p['lenght'], $p['language'], $p['image'], $p['overview'], $p['background']);
                return $movie;
            }, $value);
            /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
            return count($resp) > 1 ? $resp : $resp['0'];
        }


        public function retrieveDataApi()
        {
            $json = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=" . API_KEY);
            $arregloAPI = json_decode($json, true);
            $APIDataArray = $arregloAPI["results"];
            $arrayOfMovies = array();
            for ($i=0; $i<count($APIDataArray); $i++) {
                $dataMovie = $APIDataArray[$i];
                if (!$this->read($dataMovie['id'])) {
                    $name = $dataMovie["title"];
                    $id = $dataMovie["id"];
                    $synopsis = $dataMovie["overview"];
                    $background = "http://image.tmdb.org/t/p/original" . $dataMovie["backdrop_path"];
                    $score = $dataMovie["vote_average"];
                    $arrayOfGenresID = $dataMovie["genre_ids"];
                    $newMovie = new Movie($id, $name, 120, $dataMovie['original_language'], $dataMovie["poster_path"], $synopsis, $background);
                    $this->create($newMovie);
                    $genreDao = new GenreDao();
                    $this->addGenre_X_movie($genreDao->arrayGenre($dataMovie['genre_ids']), $dataMovie['id']);
                }
            }
        }
    }
