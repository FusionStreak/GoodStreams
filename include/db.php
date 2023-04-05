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

        $this->initDB();
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    /**
     * Creates the Database and necessary tables required for the application,
     * if they do not exist
     */
    private function initDB()
    {
        // Create the Database with the name defined as `DB_NAME`, if it does no exsist
        $query = 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME;

        $this->conn->query($query);

        // Now that the DB is created, switch to it
        $this->conn->select_db(DB_NAME);

        // Create User table, if it does not exist
        $query = 'CREATE TABLE IF NOT EXISTS Users (
            user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL UNIQUE,
            pass VARCHAR(255) NOT NULL,
            uname VARCHAR(50) NOT NULL
            );';
        $this->conn->query($query);

        // Create Movie table, if it does not exist
        $query = 'CREATE TABLE IF NOT EXISTS Movies (
            movie_id VARCHAR(10) NOT NULL PRIMARY KEY
            );';
        $this->conn->query($query);

        // Create Reviews relation table, if it does not exist
        $query = 'CREATE TABLE IF NOT EXISTS Reviews (
            review_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED,
            movie_id VARCHAR(10),
            rating INT(1) UNSIGNED,
            review VARCHAR(512),
            date DATE DEFAULT current_timestamp(),
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            FOREIGN KEY (movie_id) REFERENCES Movies(movie_id)
            );';
        $this->conn->query($query);

        // Create Wishlists table
        $query = 'CREATE TABLE IF NOT EXISTS Wishlists (
            wish_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED,
            movie_id VARCHAR(10),
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            FOREIGN KEY (movie_id) REFERENCES Movies(movie_id)
            );';
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

    /**
     * Adds a movie to a user's wishlist
     * 
     * @param string $email The user's email address
     * @param string $movie_id The id of the movie they are adding
     * 
     * @return bool Whether action was successful
     */
    public function add_wish(string $email, string $movie_id): bool
    {

    }

    /**
     * Removes a movie for a user's wishlist
     * 
     * @param $email
     */
    public function remove_wish(string $email, string $movie_id)
    {

    }

    public function add_review(string $email, string $movie_id, int $rating, string $review)
    {

    }

    public function update_review(string $email, string $movie_id, int $rating, string $review)
    {

    }

    public function remove_review(string $email, string $movie_id)
    {

    }
}