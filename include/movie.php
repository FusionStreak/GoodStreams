<?php

require(__DIR__ . '/dotenv.php');

/**
 * The base URL for any request
 * 
 * @var string
 */
define("BASE_URL", "https://moviesdatabase.p.rapidapi.com/");

class Movie
{
    /**
     * Holds the default cURL request options
     * 
     * @var (string|true|int|string[])[]
     */
    private $req_options;

    public function __construct()
    {
        // Load the API details to ENV
        (new DotEnv(__DIR__ . '/.env'))->load();

        // Set the standard cURL options
        $this->req_options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: " . getenv('API_HOST'),
                "X-RapidAPI-Key: " . getenv('API_KEY')
            ]
        ];
    }

    /**
     * Function to search for a movie by title. With optional options
     * 
     * @param string $title Title or partial title of movie
     * @param array $options Array of search options
     */
    public function search(string $title, array $options = [])
    {

        $req_url = BASE_URL . 'titles/search/title/' . $title;

        $curl = curl_init($req_url);

        curl_setopt_array($curl, $this->req_options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['err' => $err];
        } else {
            return json_decode($response, true);
        }
    }
}

echo BASE_URL . 'titles/search/title/' . 'shark ';

(new Movie())->search('shark');