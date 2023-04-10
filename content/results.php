<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/search.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/genresnav.php';


require $_SERVER['DOCUMENT_ROOT'] . '/include/movie.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    isset($_SESSION['email']) ? '' : exit;
    $database = new DB;
    switch ($_POST['method']) {
        case 'wantto':
            $database->add_wish($_SESSION['email'], $_POST['wantto']);
            break;
        case 'watched':
            $database->add_review($_SESSION['email'], $_POST['watched'], 0, '');
            break;
        default:
            exit;
            break;
    }
}

$moviesAPI = new Movie;
$movies = [];
if (isset($_GET['method'])) {
    switch ($_GET['method']) {
        case 'genre':
            $movies = $moviesAPI->get_by_genre($_GET['genre']);
            break;
        case 'search':
            $movies = $moviesAPI->search($_GET['search']);
            break;
    }
} else {
    $movies = $moviesAPI->get_top();
}?>

<div id="imgcontainer">
<?php
$i = 0;
for ($row = 0; $row < sizeof($movies); $row++) {
    if ($movies[$i]['img'] != NULL) : ?>
        <div class="images">
            <img src="<?php echo $movies[$i]['img']; ?>" loading="lazy">
            <form method="POST">
                <input name="page" type='hidden' value="results">
                <input name="method" type='hidden' value="wantto">
                <button id="wantto" type="submit" name="wantto" value='<?php print $movies[$i]['id']; ?>'>Want to watch</button>
            </form>
            <form method="POST">
                <input name="page" type='hidden' value="results">
                <input name="method" type='hidden' value="watched">
                <button id="watched" type="submit" name="watched" value='' <?php print $movies[$i]['id']; ?>'>Watched</button>
            </form>
            <form method="GET">
                <input name="page" type='hidden' value="movie">
                <button id="info" type="submit" name="movie" value='<?php print $movies[$i]['id']; ?>'>Info</button>
            </form>
        </div>
<?php
    endif;
    $i++;
}
?>
</div>