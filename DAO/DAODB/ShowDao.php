<?php
    namespace DAO\DAODB;

    use Models\Show as Show;
    use DAO\DAODB\Connection as Connection;
    use PDOException;
    use DAO\DAODB\IDao;
    class ShowDao extends Singleton implements IDao
    {
        private $connection;

        public function __construct()
        {
            $this->connection = null;
        }

        public function create($show)
        {
            $sql = "INSERT INTO shows (show_date,id_cinema,id_movie,id_movieTheater,total_tickets,tickets_sold,ticket_price) VALUES (:show_date,:id_cinema,:id_movie,:id_movieTheater,:total_tickets,:tickets_sold,:ticket_price)";
            $parameters['show_date'] = $show->getDate()->format("Y-m-d H:i");
            $parameters['id_cinema'] = $show->getId_cinema();
            $parameters['id_movie'] = $show->getId_movie();
            $parameters['id_movieTheater'] = $show->getId_movieTheater();
            $parameters['total_tickets'] = $show->getTotal_tickets();
            $parameters['tickets_sold'] = $show->getTickets_sold();
            $parameters['ticket_price'] = $show->getTicket_price();
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
        }

        public function update($id_show, $id_movie, $id_cinema, $show_date)
        {
            $sql = "UPDATE shows SET id_movie = :id_movie, id_cinema = id_cinema, show_date = :show_date WHERE id_show = :id_show";
            $parameters['id_movie'] = $id_movie;
            $parameters['id_cinema'] = $id_cinema;
            $parameters['show_date'] = $show_date;
            $parameters['id_show'] = $id_show;
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
        }

        public function updateTksSold($tickets_sold,$id_show){
            $sql = "UPDATE shows SET tickets_sold = :tickets_sold WHERE id_show = :id_show";
            $parameters['tickets_sold'] = $tickets_sold;
            $parameters['id_show'] = $id_show;
            try {
                $this->connection = Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
        }



        public function readAll()
        {
            $sql = "SELECT * FROM shows";
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
            $sql = "SELECT * FROM shows where id_show = :id";
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

        public function salesOfMT($id_mt){
            $sql= "select id_show,show_date,id_cinema,id_movieTheater,id_movie,total_tickets,ticket_price,sum(tickets_sold) as tickets_sold from shows where id_movieTheater = :id_mt group by id_movieTheater;";
            $parameters['id_mt'] = $id_mt;
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

        public function remnantsOfMT($id_mt){
            $sql= "select id_show,show_date,id_cinema,id_movieTheater,id_movie,sum(total_tickets) as total_tickets,ticket_price,sum(tickets_sold) as tickets_sold from shows where id_movieTheater = :id_mt;";
            $parameters['id_mt'] = $id_mt;
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

        public function salesOfMovie($id_movie){
            $sql= "select id_show,show_date,id_cinema,id_movieTheater,id_movie,total_tickets,ticket_price,sum(tickets_sold) as tickets_sold from shows where shows.id_movie = :id_movie group by shows.id_movie;";
            $parameters['id_movie'] = $id_movie;
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

        public function remnantsOfMovie($id_movie){
            $sql= "select id_show,show_date,id_cinema,id_movieTheater,id_movie,sum(total_tickets) as total_tickets,ticket_price,sum(tickets_sold) as tickets_sold from shows where id_movie = :id_movie;";
            $parameters['id_movie'] = $id_movie;
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

        public function readByMovieAndDate($id_movie, $date)
        {
            $sql = "SELECT * FROM shows where id_movie = :id_movie and date(show_date) = :newDate  ";
            $parameters['id_movie'] = $id_movie;
            $parameters['newDate'] = $date->format('Y-m-d');
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->executeNonQuery2($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return "false";
            }
        }

        public function readByMovieAndMT($id_movie,$id_mt){
            $sql = "SELECT s.id_show,s.show_date,s.id_cinema,s.id_movieTheater,s.id_movie,s.total_tickets,s.ticket_price,s.tickets_sold FROM shows s INNER JOIN cinemas c ON s.id_cinema = c.id_cinema where c.available = 1 AND s.id_movie = :id_movie AND s.id_movieTheater = :id_MT";
            $parameters['id_movie'] = $id_movie;
            $parameters['id_MT'] = $id_mt;
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->executeNonQuery2($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return "false";
            }
        }

        public function readByCinemaAndDate($id_cinema, $date)
        {
            $sql = "SELECT * FROM shows where id_cinema = :id_cinema and date(show_date) = :newDate";
            $parameters['id_cinema'] = $id_cinema;
            $parameters['newDate'] = $date->format('Y-m-d');
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->executeNonQuery2($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return "false";
            }
        }

        public function readByMTAndDate($id_movieTheater, $date)
        {
            $sql = "SELECT * FROM shows where id_movieTheater = :id_movieTheater and date(show_date) = :newDate";
            $parameters['id_movieTheater'] = $id_movieTheater;
            $parameters['newDate'] = $date->format('Y-m-d');
            try {
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->executeNonQuery2($sql, $parameters);
            } catch (PDOException $e) {
                throw $e;
            }
            if (!empty($resultSet)) {
                return $this->mapear($resultSet);
            } else {
                return "false";
            }
        }

        public function delete ($id)
        {
            $sql = "DELETE FROM shows WHERE id_show = :id";
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

        public function mapear($value)
        { //TRAIGO VALORES DE LA BASE DE DATOS PARA USAR EN LA WEB (CREAR OBJETOS)
            $value = is_array($value) ? $value : [];
            $resp = array_map(function ($p) {
                $newShow = new Show($p['show_date'], $p['id_cinema'], $p['id_movie'], $p['id_movieTheater'],$p['total_tickets'], $p['tickets_sold'], $p['ticket_price']);
                $newShow->setId_show($p['id_show']);
                return $newShow;
            }, $value);
            /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
