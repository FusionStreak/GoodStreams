<?php

require(__DIR__ . '/dotenv.php');

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'GoodStreams');

/**
 * Class to allow website to communicate with Database for user generated content
 */
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

    /**
     * Creates the Database and necessary tables required for the application,
     * if they do not exist
     */
    public function initDB()
    {
        // Create the Database with the name defined as `DB_NAME`, if it does no exsist
        $query = 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME;

        $this->conn->query($query);

        // Now that the DB is created, switch to it
        $this->conn->select_db(DB_NAME);

        // Create User table, if it does not exist
        $query = 'CREATE TABLE IF NOT EXISTS Users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL UNIQUE,
            pass VARCHAR(255) NOT NULL,
            uname VARCHAR(50) NOT NULL,;
            ';

        $this->conn->query($query);
    }

    /**
     * Function to create a new user entry in DB
     * 
     * @param string $email The email of the user, will be used as the username
     * @param string $pass The Password of the user, this will be hashed
     * @param string $uname The name of the user
     * 
     * @return bool Whether the user was successfully created
     */
    public function create_user(string $email, string $pass, string $uname): bool
    {
        // Hash the password
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        $values = [$email, $hashed, $uname];

        $query = 'INSERT INTO Users (email, pass, uname) VALUES (?, ?, ?);';

        return $this->conn->execute_query($query, $values);
    }

    /**
     * Authenticates a user based on email and password
     * 
     * @param string $email The provided email
     * @param string $pass The provided password
     * 
     * @return bool Whether the the provided data successfully matched
     */
    public function login(string $email, string $pass): bool
    {
        $query = "SELECT email, pass FROM Users WHERE email=?";

        $result = $this->conn->execute_query($query, [$email])->fetch_assoc();

        return password_verify($pass, $result['pass']) && $email === $result['email'];
    }

    private function closeDB()
    {
    }
}
