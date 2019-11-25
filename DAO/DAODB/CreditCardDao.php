<?php
    namespace DAO\DAODB;
    use Models\CreditCard as CreditCard;
    use DAO\DAODB\Connection as Connection;
    use PDOException;
    use DAO\DAODB\IDao;

    class CreditCardDao extends Singleton implements IDao{
        private $connection;
        public function __construct()
        {
            $this->connection = null;
        }
        
        public function create($CreditCard)
        {
            $sql = "INSERT INTO creditCards (numberCard, expire, securityCode, dni) VALUES (:numberCard, :expire, :securityCode, :dni)";
            $parameters['numberCard'] = $CreditCard->getNumberCard();
            $parameters['expire'] = $CreditCard->getExpire();
            $parameters['securityCode'] = $CreditCard->getSecurityCode();
            $parameters['dni'] = $CreditCard->getDni();
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                throw $e;
            }
        }

        public function readAll()
        {
            $sql = "SELECT * FROM creditCards";
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
        }

        public function read ($numberCard)
        {
            $sql = "SELECT * FROM creditCards where numberCard = :numberCard";
            $parameters['numberCard'] = $numberCard;
            try
            {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return false;
        }

        public function delete ($numberCard)
        {
            $sql = "DELETE FROM creditCards WHERE numberCard = :numberCard";
            $parameters['numberCard'] = $numberCard;
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

        public function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                $newCC = new CreditCard($p['numberCard'], $p['expire'], $p['securityCode'],$p['dni']);
                return $newCC;
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }
        }



?>