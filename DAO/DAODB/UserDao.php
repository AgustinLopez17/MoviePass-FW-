<?php
namespace DAO\DAODB;

use Models\User as User;
use DAO\DAODB\Connection as Connection;
use PDOException;
use DAO\DAODB\IDao as IDao;
class UserDao extends Singleton implements IDao
{
    private $connection;
    public function __construct()
    {
        $this->connection = null;
    }
    public function create($user)
    {
        $sql = "INSERT INTO users (name, surname, DNI, email, pass, user_group) VALUES (:name, :surname, :DNI, :email, :pass, :user_group)";
        $parameters['name'] = $user->getFirstName();
        $parameters['surname'] = $user->getSurName();
        $parameters['DNI'] = $user->getDni();
        $parameters['email'] = $user->getEmail();
        $parameters['pass'] = $user->getPass();
        $parameters['user_group'] = $user->getGroup();
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    public function readAll()
    {
        $sql = "SELECT * FROM users";
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
    public function read($email)
    {
        $sql = "SELECT * FROM users where email = :email";
        $parameters['email'] = $email;
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
    public function readById($dni)
    {
        $sql = "SELECT * FROM users where DNI = :DNI";
        $parameters['DNI'] = $dni;
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
    public function update($firstName, $surname, $dni)
    {
        $sql = "UPDATE users SET name = :firstName, surname = :surname WHERE DNI = :DNI";
        $parameters['DNI'] = $dni;
        $parameters['firstName'] = $firstName;
        $parameters['surname'] = $surname;
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    public function delete($email)
    {
        $sql = "DELETE FROM users WHERE email = :email";
        $parameters['email'] = $email;
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
            return new User($p['name'], $p['surname'], $p['DNI'], $p['email'], $p['pass'], $p['user_group']);
        }, $value);
        /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
