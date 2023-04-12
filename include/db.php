<?php

define('DB_SERVER', 'localhost');
define('DB_NAME', 'GoodStreams');

/**
 * Class to allow website to communicate with Database for user generated content
 * 
 * Requires `DP_PASS` and `DB_USER` to be defined in `include/.env`
 */
class DB
{
    /**
     * Stores MySQLi connection object
     * 
     * @var \mysqli
     */
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(DB_SERVER, 'root');

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

        // Create Users_Token table, if it does not exist
        $query = 'CREATE TABLE IF NOT EXISTS Users_Token (
            user_id INT UNSIGNED,
            token VARCHAR(255) NOT NULL,
            expiry DATE,
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            PRIMARY KEY (user_id, token)
            );';
        $this->conn->query($query);

        // Create Movie table, if it does not exist
        $query = 'CREATE TABLE IF NOT EXISTS Movies (
            movie_id VARCHAR(10) NOT NULL PRIMARY KEY
            );';
        $this->conn->query($query);

        // Create Reviews relation table, if it does not exist
        $query = 'CREATE TABLE IF NOT EXISTS Reviews (
            user_id INT UNSIGNED,
            movie_id VARCHAR(10),
            rating INT(1) UNSIGNED,
            review VARCHAR(512),
            date DATE DEFAULT current_timestamp(),
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            FOREIGN KEY (movie_id) REFERENCES Movies(movie_id),
            PRIMARY KEY (user_id, movie_id)
            );';
        $this->conn->query($query);

        // Create Wishlists table
        $query = 'CREATE TABLE IF NOT EXISTS Wishlists (
            user_id INT UNSIGNED,
            movie_id VARCHAR(10),
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            FOREIGN KEY (movie_id) REFERENCES Movies(movie_id),
            PRIMARY KEY (user_id, movie_id)
            );';
        $this->conn->query($query);
    }

    /**
     * Retrieve basic info on a user
     * 
     * @param string $email The email address of the user
     * 
     * @return array|false|null The user info, or false/null if not found
     */
    private function get_user(string $email)
    {
        $query = 'SELECT user_id, email FROM Users WHERE email=?';

        $result = $this->conn->execute_query($query, [$email])->fetch_assoc();

        unset($result['pass']);

        return $result;
    }

    /**
     * Inserts a movie_id in database
     * @param string $movie_id The movie id
     * @return void
     */
    private function insert_movie(string $movie_id)
    {
        $query = 'INSERT IGNORE INTO Movies (movie_id) VALUES (?)';

        $this->conn->execute_query($query, [$movie_id]);
    }

    /**
     * Insert a user token into the DB for verification
     * 
     * @param string $email The user's email address
     * @param string $token The user's session token
     */
    private function insert_token(string $email, $token)
    {
        $user = $this->get_user($email);

        $query = 'INSERT INTO Users_Token (user_id, token) VALUES (?, ?);';
        $this->conn->execute_query($query, [$user['user_id'], $token]);
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

        $query = 'REPLACE INTO Users (email, pass, uname) VALUES (?, ?, ?);';

        return $this->conn->execute_query($query, $values);
    }

    /**
     * Authenticates a user based on email and password
     * 
     * @param string $email The provided email
     * @param string $pass The provided password
     * 
     * @return string|bool If successful login, return token. Else return `false`
     */
    public function login(string $email, string $pass): mixed
    {
        $query = "SELECT email, pass FROM Users WHERE email=?";

        $result = $this->conn->execute_query($query, [$email])->fetch_assoc();

        if (password_verify($pass, $result['pass']) && $email === $result['email']) {
            $token = bin2hex(random_bytes(16));
            $this->insert_token($email, $token);
            return $token;
        }
        return false;
    }

    /**
     * Verify a given token and email combination against the database
     * 
     * @param string $email The user's email address
     * @param string $token The supplied token
     * 
     * @return bool Whether this combination is valid
     */
    public function verify_token($email, $token): bool
    {
        $user = $this->get_user($email);
        $query = 'SELECT user_id, token FROM Users_Token WHERE user_id = ? AND token = ?;';
        return $this->conn->execute_query($query, [$user['user_id'], $token]) ? true : false;
    }

    /**
     * Removes a user session token
     * 
     * @param string $email The user's email address
     * @param string $token The supplied token
     */
    public function logout($email, $token)
    {
        if ($this->verify_token($email, $token)) {
            $user = $this->get_user($email);
            $query = 'DELETE FROM Users_Token WHERE user_id = ? AND token = ?;';
            $this->conn->execute_query($query, [$user['user_id'], $token]);
        }
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
        $this->insert_movie($movie_id);
        $user = $this->get_user($email);

        $query = 'REPLACE INTO Wishlists (user_id, movie_id) VALUES (?, ?);';

        $result = $this->conn->execute_query($query, [$user['user_id'], $movie_id]);

        return $result ? true : false;
    }

    /**
     * Removes a movie for a user's wishlist
     * 
     * @param string $email The user's email address
     * @param string $movie_id The id of the movie they are removing
     * 
     * @return bool Whether the action was successful
     */
    public function remove_wish(string $email, string $movie_id): bool
    {
        $user = $this->get_user($email);

        $query = 'DELETE FROM Wishlists WHERE user_id = ? AND movie_id = ?;';

        $result = $this->conn->execute_query($query, [$user['user_id'], $movie_id]);

        return $result ? true : false;
    }

    /**
     * Retrieve a user's wishlist
     * 
     * @param string $email The user's email address
     * 
     * @return array of movie ids
     */
    public function get_user_wishlist(string $email)
    {

        $user = $this->get_user($email);

        $query = "SELECT movie_id FROM Wishlists WHERE user_id = ?";

        $results = $this->conn->execute_query($query, [$user['user_id']])->fetch_all();

        $result = [];

        foreach ($results as $res) {
            if (!in_array($res[0], $result)) {
                array_push($result, $res[0]);
            }
        }

        return $result;
    }

    /**
     * Add a review to a movie
     * 
     * @param string $email The user's email address
     * @param string $movie_id The id of the movie being reviewed
     * @param string $rating The numerical rating of the review, [0, 10]
     * @param string $review The text review, maximum 512 characters
     * 
     * @return bool Whether the action was successful
     */
    public function add_review(string $email, string $movie_id, int $rating, string $review): bool
    {
        $this->insert_movie($movie_id);
        $this->remove_wish($email, $movie_id);
        $user = $this->get_user($email);

        $query = 'REPLACE INTO Reviews (user_id, movie_id, rating, review) VALUES (?, ?, ?, ?);';

        $result = $this->conn->execute_query($query, [$user['user_id'], $movie_id, $rating, $review]);

        return $result ? true : false;
    }

    /**
     * Update an existing review
     * 
     * @param string $email The user's email address
     * @param string $movie_id The id of the movie being reviewed
     * @param string $rating The updated numerical rating, [0, 10]
     * @param string $review The updated text review, maximum 512 characters
     * 
     * @return bool Whether the action was successful
     */
    public function update_review(string $email, string $movie_id, int $rating, string $review): bool
    {
        $user = $this->get_user($email);

        $query = 'UPDATE Reviews SET rating = ?, review = ? WHERE user_id = ? AND movie_id = ?;';

        $result = $this->conn->execute_query($query, [$rating, $review, $user['user_id'], $movie_id]);

        return $result ? true : false;
    }

    /**
     * Get an array of reviews the user has made
     * @param string $email The user's email address
     * @return array The reviews made by the user
     */
    public function get_user_reviews(string $email): array
    {
        $user = $this->get_user($email);

        $query = "SELECT * FROM Reviews WHERE user_id = ?";

        $results = $this->conn->execute_query($query, [$user['user_id']])->fetch_all();

        $result = [];

        foreach ($results as $res) {
            unset($res[0]);
            array_push($result, $res);
        }

        return $result;
    }

    /**
     * Get an array of reviews made for a movie
     * @param string $movie_id The movie's id
     * @return array The movie's reviews
     */
    public function get_movie_reviews(string $movie_id): array
    {
        $query = "SELECT * FROM Reviews WHERE movie_id = ?";

        $results = $this->conn->execute_query($query, [$movie_id])->fetch_all();

        $result = [];

        foreach ($results as $res) {
            array_push($result, $res[0]);
        }

        return $result;
    }

    /**
     * Removes a review from a movie
     * 
     * @param string $email The user's email address
     * @param string $movie_id The id of the movie
     * 
     * @return bool Whether the action was successful
     */
    public function remove_review(string $email, string $movie_id)
    {
        $user = $this->get_user($email);

        $query = 'DELETE FROM Reviews WHERE user_id = ? AND movie_id = ?;';

        $result = $this->conn->execute_query($query, [$user['user_id'], $movie_id]);

        return $result ? true : false;
    }
}