<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';


require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
$moviesAPI = new Movie;
$movies = [];
if ($_GET['method'] == 'genre') {
    $movies = $moviesAPI->get_by_genre($_GET['genre']);
} elseif ($_GET['method'] == 'top') {
    $movies = $moviesAPI->get_top();
} elseif ($_GET['method'] == 'search') {
    $movies = $moviesAPI->search($_GET['search']);
}
$i = 0;
for ($row = 0; $row < sizeof($movies); $row++) {
    if ($movies[$i]['img'] != NULL) : ?>
        <div class="images">
            <img src="<?php echo $movies[$i]['img']; ?>" loading="lazy">
            <button id="wantto">Want to watch</button>
            <button id="watched">Watched</button>
            <button id="info">Info</button>
        </div>
<?php
    endif;
    $i++;
}
?>