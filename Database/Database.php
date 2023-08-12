<?php
namespace smartCalendar\Database;

class Database extends \mysqli
{
    private $database;
    public function __construct($hostname = "localhost", $username = "al",$password = "al",$database = "smart_calendar")
    {
        $this->database = parent::__construct($hostname, $username, $password, $database);
    }


}
date_default_timezone_set('Europe/Berlin');
$timestamp = mktime(18,0,0,8,12,2023);
$timestamp2 = mktime(19,0,0,8,12,2023);
// date("H") -> für 24h
$query = "Insert into events (name, info, timeBegin, timeEnd) value ('Programmieren','Projekt weiter programmieren','".date("Y-m-d H:i:s", $timestamp ). "','".date("Y-m-d H:i:sa", $timestamp2 )."')";
$test = new Database();
$test->query($query);