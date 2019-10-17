<?php
    namespace DAO\DAODB;
    use Models\Cinema as Cinema;
    use DAO\DAODB\Connection as Connection;
    use PDOException;

    class CinemaDao extends Singleton{
        private $connection;
        public function __construct()
        {
            $this->connection = null;
        }
        
        public function create($cinema)
        {
            $sql = "INSERT INTO cinemas (name, adress, capacity, ticket_value, available) VALUES (:name, :address, :capacity, :ticket_value, :available)";
            $parameters['name'] = $cinema->getName();
            $parameters['address'] = $cinema->getAddress();
            $parameters['capacity'] = $cinema->getCapacity();
            $parameters['ticket_value'] = $cinema->getTicket_value();
            $parameters['available'] = $cinema->getAvailable();
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                echo $e;
            }
        }

        public function update ($id,$name,$address,$capacity,$ticket_value,$available)
        {
            $sql = "UPDATE cinemas SET name = :name, adress = :address, capacity = :capacity, ticket_value = :ticket_value, available = :available  WHERE id_cinema = :id";
            $parameters['id'] = $id;
            $parameters['name'] = $name;
            $parameters['address'] = $address;
            $parameters['capacity'] = $capacity;
            $parameters['ticket_value'] = $ticket_value;
            $parameters['available'] = $available;
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
            $sql = "SELECT * FROM cinemas";
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
            $sql = "SELECT * FROM cinemas where id_cinema = :id";
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
            $sql = "DELETE FROM cinemas WHERE id_cinema = :id";
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
                $newCinema = new Cinema($p['name'], $p['adress'], $p['capacity'],$p['ticket_value'],$p['available']);
                $newCinema->setId($p['id_cinema']);
                return $newCinema;
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }
        }



?>