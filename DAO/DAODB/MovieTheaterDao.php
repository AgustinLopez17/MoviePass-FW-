<?php namespace DAO\DAODB;
    use Models\MovieTheater as MovieTheater;
    use DAO\DAODB\Connection as Connection;
    use PDOException;
    class MovieTheaterDao extends Singleton{
        private $connection;
        public function __construct(){
            $this->connection = null;
        }
        public function create ($movieTheater){
            $sql = "INSERT INTO movieTheater (name, adress, available, numberOfCinemas) VALUES (:name, :address, :available, :numberOfCinemas)";
            $parameters['name'] = $movieTheater->getName();
            $parameters['address'] = $movieTheater->getAddress();
            $parameters['available'] = $movieTheater->getAvailable();
            $parameters['numberOfCinemas'] = $movieTheater->getNumberOfCinemas();
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                echo $e;
            }
        }

        public function createWithCinemas($movieTheater,$priceDefault){
            $sql = "CALL moviepass.createMT(:name,:address,:available,:numberOfCinemas,:priceDefault)";
            $parameters['name'] = $movieTheater->getName();
            $parameters['address'] = $movieTheater->getAddress();
            $parameters['available'] = $movieTheater->getAvailable();
            $parameters['numberOfCinemas'] = $movieTheater->getNumberOfCinemas();
            $parameters['priceDefault'] = $priceDefault;
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                echo $e;
            }
        }

        public function update($id,$name,$address,$available,$numberOfCinemas)
        {
            $sql = "UPDATE movieTheater SET name = :name, adress = :address, available = :available, numberOfCinemas = :numberOfCinemas WHERE id_movieTheater = :id";
            $parameters['id'] = $id;
            $parameters['name'] = $name;
            $parameters['address'] = $address;
            $parameters['available'] = $available;
            $parameters['numberOfCinemas'] = $numberOfCinemas;
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

        public function readAll()
        {
            $sql = "SELECT * FROM movieTheater";
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
            $sql = "SELECT * FROM movieTheater where id_movieTheater = :id";
            $parameters['id'] = $id;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(PDOException $e)
            {
                echo '<script>';
                echo 'console.log("Error en base de datos. Archivo: CinemaDao.php")';
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

        public function delete ($id)
        {
            $sql = "DELETE FROM movieTheater WHERE id_movieTheater = :id";
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
                $newMT = new movieTheater($p['name'], $p['adress'],$p['available'],$p['numberOfCinemas']);
                $newMT->setId($p['id_movieTheater']);
                return $newMT;
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }

    }