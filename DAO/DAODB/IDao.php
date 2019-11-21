<?php namespace DAO\DAODB;

interface IDao {

    function create($value);
    function readAll();
    function read($value);
    function delete($value);
    function mapear($value);
    
}