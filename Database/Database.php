<?php
namespace smartCalendar\Database;
require_once "connect.php";
class Database
{
    private $database;

    public function __construct()
    {
        global $hostname;
        global $username;
        global $password;
        global $database;
        $this->database = new \mysqli($hostname,$username,$password,$database);
    }

    public function createNewUser($firstname, $lastname, $email, $password, $bio){
        if (!is_string($firstname) && !is_string($lastname) && !is_string($email) && !is_string($bio)){
            return "Input not a string";
        }
        $sanitized_firstname = htmlspecialchars($firstname);
        $sanitized_lastname = htmlspecialchars($lastname);
        $sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $sanitized_password = password_hash(htmlspecialchars($password),PASSWORD_ARGON2ID);
        $sanitized_bio = htmlspecialchars($bio);


        try {
            $this->database->query("Insert into users (firstname, lastname, email, password, bio) value ( '$sanitized_firstname', '$sanitized_lastname', '$sanitized_email', '$sanitized_password', '$sanitized_bio')");
            echo "User added!";

        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
    public function confirmUser($email, $password)
    {
        $sanitizeEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        $sanitized_password = htmlspecialchars($password);
        try {
            $query = $this->database->query("Select password from users where email = '$sanitizeEmail'");
            $databaseResponse = $query->fetch_assoc();
            $databasePassword = $databaseResponse["password"];

        } catch (\Exception $e) {
            echo $sanitizeEmail . " not in the database!";
            return;
        }

        if (password_verify($sanitized_password, $databasePassword)) {
            $result = "richtig";
        } else {
            $result = "falsch";
        }
        echo $result;
    }


}
date_default_timezone_set('Europe/Berlin');
$timestamp = mktime(18,0,0,8,12,2023);
$timestamp2 = mktime(19,0,0,8,12,2023);
// date("H") makes the 18 hours to 18:00 and date("h") -> to 6:00 because of "p.m."
$query = "Insert into events (name, info, timeBegin, timeEnd) value ('Programmieren','Projekt weiter programmieren','".date("Y-m-d H:i:s", $timestamp ). "','".date("Y-m-d H:i:sa", $timestamp2 )."')";

$test = new Database();
