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
            $database->add_review($_SESSION['email'], $_POST['watched'], 0, $_POST['review']);
            break;
        default:
            exit;
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
        default:
            $movies = $moviesAPI->get_top();
            break;
    }
} else {
    $movies = $moviesAPI->get_top();
} ?>
<div id="imgcontainer">
    <?php
    $i = 0;
    for ($row = 0; $row < sizeof($movies); $row++) {
        if ($movies[$i]['img'] != NULL): ?>
            <div class="images">
                <img src="<?php echo $movies[$i]['img']; ?>" loading="lazy">
                <form method="POST">
                    <input name="page" type='hidden' value="results">
                    <input name="method" type='hidden' value="wantto">
                    <button class="wantto" type="submit" name="wantto" value='<?php print $movies[$i]['id']; ?>'>Want to
                        watch</button>
                </form>
                <button class="watched" name="watched" value='<?php print $movies[$i]['id']; ?>'
                    onclick="displayReview('<?php print $movies[$i]['id']; ?>')" style="margin: 10px 65px;">Watched</button>
                <form method="GET">
                    <input name="page" type='hidden' value="movie">
                    <button class="info" type="submit" name="movie" value='<?php print $movies[$i]['id']; ?>'>Info</button>
                </form>
            </div>
            <?php
        endif;
        $i++;
    }
    ?>
</div>
<div id="review-modal" class="review-modal">
    <span id="close-modal" onclick="closeModal()" class="material-symbols-outlined">close</span>
    <form method="POST">
        <input name="page" type='hidden' value="results">
        <input name="method" type='hidden' value="watched">
        <input id="review-movie" name="watched" value="" type="hidden">
        <textarea name="review"></textarea>
        <button type="submit">Submit Review</button>
    </form>
</div>