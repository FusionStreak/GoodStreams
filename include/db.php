<?php

require(__DIR__ . '/dotenv.php');

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'GoodStreams');
class DB
{
    private $db_pass;

    /**
     * Stores MySQLi connection object
     * 
     * @var \mysqli
     */
    private $conn;

    public function __construct()
    {
        // Load the API details to ENV
        (new DotEnv(__DIR__ . '/.env'))->load();
        $this->db_pass = getenv('DB_PASS');
        $this->conn = new mysqli(DB_SERVER, DB_USER, $this->db_pass);
    }

    public function initDB()
    {
        $query = 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME;

        $this->conn->query($query);
        $this->conn->select_db(DB_NAME);

        $query = 'CREATE TABLE IF NOT EXISTS Users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL UNIQUE,
            pass VARCHAR(255) NOT NULL,
            fname VARCHAR(50) NOT NULL,
            lname VARCHAR(50) NOT NULL);
            ';

        $this->conn->query($query);
    }

    public function create_user(string $email, string $pass, string $fname, string $lname): bool
    {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $values = [$email, $hashed, $fname, $lname];
        for ($i = 0; $i < count($values); $i++) {
            $values[$i] = '"' . $values[$i] . '"';
        }
        $values = implode(', ', $values);

        $query = 'INSERT INTO Users (email, pass, fname, lname) VALUES (' . $values . ');';

        return $this->conn->query($query);
    }

    public function login(string $email, string $pass): bool
    {
        $email = '"' . $email . '"';

        $query = "SELECT email, pass FROM Users WHERE email=" . $email;

        $result = $this->conn->query($query)->fetch_assoc();

        return password_verify($pass, $result['pass']);
    }

    private function closeDB()
    {
    }
}
