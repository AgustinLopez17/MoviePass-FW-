<?php namespace DAO;
use Models\User;
interface IRepository {

    function Add($value);
    function GetAll();
    function Delete($value);
    
}