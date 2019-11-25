<?php
    namespace DAO\DAODB;
    use Models\Ticket;
    use DAO\DAODB\Connection;
    use PDOException;
    use DAO\DAODB\IDao;
    class TicketDao extends Singleton implements IDao{
        private $connection;
        public function __construct()
        {
            $this->connection = null;
        }
        
        public function create($ticket)
        {
            $sql = "INSERT INTO tickets (tk_code,id_purchase,id_show) VALUES (:tk_code,:id_purchase,:id_show)";
            $parameters['tk_code'] = $ticket->getTk_code();
            $parameters['id_purchase'] = $ticket->getId_purchase();
            $parameters['id_show'] = $ticket->getId_show();
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                throw $e;
            }
        }

        public function createWithPurchase($id_show,$tk_code,$numberOfTickets,$datePurchase,$discount,$qr,$dni){
            $sql = "CALL PROCEDURE moviepass.createTicketsAndPurchase (:id_show,:tk_code,:numberOfTickets,:datePurchase,:discount,:qr,:dni)";
            $parameters['id_show'] = $id_show;
            $parameters['tk_number'] = $tk_code;
            $parameters['numberOfTickets'] = $numberOfTickets;
            $parameters['datePurchase'] = $datePurchase;
            $parameters['discount'] = $discount;
            $parameters['qr'] = $qr;
            $parameters['dni'] = $dni;
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                throw $e;
            }
        }

        public function update($ticket)
        {
            $sql = "UPDATE tickets SET tk_code = :tk_code, id_purchase = :id_purchase, id_show = :id_show  WHERE id_ticket = :id";
            $parameters['tk_code'] = $ticket->getTk_code();
            $parameters['id_purchase'] = $ticket->getId_purchase();
            $parameters['id_show'] = $ticket->getId_show();
            $parameters['id'] = $ticket->getId_ticket();
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

        public function readAll()
        {
            $sql = "SELECT * FROM tickets";
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

        public function read ($id)
        {
            $sql = "SELECT * FROM tickets where id_ticket = :id";
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
                if(!empty($resultSet))
                    return $this->mapear($resultSet);
                else
                    return "false";
        }
        
        public function readByCode ($code)
        {
            $sql = "SELECT * FROM tickets where tk_code = :code";
            $parameters['code'] = $code;
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

        public function delete ($id)
        {
            $sql = "DELETE FROM tickets WHERE id_ticket = :id";
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
        public function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                $newTicket = new Cinema($p['tk_code'], $p['id_purchase'], $p['id_show']);
                $newTicket->setIdCinema($p['id_ticket']);
                return $newTicket;
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }
        }



?>