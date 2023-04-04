<?php

require(__DIR__ . '/dotenv.php');

/**
 * The base URL for any request
 * 
 * @var string
 */
define("BASE_URL", "https://moviesdatabase.p.rapidapi.com/");

/**
 * Generates a date string from the date structure provided by Moviesdatabase
 * 
 * @param array $date The date structure
 * 
 * @return string The date string
 */
function gen_date(array $date): string
{
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $date = $months[$date['month']] . ' ' . $date['day'] . ', ' . $date['year'];

    return $date;
}

/**
 * Extracts the basic info from a result node
 * 
 * @param array $string The result node
 * 
 * @return array The extracted information
 */
function get_basic_info(array $result): array
{
    $cleaned = []; // Holds the cleaned data
    $cleaned['id'] = $result['id'];  // Retreive ID
    $cleaned['title'] = $result['titleText']['text']; // Retrieve Title
    $cleaned['img'] = $result['primaryImage']['url'] ? $result['primaryImage']['url'] : NULL; // Retrieve link to poster img
    $cleaned['date'] = $result['releaseDate'] ? gen_date($result['releaseDate']) : NULL; // Retrieve and parse release date

    return $cleaned;
}

/**
 * Extracts multiple results in an array, from a search
 * 
 * @param array $results The results array
 * 
 * @return array The parsed results array
 */
function exctract_results(array $results): array
{
    $extracted = []; // Holds the final extracted data

    foreach ($results as $result) { // For each movie in list
        $cleaned = get_basic_info($result);
        array_push($extracted, $cleaned); // Push to extracted
    }

    return $extracted;
}

/**
 * Extract info from a single movie
 * 
 * @param array $result The result to be parsed
 * 
 * @return array The extracted information
 */
function extract_single(array $result): array
{
    $cleaned = get_basic_info($result);
    $cleaned['cast'] = [];

    foreach ($result['cast'] as $cast) {
        array_push($cleaned['cast'], $cast['node']['name']['nameText']['text']);
    }

    return $cleaned;
}

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

        $req_url = BASE_URL . 'titles/search/title/' . $title . '?titleType=movie&limit=50&sort=year.decr';

        $curl = curl_init($req_url);

        curl_setopt_array($curl, $this->req_options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['err' => $err];
        } else {
            return exctract_results(json_decode($response, true)['results']);
        }
    }

    /**
     * Retrieve movie details by id
     * 
     * @param string $id The id of the movie
     * 
     * @return mixed The movie details, or error
     */
    public function get_by_id(string $id)
    {
        // Get basic info
        $req_url = BASE_URL . 'titles/' . $id;
        $curl = curl_init($req_url);
        curl_setopt_array($curl, $this->req_options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ['err' => $err];
        }
        $result = json_decode($response, true)['results'];

        // Get cast info
        $req_url = BASE_URL . 'titles/' . $id . '?info=extendedCast';
        $curl = curl_init($req_url);
        curl_setopt_array($curl, $this->req_options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ['err' => $err];
        }
        $result['cast'] = json_decode($response, true)['results']['cast']['edges'];

        return extract_single($result);
    }
}
