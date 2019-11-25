<?php
    namespace DAO\DAODB;
    use Models\Purchase;
    use DAO\DAODB\Connection;
    use PDOException;
    use DAO\DAODB\IDao;
    class PurchaseDao extends Singleton implements IDao{
        private $connection;
        public function __construct()
        {
            $this->connection = null;
        }
        
        public function create($purchase)
        {
            $sql = "INSERT INTO purchases (id_show,purchased_tickets,date_purchase,discount,qr,dni,amount) VALUES (:id_show,:purchased_tickets,:date_purchase,:discount,:qr,:dni,:amount)";
            $parameters['id_show'] = $purchase->getId_show();
            $parameters['purchased_tickets'] = $purchase->getPurchased_tickets();
            $parameters['date_purchase'] = $purchase->getDate_purchase();
            $parameters['discount'] = $purchase->getDiscount();
            $parameters['qr'] = $purchase->getQr();
            $parameters['dni'] = $purchase->getDni();
            $parameters['amount'] = $purchase->getAmount();
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            }
            catch(PDOException $e){
                throw $e;
            }
        }

        public function createWithTickets($id_show,$tk_code,$numberOfTickets,$datePurchase,$qr,$dni,$discount,$amount){
            $sql = "CALL moviepass.createTicketsAndPurchase(:id_show,:tk_code,:numberOfTickets,:datePurchase,:discount,:qr,:dni,:amount)";
            $parameters['id_show'] = $id_show;
            $parameters['tk_code'] = $tk_code;
            $parameters['numberOfTickets'] = $numberOfTickets;
            $parameters['datePurchase'] = $datePurchase;
            $parameters['discount'] = $discount;
            $parameters['qr'] = $qr;
            $parameters['dni'] = $dni;
            $parameters['amount'] = $amount;
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
            $sql = "SELECT * FROM purchases";
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
            $sql = "SELECT * FROM purchases where id_purchase = :id";
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
                    return false;
        }

        public function readByDni($dni){
            $sql = "SELECT * FROM purchases where DNI = :dni";
            $parameters['dni'] = $dni;
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

        public function readEarningsOfMT($id_mt){
            $sql = "select p.id_purchase,p.purchased_tickets,p.id_show,p.date_purchase,p.discount,p.qr,p.DNI,sum(amount) as amount from purchases p inner join shows s on p.id_show = s.id_show where s.id_movieTheater = :id_mt group by s.id_movieTheater;";
            $parameters['id_mt'] = $id_mt;
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

        public function readEarningsOfMovie($id_movie){
            $sql = "select  p.id_purchase,p.purchased_tickets,p.id_show,p.date_purchase,p.discount,p.qr,p.DNI,sum(amount) as amount from purchases p inner join shows s on p.id_show = s.id_show where s.id_movie = :id_movie  group by s.id_movie;";
            $parameters['id_movie'] = $id_movie;
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
            $sql = "DELETE FROM purchases WHERE id_purchase = :id";
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
                $newPurchase = new Purchase($p['id_show'], $p['purchased_tickets'], $p['date_purchase'],$p['discount'], $p['qr'], $p['DNI'], $p['amount']);
                $newPurchase->setId_purchase($p['id_purchase']);
                return $newPurchase;
            }, $value);
                /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
                return count($resp) > 1 ? $resp : $resp['0'];
        }
        }



?>