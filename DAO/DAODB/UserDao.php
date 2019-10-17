<?php
namespace DAO\DAODB;
use Models\User as User;
use DAO\DAODB\Connection as Connection;
use PDOException;

class UserDao extends Singleton //implements \interfaces\Crud
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
        }
        catch(PDOException $e){
			echo $e;
		}
    }
    public function readAll()
    {
        $sql = "SELECT * FROM users";
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
    public function read ($email)
    {
        $sql = "SELECT * FROM users where email = :email";
        $parameters['email'] = $email;
        try
        {
            $this->connection = Connection::getInstance();
            $resultSet = $this->connection->execute($sql, $parameters);
        }
        catch(PDOException $e)
        {
            echo '<script>';
            echo 'console.log("Error en base de datos. Archivo: UserDao.php")';
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
    public function readById ($dni)
    {
        $sql = "SELECT * FROM users where DNI = :DNI";
        $parameters['DNI'] = $dni;
        try
        {
            $this->connection = Connection::getInstance();
            $resultSet = $this->connection->execute($sql, $parameters);
        }
        catch(PDOException $e)
        {
            echo '<script>';
            echo 'console.log("Error en base de datos. Archivo: userdao.php")';
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
    public function update ($dni,$pass)
    {
      $sql = "UPDATE users SET pass = :pass  WHERE DNI = :DNI";
      $parameters['DNI'] = $dni;
      $parameters['pass'] = $pass;
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
    public function delete ($email)
    {
        $sql = "DELETE FROM users WHERE email = :email";
        $parameters['email'] = $email;
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
		    return new User( $p['name'], $p['surname'], $p['DNI'], $p['email'],$p['pass'],$p['user_group']);
        }, $value);
            /* devuelve un arreglo si tiene datos y sino devuelve nulo*/
            return count($resp) > 1 ? $resp : $resp['0'];
     }
}